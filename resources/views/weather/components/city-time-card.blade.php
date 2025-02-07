@vite('resources/css/city-time-card.css')

<div class="city-time-card-container card">
    <h2>{{$weatherData->city}}</h2>

    <div class="time-calendar-container">
        <h1>{{$weatherData->currentTime}}</h1>
        <span>{{$weatherData->formattedDate}}</span>
    </div>
</div>
