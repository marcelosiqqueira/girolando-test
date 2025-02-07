@vite('resources/css/app.css')
@vite('resources/css/weather.css')

<div class="index-container">
    @include('components.app-header')

    <div class="weather-dashboard">
        @if ($weatherData)
            @include('weather.components.city-time-card', ['weather' => $weatherData])
            @include('weather.components.info-card', ['weather' => $weatherData])
            @include('weather.components.weekly-card', ['weather' => $weatherData])
            @include('weather.components.hourly-forecast', ['weather' => $weatherData])
        @else
            <div class="error-message">
                <h2>❌ Erro ao obter os dados do tempo.</h2>
                <p>Por favor, tente novamente mais tarde.</p>
            </div>
        @endif
    </div>
</div>
