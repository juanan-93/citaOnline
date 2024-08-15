<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page | AdminLTE</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- Bootstrap Slider -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-slider/css/bootstrap-slider.min.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">TuCita</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sobre Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Usuario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registro</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Slider Section -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
         
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('adminlte/dist/img/slider1.jpg') }}" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First Slide Title</h5>
                    <p>First slide description goes here.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('adminlte/dist/img/slider2.jpg') }}" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second Slide Title</h5>
                    <p>Second slide description goes here.</p>
                </div>
            </div>
        </div>
        
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Features Section -->
    <section class="container my-5">
        <h2 class="text-center mb-5">Our Features</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-chart-pie fa-4x text-primary mb-3"></i>
                    <h3>Analytics</h3>
                    <p>Track your site's performance with our built-in analytics tools.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-lock fa-4x text-primary mb-3"></i>
                    <h3>Security</h3>
                    <p>AdminLTE offers top-notch security for all your applications.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-cogs fa-4x text-primary mb-3"></i>
                    <h3>Customization</h3>
                    <p>Fully customizable with a wide range of components and options.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-light text-center py-5">
        <h2>Ready to dive in?</h2>
        <p>Join thousands of developers using AdminLTE to power their web applications</p>
        <a href="{{ url('/register') }}" class="btn btn-primary btn-lg mt-3">Sign Up Now</a>
    </section>

    <!-- Footer -->
    <footer class="main-footer text-center">
        <strong>Copyright &copy; 2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- Bootstrap Slider JS -->
    <script src="{{ asset('adminlte/plugins/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
</body>
</html>
