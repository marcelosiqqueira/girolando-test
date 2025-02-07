<?php

use App\Services\WeatherService;
use App\DTOs\WeatherDTO;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

uses(TestCase::class);

it('retorna os dados do clima corretamente com cache', function () {

    $city = 'São Paulo';
    $cacheKey = "weather_{$city}";

    Cache::forget($cacheKey);

    $mockResponse = [
        'location' => [
            'name' => 'São Paulo',
            'region' => 'SP',
            'country' => 'Brazil',
            'localtime' => '2024-02-06 15:00'
        ],
        'current' => [
            'temp_c' => 25.5,
            'feelslike_c' => 26,
            'humidity' => 60,
            'pressure_mb' => 1012,
            'wind_kph' => 10,
            'uv' => 5,
            'condition' => [
                'text' => 'Ensolarado',
                'icon' => '//cdn.weatherapi.com/weather/64x64/day/113.png'
            ]
        ],
        'forecast' => [
            'forecastday' => [
                [
                    'date' => '2024-02-06',
                    'astro' => [
                        'sunrise' => '06:30 AM',
                        'sunset' => '06:45 PM'
                    ],
                    'day' => [
                        'avgtemp_c' => 28,
                        'condition' => [
                            'text' => 'Parcialmente nublado',
                            'icon' => '//cdn.weatherapi.com/weather/64x64/day/116.png'
                        ]
                    ],
                    'hour' => [
                        [
                            'time' => '2024-02-06 00:00',
                            'temp_c' => 22,
                            'wind_kph' => 5,
                            'condition' => [
                                'text' => 'Claro',
                                'icon' => '//cdn.weatherapi.com/weather/64x64/night/113.png'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    Http::fake([
        'https://api.weatherapi.com/v1/forecast.json*' => Http::response($mockResponse, 200)
    ]);

    $service = new WeatherService();

    $weatherData = $service->getWeatherData($city);

    expect($weatherData)->toBeInstanceOf(WeatherDTO::class);

    expect($weatherData->city)->toEqual('São Paulo');
    expect($weatherData->temperature)->toEqual(25.5);
    expect($weatherData->feelsLike)->toEqual(26);
    expect($weatherData->humidity)->toEqual(60);
    expect($weatherData->pressure)->toEqual(1012);
    expect($weatherData->windSpeed)->toEqual(10);
    expect($weatherData->uvIndex)->toEqual(5);
    expect($weatherData->description)->toEqual('Ensolarado');
    expect($weatherData->icon)->toContain('/128x128/');

    expect($weatherData->sunrise)->toEqual('06:30');
    expect($weatherData->sunset)->toEqual('18:45');

    expect($weatherData->weeklyForecast)->toHaveCount(1);
    expect($weatherData->weeklyForecast[0]['formattedDate'])->toBe('Terça-feira, 06 fev');
    expect($weatherData->weeklyForecast[0]['avgTemp'])->toBe('28°C');

    expect($weatherData->hourlyForecast)->toHaveCount(1);
    expect($weatherData->hourlyForecast[0]['time'])->toBe('00:00');
    expect($weatherData->hourlyForecast[0]['temp'])->toBe('22°C');

    expect(Cache::has($cacheKey))->toBeTrue();

    $cachedData = Cache::get($cacheKey);
    expect($cachedData)->toBeInstanceOf(WeatherDTO::class);
    expect($cachedData->city)->toEqual('São Paulo');
});
