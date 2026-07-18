<?php
namespace App\Services;

/**
 * MapsService — wrapper for geocoding and directions.
 * Supports Leaflet/OSM (Nominatim) by default.
 */
class MapsService
{
    private string $provider;

    public function __construct()
    {
        $this->provider = $_ENV['MAPS_PROVIDER'] ?? 'leaflet';
    }

    /**
     * Geocode an address to lat/lng using Nominatim (OSM).
     */
    public function geocode(string $address): ?array
    {
        $url = 'https://nominatim.openstreetmap.org/search?' . http_build_query([
            'q'      => $address,
            'format' => 'json',
            'limit'  => 1,
        ]);

        $opts = ['http' => [
            'header' => "User-Agent: UDAACarpooling/1.0\r\n",
            'timeout' => 5,
        ]];
        $ctx    = stream_context_create($opts);
        $result = @file_get_contents($url, false, $ctx);

        if ($result) {
            $data = json_decode($result, true);
            if (!empty($data[0])) {
                return [
                    'lat' => (float)$data[0]['lat'],
                    'lng' => (float)$data[0]['lon'],
                    'display_name' => $data[0]['display_name'],
                ];
            }
        }

        return null;
    }

    /**
     * Get route distance/duration between two points using OSRM.
     */
    public function getRoute(float $fromLat, float $fromLng, float $toLat, float $toLng): ?array
    {
        $url = "https://router.project-osrm.org/route/v1/driving/{$fromLng},{$fromLat};{$toLng},{$toLat}?overview=full&geometries=polyline";

        $opts = ['http' => ['timeout' => 10]];
        $ctx    = stream_context_create($opts);
        $result = @file_get_contents($url, false, $ctx);

        if ($result) {
            $data = json_decode($result, true);
            if (!empty($data['routes'][0])) {
                $route = $data['routes'][0];
                return [
                    'distance_km'    => round($route['distance'] / 1000, 2),
                    'duration_min'   => round($route['duration'] / 60, 0),
                    'polyline'       => $route['geometry'] ?? null,
                ];
            }
        }

        return null;
    }
}
