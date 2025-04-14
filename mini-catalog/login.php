<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare and execute the query to get the user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    // Check if user exists and password matches (without hashing)
    if ($user && $_POST['password'] === $user['password']) {
        // Store user ID in session
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php"); // Redirect to dashboard
        exit;
    } else {
        $error = "Invalid credentials."; // Display error if invalid login
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Mini Catalog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Login</h1>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?> <!-- Display error message -->
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
