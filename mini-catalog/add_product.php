<?php
require 'sessions.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    $allowed = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $maxSize = 2 * 1024 * 1024;

    if (in_array($ext, $allowed) && $image['size'] <= $maxSize) {
        $newName = 'uploads/' . uniqid() . '.' . $ext;
        move_uploaded_file($image['tmp_name'], $newName);

        $stmt = $pdo->prepare("INSERT INTO products (user_id, name, description, price, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $name, $desc, $price, $newName]);

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid image. Only jpg, jpeg, png under 2MB allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Add Product</h1>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="file" name="image" accept=".jpg,.jpeg,.png" required>
        <input type="submit" value="Add Product">
    </form>
</div>
</body>
</html>
