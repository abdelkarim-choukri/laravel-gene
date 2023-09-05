

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .navbar-collapse {
            flex-grow: 0 !important;
        }

        body {
            background-color: #f8f9fa;
        }
        .center-row {
            text-align: center ;
        };
    </style>

    @vite(['resources/js/app.js'])
</head>
<body class="antialiased">
<div id='app'>
    
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="your-image-url" alt="Logo" />
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ml-auto">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

    <div class="container mt-5">
        <h1>
            Mentalome: Unveiling the Complex Landscape of Psychiatric Disorders through Comprehensive Transcriptome Analysis
        </h1>
    </div>
    <footer class="bg-light mt-5">
        <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="image1-url" alt="Image 1" class="img-fluid" />
            </div>
            <div class="col-md-8">
                <div class="row center-row">
                    <div class="col-md-12 ">
                        <img src="image2-url" alt="Image 2" class="img-fluid"  />
                    </div>
                    <div class="col-md-12 mt-3 ">
                        <p>
                            2023 © Mentalome is freely available for non-commercial use with proper citations.
                        </p>
                    </div>
                    <div class="col-md-12 mt-3 ">
                        <p>
                            <a href="https://bioinformatics.um6p.ma">Website</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">            
                <img src="image3-url" alt="Image 3" class="img-fluid" />            
            </div>
        </div>
        </div>
    </footer>

</footer>

</div>

<!-- Bootstrap JavaScript (Popper.js and Bootstrap JS) -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
