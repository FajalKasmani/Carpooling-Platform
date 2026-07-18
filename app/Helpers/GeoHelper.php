<?php
namespace App\Helpers;

/**
 * GeoHelper — Haversine distance and polyline utilities.
 */
class GeoHelper
{
    /**
     * Calculate Haversine distance between two lat/lng points.
     *
     * @return float Distance in kilometers
     */
    public static function haversineDistance(
        float $lat1, float $lng1,
        float $lat2, float $lng2
    ): float {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
           * sin($dLng / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    /**
     * Check if a point is within a radius of another point.
     *
     * @param float $radiusKm Acceptable radius in km
     */
    public static function isWithinRadius(
        float $lat1, float $lng1,
        float $lat2, float $lng2,
        float $radiusKm = 2.0
    ): bool {
        return self::haversineDistance($lat1, $lng1, $lat2, $lng2) <= $radiusKm;
    }

    /**
     * Decode a Google-encoded polyline string into array of [lat, lng].
     */
    public static function decodePolyline(string $encoded): array
    {
        $points = [];
        $index  = 0;
        $len    = strlen($encoded);
        $lat    = 0;
        $lng    = 0;

        while ($index < $len) {
            // Decode latitude
            $shift  = 0;
            $result = 0;
            do {
                $b       = ord($encoded[$index++]) - 63;
                $result |= ($b & 0x1f) << $shift;
                $shift  += 5;
            } while ($b >= 0x20);
            $lat += ($result & 1) ? ~($result >> 1) : ($result >> 1);

            // Decode longitude
            $shift  = 0;
            $result = 0;
            do {
                $b       = ord($encoded[$index++]) - 63;
                $result |= ($b & 0x1f) << $shift;
                $shift  += 5;
            } while ($b >= 0x20);
            $lng += ($result & 1) ? ~($result >> 1) : ($result >> 1);

            $points[] = [$lat * 1e-5, $lng * 1e-5];
        }

        return $points;
    }
}
