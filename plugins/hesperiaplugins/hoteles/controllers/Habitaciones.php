<?php namespace HesperiaPlugins\Hoteles\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Carbon\Carbon;
use HesperiaPlugins\Hoteles\Dtos\DateRangeDto;
use HesperiaPlugins\Hoteles\Models\Habitacion;
use HesperiaPlugins\Hoteles\Services\AvailabilityService;
use Response;

class Habitaciones extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('HesperiaPlugins.Hoteles', 'main-menu-item', 'side-menu-item');
    }

    /**
     * Renders the availability calendar view for a specific room.
     * Passes currencies (from hotel impuestos) and occupancies (from price records) to the view.
     */
    public function calendario(int $roomId): void
    {
        $room    = Habitacion::findOrFail($roomId);
        $service = new AvailabilityService();

        $currencies  = $service->getHotelCurrencies($room->hotel_id);
        $occupancies = $service->getRoomOccupancies($roomId);

        $this->pageTitle                 = 'Calendario — ' . $room->nombre;
        $this->vars['roomId']            = $roomId;
        $this->vars['roomName']          = $room->nombre;
        $this->vars['currencies']        = $currencies;
        $this->vars['occupancies']       = $occupancies;
        $this->vars['defaultCurrencyId'] = $currencies[0]['id'] ?? null;

        $this->addCss("/plugins/hesperiaplugins/hoteles/assets/vendor/fullcalendar/fullcalendar.min.css");
        $this->addJs("/plugins/hesperiaplugins/hoteles/assets/vendor/fullcalendar/fullcalendar.min.js");
    }

    /**
     * JSON endpoint: per-day availability colors for FullCalendar background events.
     * Called by FullCalendar's event source with ?start=&end= on every navigation.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calendario_events(int $roomId)
    {
        $start = get('start', Carbon::now()->startOfMonth()->toDateString());
        $end   = get('end',   Carbon::now()->startOfMonth()->addMonth()->toDateString());

        try {
            $dateRange = new DateRangeDto(
                Carbon::parse($start)->toDateString(),
                Carbon::parse($end)->toDateString()
            );

            $events = (new AvailabilityService())->getDailyAvailability($roomId, $dateRange);
        } catch (\Throwable $e) {
            $events = [];
        }

        return Response::json($events);
    }

    /**
     * JSON endpoint: per-day, per-occupancy price events.
     * Called manually by the frontend with ?currency_id=&start=&end=.
     * Returns all occupancies so the client can filter without re-fetching.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calendario_prices(int $roomId)
    {
        $currencyId = (int) get('currency_id', 1);
        $start      = get('start', Carbon::now()->startOfMonth()->toDateString());
        $end        = get('end',   Carbon::now()->startOfMonth()->addMonth()->toDateString());

        try {
            $dateRange = new DateRangeDto(
                Carbon::parse($start)->toDateString(),
                Carbon::parse($end)->toDateString()
            );

            $events = (new AvailabilityService())->getDailyPrices($roomId, $dateRange, $currencyId);
        } catch (\Throwable $e) {
            $events = [];
        }

        return Response::json($events);
    }
}
