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
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, event_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $event_id);
    $stmt->execute();
    $stmt->close();
    
    $conn->query("UPDATE events SET available_seats = available_seats - 1 WHERE id = $event_id");
    header("Location: browse_events.php?success=booked");
    exit();
}
?>
