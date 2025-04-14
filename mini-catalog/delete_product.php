<?php
require 'sessions.php';
require 'db.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    $product = $stmt->fetch();

    if ($product) {
        if (file_exists($product['image_path'])) {
            unlink($product['image_path']);
        }
        $delete = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $delete->execute([$product['id']]);
    }
}
header("Location: dashboard.php");
exit;
