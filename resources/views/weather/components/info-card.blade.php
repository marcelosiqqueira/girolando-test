@vite('resources/css/info-card.css')

<div class="weather-info-card-container card">

    <div class="weather-info">
        <div class="temp">
            <h1>24°C</h1>
            <p>Sensação Térmica: <span>22°C</span></p>
        </div>
        <div class="sun-info">
            <div class="sun-detail-container">
                <img src="{{ asset('assets/icons/sunrise.svg') }}"  alt="Sunrise">
                <div class="hour-details">
                    <strong>Nascer</strong>
                    <span>06:37 AM</span>
                </div>

            </div>

            <div class="sun-detail-container">
                <img src="{{ asset('assets/icons/sunset.svg') }}" alt="Sunset">
                <div class="hour-details">
                    <strong>Pôr do Sol</strong>
                    <span>06:37 AM</span>
                </div>
            </div>
        </div>
    </div>

    <div class="weather-icon">
        <img src="{{ asset('assets/icons/sun.svg') }}" alt="Weather Icon">
        <p>Sol</p>
    </div>

    <div class="weather-stats">
        <div class="stat">
            <img src="{{ asset('assets/icons/humidity.svg') }}" alt="Humidity">
            <p><strong>41%</strong> Humidade</p>
        </div>
        <div class="stat">
            <img src="{{ asset('assets/icons/wind-speed.svg') }}" alt="Wind Speed">
            <p><strong>2km/h</strong> Vento</p>
        </div>
        <div class="stat">
            <img src="{{ asset('assets/icons/pressure.svg') }}" alt="Pressure">
            <p><strong>997 hPa</strong> Pressão</p>
        </div>
        <div class="stat">
            <img src="{{ asset('assets/icons/uv.svg') }}"alt="UV Index">
            <p><strong>8</strong> Raios UV </p>
        </div>
    </div>
</div>
