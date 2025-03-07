<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT b.id as booking_id, e.id as event_id, e.title, e.date FROM bookings b JOIN events e ON b.event_id = e.id WHERE b.user_id = $user_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Bookings
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="user_home.php">EventHub</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="browse_events.php">Browse Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="my_bookings.php">My Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<h2 class="mt-3 mb-3 text-center">My Bookings</h2>
<div class="container">
    <ul class="list-group">
        <?php while ($row = $result->fetch_assoc()): ?>
        <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center border-secondary rounded mb-2">
            <div>
                <strong><?= htmlspecialchars($row['title']) ?></strong> <br>
                <small><?= htmlspecialchars($row['date']) ?></small>
            </div>
            <form method="POST" action="cancel_booking.php" class="m-0">
                <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</button>
            </form>
        </li>
        <?php endwhile; ?>
    </ul>
</div>

</body>
</html>
