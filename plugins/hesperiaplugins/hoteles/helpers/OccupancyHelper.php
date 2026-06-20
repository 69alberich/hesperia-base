<?php namespace HesperiaPlugins\Hoteles\Helpers;

/**
 * Pure utility class for occupancy-related calculations.
 *
 * Contains no state and no dependencies — safe to call from any context
 * (services, components, console commands, tests).
 */
final class OccupancyHelper
{
    /** No instances — this class is a static utility only. */
    private function __construct() {}

    /**
     * Generates all valid adult/child occupancy combinations for a given capacity.
     *
     * Rules:
     *   - At least 1 adult is always required.
     *   - Children may be 0 or more.
     *   - The sum of adults + children must not exceed $capacity.
     *
     * Example — capacity 3:
     *   ["1-0", "1-1", "1-2", "2-0", "2-1", "3-0"]
     *
     * Replaces Habitacion::getPermutaOcupaciones(), which used nested while-loops
     * and was bound to the model instance. This implementation is stateless,
     * framework-agnostic, and works from any capacity value.
     *
     * @param  int           $capacity  Maximum number of guests the room can hold.
     * @return list<string>             Occupancy codes in "adults-children" format.
     */
    public static function permutations(int $capacity): array
    {
        if ($capacity < 1) {
            return [];
        }

        $result = [];

        for ($adults = 1; $adults <= $capacity; $adults++) {
            for ($children = 0; $adults + $children <= $capacity; $children++) {
                $result[] = "{$adults}-{$children}";
            }
        }

        return $result;
    }
}
