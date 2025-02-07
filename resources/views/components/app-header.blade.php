@vite('resources/css/app-header.css')

<header>

    <div class="search-container">
        <img src="{{ asset('assets/icons/search.svg') }}" class="search-icon">
        <input type="text" id="search-input" placeholder="Busque por sua cidade preferida..." class="search-input">
        <div id="autocomplete-results" class="autocomplete-results"></div>
    </div>

    <div class="location-container">
        <button type="button" id="use-current-location">
            <img src="{{ asset('assets/icons/location.svg') }}" class="location-icon">
            LOCALIZAÇÃO ATUAL
        </button>
    </div>

</header>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("search-input");
        const resultsContainer = document.getElementById("autocomplete-results");
        const searchCityUrl = @json(route('search.city'));
        const locationButton = document.getElementById("use-current-location");

        locationButton.addEventListener("click", function() {
            window.location.href = "/";
        });

        searchInput.addEventListener("input", function() {
            const query = searchInput.value.trim();

            if (query.length < 2) {
                resultsContainer.innerHTML = "";
                resultsContainer.style.display = "none";
                return;
            }

            fetch(`${searchCityUrl}?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = "";
                    resultsContainer.style.display = "block";

                    if (data.length === 0) {
                        resultsContainer.innerHTML = "<p class='no-results'>Nenhuma cidade encontrada.</p>";
                        return;
                    }

                    data.forEach(city => {
                        const div = document.createElement("div");
                        div.classList.add("autocomplete-item");
                        div.innerHTML = `${city.name}, ${city.region}, ${city.country}`;
                        div.addEventListener("click", function() {
                            searchInput.value = city.name;
                            resultsContainer.style.display = "none";
                            window.location.href = `/?city=${encodeURIComponent(city.name)}`;
                        });

                        resultsContainer.appendChild(div);
                    });
                })
                .catch(error => {
                    console.error("Erro ao buscar cidades:", error);
                });
        });

        document.addEventListener("click", function(event) {
            if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
                resultsContainer.style.display = "none";
            }
        });
    });

</script>
