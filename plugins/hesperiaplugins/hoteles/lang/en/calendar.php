<?php

/**
 * Calendar module — English labels.
 *
 * Accessed via trans('hesperiaplugins.hoteles::calendar.<key>')
 * To add a new language: duplicate this file to lang/{locale}/calendar.php
 * and translate the values. Keys must stay in English.
 */
return [

    // ── Control labels ────────────────────────────────────────────────────────
    'controls' => [
        'currency'  => 'Currency',
        'occupancy' => 'Occupancy',
    ],

    // ── Availability badge (shown per day inside the calendar card) ───────────
    'badge' => [
        'available' => 'avail.',
    ],

    // ── Legend ────────────────────────────────────────────────────────────────
    'legend' => [
        'available'    => 'Available',
        'low_stock'    => 'Low availability (1–2 units)',
        'fully_booked' => 'Fully booked',
    ],

    // ── Alerts ────────────────────────────────────────────────────────────────
    'alerts' => [
        // Split around the dynamic currency name injected by JS
        'no_prices_prefix' => 'No prices configured for',
        'no_prices_suffix' => 'in the current period.',
    ],

];
