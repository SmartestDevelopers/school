<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Landing Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero {
            height: 60vh;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .section {
            padding: 60px 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">SchoolName</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>

                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

   <!-- Carousel -->
<div class="container mt-4">
    <div id="schoolCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner rounded overflow-hidden">
            <div class="carousel-item active">
                <img src="https://i.pinimg.com/736x/a2/f1/2b/a2f12b8fea345be7890c4f15f3c23aaf.jpg" class="d-block w-100 img-fluid" alt="School Image 1" style="object-fit: cover; height: 400px;">
            </div>
            <div class="carousel-item">
                <img src="https://img.freepik.com/premium-photo/cartoon-students-enjoying-their-time-school-fun-lively-environment_1240525-87514.jpg" class="d-block w-100 img-fluid" alt="School Image 2" style="object-fit: cover; height: 400px;">
            </div>
            <div class="carousel-item">
                <img src="https://thumbs.dreamstime.com/b/students-front-school-back-to-school-cartoon-students-front-school-back-to-school-cartoon-full-color-98705087.jpg" class="d-block w-100 img-fluid" alt="School Image 3" style="object-fit: cover; height: 400px;">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#schoolCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#schoolCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>


    <!-- About Section -->
    <section id="about" class="section bg-light">
        <div class="container text-center">
            <h2>About Our School</h2>
            <p class="lead">We are committed to providing quality education and a nurturing environment for students to grow, learn, and succeed. Our experienced staff and modern facilities help foster a love for learning and creativity.</p>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="section">
        <div class="container text-center">
            <h2>Gallery</h2>
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <img src="https://source.unsplash.com/400x300/?classroom" class="img-fluid rounded shadow-sm" alt="Classroom">
                </div>
                <div class="col-md-4 mb-3">
                    <img src="https://source.unsplash.com/400x300/?students" class="img-fluid rounded shadow-sm" alt="Students">
                </div>
                <div class="col-md-4 mb-3">
                    <img src="https://source.unsplash.com/400x300/?library" class="img-fluid rounded shadow-sm" alt="Library">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section bg-light">
        <div class="container text-center">
            <h2>Contact Us</h2>
            <p class="lead">Have questions or need more info? Reach out to us at:</p>
            <p>Email: contact@schoolname.edu.pk<br>Phone: +92-300-1234567</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        &copy; {{ date('Y') }} SchoolName. All rights reserved.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
