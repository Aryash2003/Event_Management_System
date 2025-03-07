<?php
session_start();

// Check if an admin was logged in before destroying session
$is_admin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];

session_destroy();

if ($is_admin) {
    header("Location: admin_login.php");
} else {
    header("Location: login.php");
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
exit();
?>
