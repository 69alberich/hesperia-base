<?php namespace HesperiaPlugins\Hoteles\Dtos;

use Carbon\Carbon;
use InvalidArgumentException;

/**
 * Value object representing a check-in / check-out date range.
 *
 * Immutable by design — all properties are readonly.
 * Validates that checkout is strictly after checkin on construction.
 */
final class DateRangeDto
{
    public readonly Carbon $checkin;
    public readonly Carbon $checkout;

    /**
     * @param  string  $checkin   Any date string parseable by Carbon (e.g. "2026-07-10", "10-07-2026")
     * @param  string  $checkout  Any date string parseable by Carbon
     *
     * @throws InvalidArgumentException if checkout is not strictly after checkin
     */
    public function __construct(string $checkin, string $checkout)
    {
        $this->checkin  = Carbon::parse($checkin)->startOfDay();
        $this->checkout = Carbon::parse($checkout)->startOfDay();

        if ($this->checkout->lte($this->checkin)) {
            throw new InvalidArgumentException(
                "Checkout [{$checkout}] must be strictly after checkin [{$checkin}]."
            );
        }
    }

    /**
     * Number of nights between checkin and checkout.
     */
    public function nights(): int
    {
        return $this->checkin->diffInDays($this->checkout);
    }

    /**
     * Returns checkin formatted for SQL queries.
     */
    public function checkinSql(): string
    {
        return $this->checkin->format('Y-m-d');
    }

    /**
     * Returns the last night date (checkout minus one day) formatted for SQL.
     * Useful for availability queries that use BETWEEN on nightly slots.
     */
    public function lastNightSql(): string
    {
        return $this->checkout->copy()->subDay()->format('Y-m-d');
    }

    /**
     * Returns checkout formatted for SQL queries.
     */
    public function checkoutSql(): string
    {
        return $this->checkout->format('Y-m-d');
    }

    public function toArray(): array
    {
        return [
            'checkin'  => $this->checkinSql(),
            'checkout' => $this->checkoutSql(),
            'nights'   => $this->nights(),
        ];
    }
}
