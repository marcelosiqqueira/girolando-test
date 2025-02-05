@vite('resources/css/app-header.css')

<header>

    <div class="search-container">
        <img src="{{ asset('assets/icons/search.svg') }}" class="search-icon">
        <input type="text" placeholder="Busque por sua cidade preferida..." class="search-input">
    </div>

    <div class="location-container">
        <button type="button">
            <img src="{{ asset('assets/icons/location.svg') }}" class="location-icon">
            LOCALIZAÇÃO ATUAL
        </button>
    </div>

</header>
