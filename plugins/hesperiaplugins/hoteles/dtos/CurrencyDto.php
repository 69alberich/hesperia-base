<?php namespace HesperiaPlugins\Hoteles\Dtos;

/**
 * Immutable representation of a currency.
 *
 * Maps to the hesperiaplugins_hoteles_moneda table.
 */
final class CurrencyDto
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly string $acronym,
    ) {}

    public function toArray(): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'acronym' => $this->acronym,
        ];
    }
}
