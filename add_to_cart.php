<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // گرفتن اطلاعات محصول
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if ($product) {
        // اگر سبد خرید وجود ندارد، ایجادش کن
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        // بررسی وجود محصول در سبد
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }

        // اگر محصول نبود، اضافه کن
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1,
                'user_id' => $_SESSION['user_id'] ?? null
            ];
        }
    }

    header("Location: shop.php");
    exit;
}
