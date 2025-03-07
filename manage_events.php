<?php
session_start();
include 'config.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle Event Creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $seats = $_POST['seats'];

    $stmt = $conn->prepare("INSERT INTO events (title, description, date, venue, available_seats) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $description, $date, $venue, $seats);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_events.php");
    exit();
}

// Handle Event Deletion
if (isset($_GET['delete_event'])) {
    $event_id = $_GET['delete_event'];
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_events.php");
    exit();
}

$result = $conn->query("SELECT * FROM events");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - EventsHub</title>
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
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand, .nav-link {
            font-size: 1.2rem;
        }
        .container {
            max-width: 600px;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
        }
        .btn {
            background-color: #6200ea;
            color: white;
            border: none;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #3700b3;
        }
        .event-list {
            list-style: none;
            padding: 0;
        }
        .event-item {
            background: #242424;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
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
    <h1 class="mt-3">Manage Events</h1>
    <div class="container mt-3" >
        <h2>Add Event</h2>
        <form method="POST">
            <input type="text" name="title" class="form-control" placeholder="Event Title" required>
            <textarea name="description" class="form-control" placeholder="Description" required></textarea>
            <input type="date" name="date" class="form-control" required>
            <input type="text" name="venue" class="form-control" placeholder="Venue" required>
            <input type="number" name="seats" class="form-control" placeholder="Seats" required>
            <button type="submit" name="add_event" class="btn w-100">Add Event</button>
        </form>
    </div>
    
    <h3 class="mt-4">Existing Events</h3>
    <ul class="event-list">
        <?php while ($row = $result->fetch_assoc()): ?>
        <li class="event-item">
            <strong><?= $row['title'] ?></strong> - <?= $row['date'] ?> (<?= $row['available_seats'] ?> seats)
            <br>
            <a href="manage_events.php?delete_event=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editEventModal<?= $row['id'] ?>">Edit</button>

            <!-- Edit Event Modal -->
            <div class="modal fade" id="editEventModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editEventLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <input type="hidden" name="event_id" value="<?= $row['id'] ?>">
                                <input type="text" name="title" class="form-control" value="<?= $row['title'] ?>" required>
                                <textarea name="description" class="form-control" required><?= $row['description'] ?></textarea>
                                <input type="date" name="date" class="form-control" value="<?= $row['date'] ?>" required>
                                <input type="text" name="venue" class="form-control" value="<?= $row['venue'] ?>" required>
                                <input type="number" name="seats" class="form-control" value="<?= $row['available_seats'] ?>" required>
                                <button type="submit" name="edit_event" class="btn btn-success w-100">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
