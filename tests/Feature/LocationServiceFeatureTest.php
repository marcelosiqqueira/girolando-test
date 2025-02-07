<?php

use App\Services\LocationService;

it('retorna a cidade correta a partir do IP real', function () {
    $service = new LocationService();
    $city = $service->getCityFromIP();

    expect($city)
        ->toBeString()
        ->not()->toBeEmpty();
});
