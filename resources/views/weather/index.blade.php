
@vite('resources/css/app.css')
@vite('resources/css/weather.css')

<div class="index-container">

    @include('components.app-header')

    <div class="weather-dashboard">
        @include('weather.components.city-time-card')
        @include('weather.components.info-card')
        @include('weather.components.weekly-card')
        @include('weather.components.hourly-forecast')
    </div>
</div>
