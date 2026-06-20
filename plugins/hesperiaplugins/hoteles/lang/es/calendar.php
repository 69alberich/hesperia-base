<?php

/**
 * Calendar module — Spanish labels.
 *
 * Accessed via trans('hesperiaplugins.hoteles::calendar.<key>')
 * To add a new language: duplicate this file to lang/{locale}/calendar.php
 * and translate the values. Keys must stay in English.
 */
return [

    // ── Control labels ────────────────────────────────────────────────────────
    'controls' => [
        'currency'  => 'Moneda',
        'occupancy' => 'Ocupación',
    ],

    // ── Availability badge (shown per day inside the calendar card) ───────────
    'badge' => [
        'available' => 'disp.',
    ],

    // ── Legend ────────────────────────────────────────────────────────────────
    'legend' => [
        'available'    => 'Disponible',
        'low_stock'    => 'Disponibilidad limitada (1–2 unidades)',
        'fully_booked' => 'Sin disponibilidad',
    ],

    // ── Alerts ────────────────────────────────────────────────────────────────
    'alerts' => [
        // Split around the dynamic currency name injected by JS
        'no_prices_prefix' => 'Sin precios configurados para',
        'no_prices_suffix' => 'en el período visible.',
    ],

];
