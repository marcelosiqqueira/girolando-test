<?php

use App\Services\WeatherService;
use App\DTOs\WeatherDTO;
use Illuminate\Support\Facades\Config;

it('faz uma requisição real à WeatherAPI e retorna dados válidos', function () {

    Config::set('services.weather_api.key', env('WEATHER_API_KEY'));
    Config::set('services.weather_api.url', env('WEATHER_API_URL'));

    $service = new WeatherService();

    $weatherData = $service->getWeatherData('Uberaba');

    expect($weatherData)->toBeInstanceOf(WeatherDTO::class);

    expect($weatherData->city)->toBe('Uberaba');
    expect($weatherData->region)->not->toBeNull();
    expect($weatherData->country)->toBe('Brazil');
    expect($weatherData->temperature)->toBeFloat();
    expect($weatherData->description)->not->toBeNull();
    expect($weatherData->sunrise)->not->toBeNull();
    expect($weatherData->sunset)->not->toBeNull();
    expect($weatherData->weeklyForecast)->toBeArray();
    expect($weatherData->hourlyForecast)->toBeArray();

    expect(count($weatherData->weeklyForecast))->toBeGreaterThan(0);
    expect(count($weatherData->hourlyForecast))->toBeGreaterThan(0);
});
