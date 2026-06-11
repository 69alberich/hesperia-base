<?php namespace HesperiaPlugins\Hoteles\Services;

use DB;
use HesperiaPlugins\Hoteles\Dtos\CurrencyDto;
use HesperiaPlugins\Hoteles\Dtos\DateRangeDto;
use HesperiaPlugins\Hoteles\Dtos\DiscountDto;
use HesperiaPlugins\Hoteles\Dtos\RateDto;
use HesperiaPlugins\Hoteles\Dtos\RoomAvailabilityDto;
use HesperiaPlugins\Hoteles\Models\Habitacion;
use HesperiaPlugins\Hoteles\Models\Moneda;
use Illuminate\Support\Collection;

/**
 * Service responsible for querying room availability and pricing.
 *
 * This class extracts and centralises logic that was previously scattered across:
 *   - Habitacion::getPrecios()
 *   - Habitacion::getCantidadDisponible()
 *   - Habitacion::getDescuentos()
 *   - Habitacion::getPrecioConImpuestos()
 *   - Fecha::buscarDisponibilidad()
 *
 * It has no dependency on Session, HTTP requests, or OctoberCMS components,
 * making it straightforward to unit-test and reuse from any context.
 *
 * Example usage from an OctoberCMS component:
 *
 *   $service   = new AvailabilityService();
 *   $dateRange = new DateRangeDto('2026-07-10', '2026-07-15');
 *   $result    = $service->getRoomAvailability(roomId: 5, dateRange: $dateRange, currencyId: 1);
 *
 *   return $result->toArray(); // ready for AJAX / JSON response
 */
class AvailabilityService
{
    // -------------------------------------------------------------------------
    // Public API
    // -------------------------------------------------------------------------

    /**
     * Returns the full availability picture for a single room over a date range.
     *
     * @param  int           $roomId     Primary key of the room (habitacion).
     * @param  DateRangeDto  $dateRange  Validated check-in / check-out range.
     * @param  int           $currencyId Primary key of the currency (moneda).
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  if room not found.
     */
    public function getRoomAvailability(
        int $roomId,
        DateRangeDto $dateRange,
        int $currencyId
    ): RoomAvailabilityDto {
        // Single eager-loaded query — avoids the N+1 pattern present in the
        // original code where hotel, regimenes, and impuestos were loaded lazily
        // inside loops.
        $room = Habitacion::with([
            'hotel.regimenes',
            'hotel.impuestos',
            'descuentosHabitacion.descuento',
        ])->findOrFail($roomId);

        $availableUnits = $this->queryAvailableUnits($roomId, $dateRange);
        $isAvailable    = $availableUnits > 0;

        $rates     = $isAvailable ? $this->buildRates($room, $dateRange, $currencyId) : [];
        $discounts = $isAvailable ? $this->buildDiscounts($room, $dateRange)          : [];
        $currency  = $this->buildCurrencyDto($currencyId);

        return new RoomAvailabilityDto(
            roomId:         $roomId,
            roomName:       $room->nombre,
            isAvailable:    $isAvailable,
            availableUnits: $availableUnits,
            dateRange:      $dateRange,
            currency:       $currency,
            rates:          $rates,
            discounts:      $discounts,
        );
    }

    // -------------------------------------------------------------------------
    // Availability
    // -------------------------------------------------------------------------

    /**
     * Returns the minimum number of available units across every night in the range.
     *
     * A value of 0 means the room is fully booked for at least one night.
     * Uses a single parameterised query — no string interpolation.
     */
    private function queryAvailableUnits(int $roomId, DateRangeDto $dateRange): int
    {
        $result = DB::table('hesperiaplugins_hoteles_fechas')
            ->where('habitacion_id', $roomId)
            ->whereBetween('fecha', [$dateRange->checkinSql(), $dateRange->lastNightSql()])
            ->min('disponible');

        return (int) ($result ?? 0);
    }

    /**
     * Returns per-day price events for FullCalendar, grouped so there is exactly
     * one event per day. Each event carries the full list of occupancy prices in
     * extendedProps so the frontend can filter by occupancy without re-fetching.
     *
     * For each (date, occupancy) pair the cheapest available board plan is used,
     * with hotel taxes already applied.
     *
     * Event shape:
     *   start           – "YYYY-MM-DD"
     *   allDay          – true
     *   backgroundColor – "transparent"  (cell color comes from the availability background event)
     *   borderColor     – "transparent"
     *   extendedProps:
     *     availability  – int, units available that day
     *     prices        – array of { occupancy, label, price, currency }
     *
     * @return array<int, array<string, mixed>>
     */
    public function getDailyPrices(int $roomId, DateRangeDto $dateRange, int $currencyId): array
    {
        $room = Habitacion::with(['hotel.regimenes', 'hotel.impuestos'])
            ->findOrFail($roomId);

        $hotelRegimenIds = $room->hotel->regimenes->pluck('id')->toArray();

        if (empty($hotelRegimenIds)) {
            return [];
        }

        $taxes    = $room->hotel->impuestos->where('moneda_id', $currencyId);
        $currency = Moneda::findOrFail($currencyId);

        // Cheapest board per (date, occupancy) — availability included to avoid a second query.
        $rows = DB::table('hesperiaplugins_hoteles_fechas as f')
            ->select('f.fecha', 'f.disponible', 'pf.ocupacion', DB::raw('MIN(pf.precio) as min_price'))
            ->join('hesperiaplugins_hoteles_precios_fechas as pf', 'f.id', '=', 'pf.fecha_id')
            ->join('hesperiaplugins_hoteles_regimen as r', 'pf.regimen_id', '=', 'r.id')
            ->where('f.habitacion_id', $roomId)
            ->where('pf.moneda_id', $currencyId)
            ->where('r.status', 1)
            ->where('f.disponible', '>', 0)
            ->where('pf.precio', '>', 0)
            ->whereBetween('f.fecha', [$dateRange->checkinSql(), $dateRange->lastNightSql()])
            ->whereIn('pf.regimen_id', $hotelRegimenIds)
            ->groupBy('f.fecha', 'f.disponible', 'pf.ocupacion')
            ->orderBy('f.fecha')
            ->orderBy('pf.ocupacion')
            ->get();

        // Group rows by date so each day becomes a single FullCalendar event.
        $byDate = [];
        foreach ($rows as $row) {
            $priceWithTax = $this->applyTaxes((float) $row->min_price, $taxes);

            if (!isset($byDate[$row->fecha])) {
                $byDate[$row->fecha] = [
                    'availability' => (int) $row->disponible,
                    'prices'       => [],
                ];
            }

            $byDate[$row->fecha]['prices'][] = [
                'occupancy' => $row->ocupacion,
                'label'     => RateDto::buildOccupancyLabel($row->ocupacion),
                'price'     => round($priceWithTax, 2),
                'currency'  => $currency->acronimo,
            ];
        }

        return array_values(array_map(
            fn($date, $data) => [
                'start'           => $date,
                'allDay'          => true,
                'backgroundColor' => 'transparent',
                'borderColor'     => 'transparent',
                'extendedProps'   => $data,
            ],
            array_keys($byDate),
            array_values($byDate)
        ));
    }

    // -------------------------------------------------------------------------
    // Rates
    // -------------------------------------------------------------------------

    /**
     * Builds the list of applicable rates for the room grouped by occupancy + board.
     *
     * Extracts the logic of Habitacion::getPrecios() into a clean, side-effect-free
     * method that applies hotel taxes and returns typed DTOs instead of a raw array.
     *
     * @return RateDto[]
     */
    private function buildRates(Habitacion $room, DateRangeDto $dateRange, int $currencyId): array
    {
        $hotelRegimenIds = $room->hotel->regimenes->pluck('id')->toArray();

        if (empty($hotelRegimenIds)) {
            return [];
        }

        $rows = DB::table('hesperiaplugins_hoteles_fechas as f')
            ->select(
                'pf.ocupacion',
                'pf.regimen_id',
                'pf.precio',
                'r.nombre as regimen_name',
                'r.descripcion as regimen_description',
                'f.fecha'
            )
            ->join('hesperiaplugins_hoteles_precios_fechas as pf', 'f.id', '=', 'pf.fecha_id')
            ->join('hesperiaplugins_hoteles_regimen as r', 'pf.regimen_id', '=', 'r.id')
            ->where('f.habitacion_id', $room->id)
            ->where('pf.moneda_id', $currencyId)
            ->where('r.status', 1)
            ->where('f.disponible', '>', 0)
            ->whereBetween('f.fecha', [$dateRange->checkinSql(), $dateRange->lastNightSql()])
            ->whereIn('pf.regimen_id', $hotelRegimenIds)
            ->orderBy('pf.ocupacion')
            ->orderBy('pf.regimen_id')
            ->get();

        $taxes = $room->hotel->impuestos->where('moneda_id', $currencyId);

        return $this->aggregateRates($rows, $taxes, $dateRange);
    }

    /**
     * Groups raw price rows by occupancy+board, sums the nightly prices, and applies
     * hotel taxes. Flags rates that do not cover every requested night.
     *
     * @param  Collection  $rows   Raw DB rows from buildRates().
     * @param  Collection  $taxes  Hotel tax records for the selected currency.
     * @return RateDto[]
     */
    private function aggregateRates(Collection $rows, Collection $taxes, DateRangeDto $dateRange): array
    {
        $nights = $dateRange->nights();

        // Group by a composite key so each occupancy+board ends up in its own bucket.
        $grouped = [];
        foreach ($rows as $row) {
            $key = $row->ocupacion . '-' . $row->regimen_id;

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'occupancy'          => $row->ocupacion,
                    'board_id'           => $row->regimen_id,
                    'board_name'         => $row->regimen_name,
                    'board_description'  => $row->regimen_description ?: null,
                    'subtotal'           => 0.0,
                    'night_count'        => 0,
                    'has_zero_price'     => false,
                ];
            }

            if ($row->precio > 0) {
                $grouped[$key]['subtotal']    += (float) $row->precio;
                $grouped[$key]['night_count'] += 1;
            } else {
                $grouped[$key]['has_zero_price'] = true;
            }
        }

        $rates = [];
        foreach ($grouped as $data) {
            $subtotalWithTax = $this->applyTaxes($data['subtotal'], $taxes);
            $coversAllNights = !$data['has_zero_price'] && ($data['night_count'] === $nights);

            $rates[] = new RateDto(
                occupancy:        $data['occupancy'],
                occupancyLabel:   RateDto::buildOccupancyLabel($data['occupancy']),
                boardId:          $data['board_id'],
                boardName:        $data['board_name'],
                boardDescription: $data['board_description'],
                total:            round($subtotalWithTax, 2),
                coversAllNights:  $coversAllNights,
            );
        }

        return $rates;
    }

    /**
     * Applies the hotel's tax rates to a base price.
     * Mirrors Habitacion::getPrecioConImpuestos() without the mixed type handling.
     */
    private function applyTaxes(float $basePrice, Collection $taxes): float
    {
        $total = $basePrice;

        foreach ($taxes as $tax) {
            $total += $basePrice * ($tax->valor / 100);
        }

        return $total;
    }

    // -------------------------------------------------------------------------
    // Discounts
    // -------------------------------------------------------------------------

    /**
     * Returns all discounts applicable to the room for the given date range.
     *
     * Delegates eligibility checking to DescuentoHabitacion::getDescuentoDisponible(),
     * keeping the existing business rules in place while returning typed DTOs.
     *
     * @return DiscountDto[]
     */
    private function buildDiscounts(Habitacion $room, DateRangeDto $dateRange): array
    {
        // Build the "propiedades" array that the legacy eligibility methods expect.
        // As we refactor, this bridge will shrink until it can be removed entirely.
        $propiedades = [
            'checkin'  => $dateRange->checkinSql(),
            'checkout' => $dateRange->checkoutSql(),
        ];

        $discounts = [];

        foreach ($room->descuentosHabitacion as $descuentoHabitacion) {
            $descuento = $descuentoHabitacion->getDescuentoDisponible($propiedades);

            if ($descuento === null) {
                continue;
            }

            $discounts[] = new DiscountDto(
                id:         $descuento->id,
                percentage: (float) $descuento->porcentaje,
                concept:    $descuento->concepto,
                promoCode:  $descuento->codigo_promocional ?: null,
                freeNights: (int) $descuento->noches_gratis,
            );
        }

        return $discounts;
    }

    // -------------------------------------------------------------------------
    // Calendar / Daily Availability
    // -------------------------------------------------------------------------

    /**
     * Returns the distinct currencies used by a hotel, derived from the price
     * records of all its rooms. This works regardless of whether the hotel has
     * tax (impuesto) records configured.
     *
     * @return array<int, array{id: int, name: string, acronym: string}>
     */
    public function getHotelCurrencies(int $hotelId): array
    {
        $currencyIds = DB::table('hesperiaplugins_hoteles_precios_fechas as pf')
            ->join('hesperiaplugins_hoteles_fechas as f', 'pf.fecha_id', '=', 'f.id')
            ->join('hesperiaplugins_hoteles_habitaciones as h', 'f.habitacion_id', '=', 'h.id')
            ->where('h.hotel_id', $hotelId)
            ->distinct()
            ->pluck('pf.moneda_id');

        return Moneda::whereIn('id', $currencyIds)
            ->get()
            ->map(fn($m) => [
                'id'      => $m->id,
                'name'    => $m->moneda,
                'acronym' => $m->acronimo,
            ])
            ->toArray();
    }

    /**
     * Returns the distinct occupancy codes available for a room, derived from
     * its price records. Each entry has the raw code (e.g. "2-1") and a human
     * label (e.g. "2 Adults - 1 Child").
     *
     * @return array<int, array{value: string, label: string}>
     */
    public function getRoomOccupancies(int $roomId): array
    {
        return DB::table('hesperiaplugins_hoteles_precios_fechas as pf')
            ->join('hesperiaplugins_hoteles_fechas as f', 'pf.fecha_id', '=', 'f.id')
            ->where('f.habitacion_id', $roomId)
            ->distinct()
            ->orderBy('pf.ocupacion')
            ->pluck('pf.ocupacion')
            ->map(fn($occ) => [
                'value' => $occ,
                'label' => RateDto::buildOccupancyLabel($occ),
            ])
            ->toArray();
    }

    /**
     * Returns per-day availability data formatted as FullCalendar event objects.
     *
     * Each element in the returned array is an associative array compatible with
     * the FullCalendar Events array/feed format:
     *
     *   - Green  (#28a745): 3 or more units available.
     *   - Yellow (#ffc107): 1–2 units left (low stock).
     *   - Red    (#dc3545): 0 units — fully booked.
     *
     * Days that have no record in the fechas table are omitted (no event emitted).
     *
     * @param  int           $roomId     Primary key of the room (habitacion).
     * @param  DateRangeDto  $dateRange  Date window to query (checkin inclusive, checkout exclusive).
     * @return array<int, array<string, mixed>>  FullCalendar event objects.
     */
    public function getDailyAvailability(int $roomId, DateRangeDto $dateRange): array
    {
        $rows = DB::table('hesperiaplugins_hoteles_fechas')
            ->select('fecha', 'disponible')
            ->where('habitacion_id', $roomId)
            ->whereBetween('fecha', [$dateRange->checkinSql(), $dateRange->lastNightSql()])
            ->orderBy('fecha')
            ->get();

        return $rows->map(function ($row) {
            $units = (int) $row->disponible;

            $color = match (true) {
                $units === 0 => '#dc3545',
                $units <= 2  => '#ffc107',
                default      => '#8fdf82',
            };

            return [
                'start'         => $row->fecha,
                'allDay'        => true,
                'display'       => 'background',
                'color'         => $color,
                'extendedProps' => ['units' => $units],
            ];
        })->toArray();
    }

    // -------------------------------------------------------------------------
    // Currency
    // -------------------------------------------------------------------------

    /**
     * Loads currency data and wraps it in a CurrencyDto.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  if currency not found.
     */
    private function buildCurrencyDto(int $currencyId): CurrencyDto
    {
        $moneda = Moneda::findOrFail($currencyId);

        return new CurrencyDto(
            id:      $moneda->id,
            name:    $moneda->moneda,
            acronym: $moneda->acronimo,
        );
    }
}
