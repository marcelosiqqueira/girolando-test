<?php

namespace App\DTOs;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class WeatherDTO
{
    public string $city;
    public string $region;
    public string $country;
    public string $currentTime;
    public string $formattedDate;

    public float $temperature;
    public float $feelsLike;
    public int $humidity;
    public float $pressure;
    public float $windSpeed;
    public int $uvIndex;
    public string $icon;
    public string $description;

    public string $sunrise;
    public string $sunset;

    public array $weeklyForecast;
    public array $hourlyForecast;

    public function __construct(array $data)
    {
        // Garantir que o Laravel use locale pt_BR para datas
        App::setLocale('pt_BR');

        $this->city = $data['location']['name'] ?? 'Desconhecido';
        $this->region = $data['location']['region'] ?? 'Desconhecido';
        $this->country = $data['location']['country'] ?? 'Desconhecido';

        $dateTime = Carbon::parse($data['location']['localtime'] ?? now());
        $this->currentTime = $dateTime->format('H:i');
        $this->formattedDate = ucfirst($dateTime->translatedFormat('l, d M'));

        $this->icon = $this->convertIconToHighResolution($data['current']['condition']['icon'] ?? '');
        $this->description = $data['current']['condition']['text'] ?? 'Desconhecido';

        $this->sunrise = $this->convertTo24HourFormat($data['forecast']['forecastday'][0]['astro']['sunrise'] ?? '--:--');
        $this->sunset = $this->convertTo24HourFormat($data['forecast']['forecastday'][0]['astro']['sunset'] ?? '--:--');

        $this->temperature = $data['current']['temp_c'] ?? 0;
        $this->feelsLike = $data['current']['feelslike_c'] ?? 0;
        $this->humidity = $data['current']['humidity'] ?? 0;
        $this->pressure = $data['current']['pressure_mb'] ?? 0;
        $this->windSpeed = $data['current']['wind_kph'] ?? 0;
        $this->uvIndex = (int) round($data['current']['uv'] ?? 0);

        $this->weeklyForecast = $this->formatWeeklyForecast($data['forecast']['forecastday'] ?? []);
        $this->hourlyForecast = $this->formatHourlyForecast($data['forecast']['forecastday'][0]['hour'] ?? []);
    }

    private function formatWeeklyForecast(array $data): array
    {
        $forecast = [];
        foreach ($data as $day) {
            $dateFormatted = ucfirst(Carbon::parse($day['date'])->translatedFormat('l, d M'));
            $avgTempFormatted = round($day['day']['avgtemp_c'] ?? 0, 1) . '°C';

            $forecast[] = [
                'formattedDate' => $dateFormatted,
                'avgTemp' => $avgTempFormatted,
                'icon' => $this->convertIconToHighResolution($day['day']['condition']['icon'] ?? ''),
                'description' => $day['day']['condition']['text'] ?? ''
            ];
        }
        return $forecast;
    }

    private function formatHourlyForecast(array $hours): array
    {
        $selectedHours = [0, 3, 6, 9, 12, 18];
        $forecast = [];

        foreach ($selectedHours as $hourIndex) {
            if (isset($hours[$hourIndex])) {
                $hour = $hours[$hourIndex];
                $forecast[] = [
                    'time' => substr($hour['time'], -5),
                    'temp' => round($hour['temp_c'] ?? 0, 1) . '°C',
                    'windSpeed' => round($hour['wind_kph'] ?? 0) . ' km/h',
                    'icon' => $this->convertIconToHighResolution($hour['condition']['icon'] ?? ''),
                    'description' => $hour['condition']['text'] ?? 'Desconhecido',
                    'backgroundClass' => $this->getWeatherBackgroundClass($hour['condition']['text'] ?? '')
                ];
            }
        }
        return $forecast;
    }

    private function convertTo24HourFormat(string $time): string
    {
        return Carbon::parse($time)->format('H:i');
    }

    private function convertIconToHighResolution(string $icon): string
    {
        return str_replace('/64x64/', '/128x128/', "https:{$icon}");
    }

    private function getWeatherBackgroundClass(string $condition): string
    {
        $condition = strtolower($condition);
        if (str_contains($condition, 'chuva') || str_contains($condition, 'tempestade') || str_contains($condition, 'nublado')) {
            return 'rain-background';
        }
        return 'sun-background';
    }
}
