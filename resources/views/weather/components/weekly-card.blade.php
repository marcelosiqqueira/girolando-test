@vite('resources/css/weekly-card.css')

<div class="weekly-card-container card">
    <h1>Previsão Semanal:</h1>

    @foreach ($weather->weeklyForecast as $day)
        <div class="forecast-day-container">
            <img src="{{ $day['icon'] }}" alt="Ícone do clima">
            <span>{{ $day['avgTemp'] }}</span>
            <span>{{ $day['formattedDate'] }}</span>
        </div>
    @endforeach

</div>
