<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Services\LocationService;

class WeatherController
{
    protected WeatherService $weatherService;
    protected LocationService $locationService;

    public function __construct(WeatherService $weatherService, LocationService $locationService)
    {
        $this->weatherService = $weatherService;
        $this->locationService = $locationService;
    }

    public function index(Request $request)
    {
        try {
            $city = $request->input('city');

            if (!$city) {
                $city = $this->locationService->getCityFromIP();
            }

            $weatherData = $this->weatherService->getWeatherData($city);
        } catch (\Exception $e) {
            $weatherData = null;
        }

        return view('weather.index', compact('weatherData'));
    }


    public function searchCity(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        try {
            $response = Http::withOptions(['verify' => false])->get("https://api.weatherapi.com/v1/search.json", [
                'key' => env('WEATHER_API_KEY'),
                'q' => $query
            ]);

            if ($response->failed()) {
                return response()->json([]);
            }

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }


}
