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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['event_id']) || empty($_POST['event_id'])) {
        die("Error: Event ID is missing.");
    }
    $booking_id = $_POST['booking_id'];
    $event_id = $_POST['event_id'];
    
    // Delete the booking
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->close();
    
    // Increase available seats
    $updateSeats = $conn->prepare("UPDATE events SET available_seats = available_seats + 1 WHERE id = ?");
    if (!$updateSeats) {
        die("SQL Error: " . $conn->error);
    }
    $updateSeats->bind_param("i", $event_id);
    if (!$updateSeats->execute()) {
        die("Error updating seats: " . $conn->error);
    }
    $updateSeats->close();
    
    header("Location: my_bookings.php?success=canceled");
    exit();
}
?>
