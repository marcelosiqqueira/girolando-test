<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LocationService
{
    public function getCityFromIP(): string
    {
        try {
            $ip = Http::withOptions(['verify' => false])->get('https://checkip.amazonaws.com')->body();
            $ip = trim($ip);

            $response = Http::withOptions(['verify' => false])->get("http://ip-api.com/json/{$ip}?fields=city");

            if ($response->successful() && isset($response['city'])) {
                return $response['city'];
            }
        } catch (\Exception $e) {
            \Log::error("Erro ao buscar cidade pelo IP: {$e->getMessage()}");
            return 'São Paulo';
        }

        return 'São Paulo';
    }

}
