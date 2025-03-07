<?php
session_start();
include 'config.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$result = $conn->query("SELECT b.id, u.name as user_name, e.title as event_title, b.booking_date FROM bookings b JOIN users u ON b.user_id = u.id JOIN events e ON b.event_id = e.id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <script>
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #121212;
            color: whitesmoke;
        }
        .container {
            margin-top: 50px;
        }
        .table-container {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
        }
        .table {
            color: whitesmoke;
            border-radius: 10px;
            overflow: hidden;
        }
        .table th {
            background: #333;
        }
        .table tbody tr:hover {
            background-color: #2a2a2a;
        }
        .navbar {
            background-color: #1e1e1e;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .nav-link {
            font-size: 1.1rem;
        }
        .nav-link.text-danger {
            font-weight: bold;
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

<!-- Bookings Table -->
<div class="container">
    <h2 class="text-center mt-4 mb-4">All Bookings</h2>
    <div class="table-container mx-auto w-75">
        <table class="table table-dark table-striped text-center">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Event</th>
                    <th>Booking Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_name']) ?></td>
                    <td><?= htmlspecialchars($row['event_title']) ?></td>
                    <td><?= htmlspecialchars($row['booking_date']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
