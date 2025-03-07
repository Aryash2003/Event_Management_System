<?php
include 'config.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role']; // Capture role selection from the form
    
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    
    if ($stmt->execute()) {
        header("Location: login.php?success=registered");
        exit();
    } else {
        $error = "Error registering user: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register
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
            color: whitesmoke;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .container {
            text-align: center;
            max-width: 400px;
            background: #1e1e1e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
        }
        .form-control, .btn {
            margin-top: 10px;
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
<h1 class="mb-3">EventsHub</h1>
<div class="container">
    <h2 class="mb-2">Register</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="name" class="form-control" placeholder="Full Name" required><br>
        <input type="email" name="email" class="form-control" placeholder="Email" required><br>
        <input type="password" name="password" class="form-control" placeholder="Password" required><br>
        <label for="role">Register as:</label>
        <select class="form-control" name="role" required>
            <option value="user">User</option>
        </select><br>
        <button type="submit" class="btn w-100" name="register">Register</button>
        <a href="login.php">already_registered</a>
    </form>
    </div>
</body>
</html>
