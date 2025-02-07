@vite('resources/css/hourly-forecast.css')

<div class="hourly-forecast-container card">
    <h1>Previsão Horária:</h1>

    <div class="forecast-info-container">
        @foreach ($weather->hourlyForecast as $hour)
            <div class="hour-info-container {{ $hour['backgroundClass'] }}">
                <span>{{ $hour['time'] }}</span>
                <img src="{{ $hour['icon'] }}" alt="Ícone do clima">
                <span>{{ $hour['temp'] }}</span>
                <img src="{{ asset('assets/icons/arrow.svg') }}" alt="Direção do Vento">
                <span>{{ $hour['windSpeed'] }}</span>
            </div>
        @endforeach
    </div>
</div>
