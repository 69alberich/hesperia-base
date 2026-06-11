<?php namespace HesperiaPlugins\Hoteles\Dtos;

/**
 * Main response DTO returned by AvailabilityService::getRoomAvailability().
 *
 * Represents the full availability picture for a single room over a date range:
 * whether it is available, how many units remain, all applicable rates, and
 * all applicable discounts.
 *
 * Immutable — all properties are readonly.
 *
 * Usage example:
 *
 *   $dto = $availabilityService->getRoomAvailability(5, $dateRange, 1);
 *
 *   // In a component AJAX handler:
 *   return $dto->toArray();
 *
 *   // As a JSON response:
 *   return Response::json($dto->toArray());
 */
final class RoomAvailabilityDto
{
    /**
     * @param  int            $roomId
     * @param  string         $roomName
     * @param  bool           $isAvailable    True when at least one unit is free for every night.
     * @param  int            $availableUnits Minimum available units across all nights (0 when unavailable).
     * @param  DateRangeDto   $dateRange
     * @param  CurrencyDto    $currency
     * @param  RateDto[]      $rates          Empty when room is unavailable.
     * @param  DiscountDto[]  $discounts      Empty when room is unavailable or no discounts apply.
     */
    public function __construct(
        public readonly int         $roomId,
        public readonly string      $roomName,
        public readonly bool        $isAvailable,
        public readonly int         $availableUnits,
        public readonly DateRangeDto $dateRange,
        public readonly CurrencyDto  $currency,
        public readonly array        $rates,
        public readonly array        $discounts,
    ) {}

    /**
     * Returns the serializable array representation of this DTO.
     * Safe to return directly from an OctoberCMS AJAX handler or a JSON response.
     */
    public function toArray(): array
    {
        return [
            'room_id'         => $this->roomId,
            'room_name'       => $this->roomName,
            'is_available'    => $this->isAvailable,
            'available_units' => $this->availableUnits,
            'checkin'         => $this->dateRange->checkinSql(),
            'checkout'        => $this->dateRange->checkoutSql(),
            'nights'          => $this->dateRange->nights(),
            'currency'        => $this->currency->toArray(),
            'rates'           => array_map(fn(RateDto $r) => $r->toArray(), $this->rates),
            'discounts'       => array_map(fn(DiscountDto $d) => $d->toArray(), $this->discounts),
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
