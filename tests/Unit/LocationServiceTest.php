<?php

use App\Services\LocationService;
use Illuminate\Support\Facades\Http;

use Tests\TestCase;

uses(TestCase::class);

it('retorna a cidade correta a partir do IP mockado', function () {

    Http::fake([
        'https://checkip.amazonaws.com' => Http::response("192.168.1.1", 200),
        'http://ip-api.com/json/192.168.1.1?fields=city' => Http::response(['city' => 'Rio de Janeiro'], 200),
    ]);

    $service = new LocationService();
    $city = $service->getCityFromIP();

    expect($city)->toBe('Rio de Janeiro');
});

it('retorna São Paulo se a API de localização não retornar cidade', function () {

    Http::fake([
        'https://checkip.amazonaws.com' => Http::response("192.168.1.1", 200),
        'http://ip-api.com/json/192.168.1.1?fields=city' => Http::response([], 200),
    ]);

    $service = new LocationService();
    $city = $service->getCityFromIP();

    expect($city)->toBe('São Paulo');
});

it('retorna São Paulo se a API de localização falhar completamente', function () {

    Http::fake([
        'https://checkip.amazonaws.com' => Http::response("192.168.1.1", 200),
        'http://ip-api.com/json/192.168.1.1?fields=city' => Http::response(null, 500),
    ]);

    $service = new LocationService();
    $city = $service->getCityFromIP();

    expect($city)->toBe('São Paulo');
});
