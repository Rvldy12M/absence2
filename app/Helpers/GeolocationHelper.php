<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GeolocationHelper
{
    /**
     * Reverse geocode latitude and longitude to get location name
     * Using Nominatim API (OpenStreetMap)
     * 
     * @param float $latitude
     * @param float $longitude
     * @return string Location name or null
     */
    public static function getLocationName($latitude, $longitude)
    {
        if (!$latitude || !$longitude) {
            return null;
        }

        try {
            // Using Nominatim API for reverse geocoding
            $response = Http::timeout(10)->get('https://nominatim.openstreetmap.org/reverse', [
                'lat' => $latitude,
                'lon' => $longitude,
                'format' => 'json',
                'addressdetails' => 1,
                'zoom' => 10,
                'accept-language' => 'id',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Try to extract city/town name
                if (isset($data['address'])) {
                    $address = $data['address'];
                    
                    // Priority: city > town > village > municipality > district
                    if (!empty($address['city'])) {
                        return $address['city'];
                    } elseif (!empty($address['town'])) {
                        return $address['town'];
                    } elseif (!empty($address['village'])) {
                        return $address['village'];
                    } elseif (!empty($address['municipality'])) {
                        return $address['municipality'];
                    } elseif (!empty($address['county'])) {
                        return $address['county'];
                    } elseif (!empty($address['state'])) {
                        return $address['state'];
                    }
                }
                
                // Fallback to display_name
                if (isset($data['display_name'])) {
                    // Get first part of address
                    $parts = explode(',', $data['display_name']);
                    return trim($parts[0]);
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Geolocation reverse geocoding error: ' . $e->getMessage());
        }

        return null;
    }
}
