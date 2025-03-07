<?php
session_start();
include 'config.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System
    <script>
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };
        </script>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color:whitesmoke
        }
        .navbar {
            background-color: #1e1e1e;
            height: 80px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand, .nav-link {
            font-size: 1.2rem;
        }
        .card {
            background-color: #242424;
            color:rgb(71, 75, 73);
            border: none;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.6);
            padding: 10px;
            border-radius: 5px;
        }
        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }
        .w-120 {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            display: block;
            height: 500px;
            object-fit: cover;
        }
    </style>
</head>
<body>
   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin_dashboard.php">EventHub</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="manage_events.php">Manage Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_bookings.php">View Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <h1 c
    <h1>Welcome, <?= $_SESSION['user_name'] ?>!</h1>
    <!-- Carousel Slider -->
    <div id="eventCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="2"></button>
        </div>
        <!-- Slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/event1.jpg" class="d-block w-120" alt="Event 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Music Fest 2025</h5>
                    <p>Join the biggest music festival of the year.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/event2.jpg" class="d-block w-120" alt="Event 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Tech Conference</h5>
                    <p>Explore the latest in technology and innovation.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/event3.jpg" class="d-block w-120" alt="Event 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Startup Summit</h5>
                    <p>Network with industry leaders and entrepreneurs.</p>
                </div>
            </div>
        </div>
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
    <!-- Quote Section -->
    <div class="card mt-5 mb-5 text-center">
        <div class="card-header">Quote</div>
        <div class="card-body">
            <blockquote class="blockquote mb-0">
                <p>"Life is not measured by the number of breaths we take, but by the moments that take our breath away."</p>
                <footer class="blockquote-footer">Maya Angelou</footer>
            </blockquote>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
