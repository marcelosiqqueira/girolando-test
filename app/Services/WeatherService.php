<?php

namespace App\Services;

use App\DTOs\WeatherDTO;
use Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    private $apiKey;
    private $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('WEATHER_API_KEY');
        $this->apiUrl = env('WEATHER_API_URL');
    }

    public function getWeatherData($city, $days = 5): WeatherDTO
    {
        $cacheKey = "weather_{$city}";

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($city, $days) {

            $response = Http::withOptions([
                'verify' => false,
            ])->get("{$this->apiUrl}/forecast.json", [
                'key' => $this->apiKey,
                'q' => $city,
                'days' => $days,
                'aqi' => 'no',
                'alerts' => 'no',
                'lang' => 'pt'
            ]);

            if ($response->failed()) {
                throw new \Exception('Erro ao buscar dados da WeatherAPI');
            }

            return new WeatherDTO($response->json());
        });
    }
}
