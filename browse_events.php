<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Expires: -1");
header("Pragma: no-cache");

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM events");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Events - EventHub</title>
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
            text-align: center;
            padding-top: 20px;
        }
        .navbar {
            background-color: #1e1e1e;
            height: 80px;
        }
        .container {
            max-width: 800px;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
        }
        .table {
            background-color: #242424;
            color: whitesmoke;
            border-radius: 10px;
            overflow: hidden;
        }
        .table th {
            background-color: #333;
        }
        .btn {
            background-color: #6200ea;
            color: white;
            border: none;
        }
        .btn:hover {
            background-color: #3700b3;
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

    <h2 class="mt-3">Available Events</h2>

    <div class="container mt-4">
        <table class="table table-dark table-striped text-center">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Seats Left</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['venue']) ?></td>
                    <td><?= htmlspecialchars($row['available_seats']) ?></td>
                    <td>
                        <?php 
                        $event_id = $row['id'];
                        $checkBooking = $conn->prepare("SELECT id FROM bookings WHERE user_id = ? AND event_id = ?");
                        $checkBooking->bind_param("ii", $user_id, $event_id);
                        $checkBooking->execute();
                        $checkBooking->store_result();
                        
                        if ($checkBooking->num_rows == 0 && $row['available_seats'] > 0): ?>
                            <form method="POST" action="book_event.php">
                                <input type="hidden" name="event_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-success btn-sm">Book</button>
                            </form>
                        <?php elseif ($row['available_seats'] == 0): ?>
                            <button class="btn btn-secondary btn-sm" disabled>Sold Out</button>
                        <?php else: ?>
                            <button class="btn btn-warning btn-sm" disabled>Already Booked</button>
                        <?php endif; ?>
                        <?php $checkBooking->close(); ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
