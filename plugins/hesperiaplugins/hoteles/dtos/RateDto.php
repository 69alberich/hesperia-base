<?php namespace HesperiaPlugins\Hoteles\Dtos;

/**
 * Immutable representation of a room rate for a specific occupancy and board plan.
 *
 * A "rate" combines one occupancy (e.g. "2-1" = 2 adults, 1 child) with one
 * board/regime (e.g. All Inclusive) and the total price for the full stay.
 *
 * $coversAllNights is false when the room has no price loaded for one or more
 * nights in the requested range — in legacy code this was represented as -1.
 */
final class RateDto
{
    public function __construct(
        /** Raw occupancy code, e.g. "2-1" */
        public readonly string  $occupancy,

        /** Human-readable label, e.g. "2 Adults - 1 Child" */
        public readonly string  $occupancyLabel,

        public readonly int     $boardId,
        public readonly string  $boardName,
        public readonly ?string $boardDescription,

        /** Total price for the full stay, with taxes already applied. */
        public readonly float   $total,

        /**
         * True when $total covers every night in the requested range.
         * False when at least one night has no price — the rate is incomplete.
         */
        public readonly bool    $coversAllNights,
    ) {}

    /**
     * Builds a human-readable occupancy label from an occupancy code.
     * Example: "2-1" → "2 Adults - 1 Child"
     */
    public static function buildOccupancyLabel(string $occupancy): string
    {
        [$adults, $children] = explode('-', $occupancy);

        $adultsLabel   = (int) $adults   === 1 ? '1 Adult'    : "{$adults} Adults";
        $childrenLabel = (int) $children === 1 ? '1 Child'    : "{$children} Children";

        return "{$adultsLabel} - {$childrenLabel}";
    }

    public function toArray(): array
    {
        return [
            'occupancy'         => $this->occupancy,
            'occupancy_label'   => $this->occupancyLabel,
            'board_id'          => $this->boardId,
            'board_name'        => $this->boardName,
            'board_description' => $this->boardDescription,
            'total'             => $this->total,
            'covers_all_nights' => $this->coversAllNights,
        ];
    }
}
