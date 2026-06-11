<?php namespace HesperiaPlugins\Hoteles\Dtos;

/**
 * Immutable representation of an applicable discount for a room/date combination.
 *
 * Maps to hesperiaplugins_hoteles_descuentos filtered through the
 * DescuentoHabitacion::getDescuentoDisponible() eligibility logic.
 */
final class DiscountDto
{
    public function __construct(
        public readonly int     $id,

        /** Discount percentage to subtract from the base price (e.g. 15 = 15%). */
        public readonly float   $percentage,

        /** Display name shown to the guest. */
        public readonly string  $concept,

        /** Non-null when the discount requires a promotional code. */
        public readonly ?string $promoCode,

        /** Number of free nights included (0 when not applicable). */
        public readonly int     $freeNights,
    ) {}

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'percentage'  => $this->percentage,
            'concept'     => $this->concept,
            'promo_code'  => $this->promoCode,
            'free_nights' => $this->freeNights,
        ];
    }
}
