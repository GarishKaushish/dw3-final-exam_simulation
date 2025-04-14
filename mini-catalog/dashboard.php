<?php
require 'sessions.php';
require 'db.php';

$stmt = $pdo->prepare("SELECT * FROM products WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Your Products</h1>
    <a href="add_product.php">Add New Product</a>
    <a href="logout.php" class="logout">Logout</a>

    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><?= htmlspecialchars($product['description']) ?></p>
            <p><strong>Price:</strong> $<?= $product['price'] ?></p>
            <a href="delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
