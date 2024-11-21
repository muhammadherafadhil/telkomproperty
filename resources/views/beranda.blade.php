@extends('welcome')

@section('title', 'Halaman Beranda')

@section('content')
<div class="container py-5">
    <!-- Carousel for Featured Content -->
    <div id="carouselExample" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <iframe style="border-radius:12px" src="https://open.spotify.com/embed/playlist/41Cegk4gVzeBjP2ZMduBi2?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>                <div class="carousel-caption d-none d-md-block">
                    <!-- <h5>Selamat Datang di Beranda</h5>
                    <p>Temukan berbagai informasi dan update terbaru di sini.</p> -->
                </div>
            </div>
            <div class="carousel-item">
            <iframe style="border-radius:12px" src="https://open.spotify.com/embed/playlist/1jT4UggOhTuGG92UOoHLOA?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>                <div class="carousel-caption d-none d-md-block">
                    <!-- <h5>Update Terbaru</h5>
                    <p>Selalu perbarui informasi dan berita terbaru dari kami.</p> -->
                </div>
            </div>
            <div class="carousel-item">
            <iframe style="border-radius:12px" src="https://open.spotify.com/embed/playlist/4nwmNtP1E7IWvv8mDHPD0j?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>                <div class="carousel-caption d-none d-md-block">
                    <!-- <h5>Produk Baru</h5>
                    <p>Jelajahi produk terbaru yang telah kami hadirkan.</p> -->
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Latest Articles Section -->
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Artikel Terbaru</h3>
        </div>
        <!-- API integration for articles (dummy data here) -->
        <div class="col-md-4 mb-4" id="article1">
            <div class="card">
                <img src="https://via.placeholder.com/350x200/FF5733/FFFFFF?text=Artikel+1" class="card-img-top" alt="Artikel 1">
                <div class="card-body">
                    <h5 class="card-title">Artikel Tentang Teknologi</h5>
                    <p class="card-text">Ikuti perkembangan teknologi terbaru dan tips praktis yang bisa kamu terapkan.</p>
                    <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4" id="article2">
            <div class="card">
                <img src="https://via.placeholder.com/350x200/33B5FF/FFFFFF?text=Artikel+2" class="card-img-top" alt="Artikel 2">
                <div class="card-body">
                    <h5 class="card-title">Update Industri</h5>
                    <p class="card-text">Dapatkan informasi terbaru mengenai tren industri di berbagai sektor.</p>
                    <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4" id="article3">
            <div class="card">
                <img src="https://via.placeholder.com/350x200/FF57A5/FFFFFF?text=Artikel+3" class="card-img-top" alt="Artikel 3">
                <div class="card-body">
                    <h5 class="card-title">Kiat Bisnis</h5>
                    <p class="card-text">Pelajari strategi terbaik dalam menjalankan bisnis dari para ahli.</p>
                    <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Weather API Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3>Cuaca Hari Ini</h3>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h4 id="weather-city">Loading...</h4>
                <p id="weather-description">Loading...</p>
                <h5 id="weather-temp">Loading...</h5>
            </div>
        </div>
    </div>

    <!-- API for Weather -->
    <script>
        var myCarousel = document.querySelector('#carouselExample');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000, // Auto-scroll every 5 seconds
        ride: 'carousel'
    });
        async function fetchWeather() {
            try {
                const apiKey = 'YOUR_API_KEY'; // Replace with your actual API key
                const city = 'Jakarta'; // You can change this city
                const weatherResponse = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`);
                const weatherData = await weatherResponse.json();

                // Display weather data
                document.getElementById('weather-city').innerText = weatherData.name;
                document.getElementById('weather-description').innerText = weatherData.weather[0].description;
                document.getElementById('weather-temp').innerText = `${weatherData.main.temp}°C`;
            } catch (error) {
                console.error('Error fetching weather data:', error);
            }
        }

        fetchWeather(); // Fetch weather on page load
    </script>
</div>
@endsection
