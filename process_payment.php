<?php
session_start();
include 'db.php';

// محاسبه مجموع کل سبد خرید
$total = isset($_SESSION['cart']) ? array_reduce($_SESSION['cart'], function ($sum, $item) {
    return $sum + ($item['price'] * $item['quantity']);
}, 0) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conn->connect_error) {
        die("ارتباط با دیتابیس برقرار نشد: " . $conn->connect_error);
    }

    // دریافت اطلاعات از فرم
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $card_number = $_POST['card_number'] ?? '';
    $expiration = $_POST['expiration'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
    $price = $total;

    // بررسی شماره تکراری و ساخت شماره یکتا
    $original_phone = $phone;
    $suffix = 1;

    $check_stmt = $conn->prepare("SELECT order_number FROM orders_table WHERE order_number LIKE CONCAT(?, '%')");
    $check_stmt->bind_param("s", $original_phone);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    $existing_numbers = [];
    while ($row = $result->fetch_assoc()) {
        $existing_numbers[] = $row['order_number'];
    }

    while (in_array($phone, $existing_numbers)) {
        $phone = $original_phone . '-' . str_pad($suffix, 3, '0', STR_PAD_LEFT);
        $suffix++;
    }
    $check_stmt->close();

    // ثبت سفارش در جدول orders_table
    $stmt = $conn->prepare("INSERT INTO orders_table (name, card_number, expiration, cvv, price, address, order_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $card_number, $expiration, $cvv, $price, $address, $phone);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
    
        // ثبت محصولات سبد خرید در جدول order_items
        foreach ($_SESSION['cart'] as $item) {
            $product_name = $item['name'];
            $product_price = $item['price'];
            $quantity = $item['quantity'];
            $total_price = $product_price * $quantity;
    
            $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_name, product_price, quantity, total_price) VALUES (?, ?, ?, ?, ?)");
            $stmt_items->bind_param("issii", $order_id, $product_name, $product_price, $quantity, $total_price);
            $stmt_items->execute();
            $stmt_items->close();
        }
    
        // ذخیره اطلاعات فاکتور در سشن
        $_SESSION['invoice'] = [
            'order_number' => $phone,
            'total' => $total,
            'items' => $_SESSION['cart'],
            'address' => $address,
            'phone' => $original_phone,
            'name' => $name
        ];
        
    
        $_SESSION['cart'] = [];
        $_SESSION['payment_success'] = true;
        $_SESSION['address'] = $address;
        $_SESSION['phone'] = $phone;
        header("Location: success.php");
        exit();
        
    } else {
        $error_message = "❌ خطا در ثبت اطلاعات پرداخت!";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پرداخت نهایی</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/process_payment_style.css">
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">💳 پرداخت نهایی</h3>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <div class="mb-4">
            <h5>💰 مبلغ قابل پرداخت: <span class="text-success"><?= number_format($total) ?> تومان</span></h5>
        </div>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">👤 نام صاحب کارت</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">💳 شماره کارت</label>
                <input type="text" name="card_number" class="form-control" maxlength="16" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">📆 تاریخ انقضا</label>
                    <input type="text" name="expiration" class="form-control" placeholder="MM/YY" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">🔒 CVV</label>
                    <input type="text" name="cvv" class="form-control" maxlength="4" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">🏠 آدرس</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">📱 شماره تلفن</label>
                <input type="text" name="phone" class="form-control" maxlength="11" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">✅ پرداخت</button>
        </form>

        <div class="text-center mt-3">
            <a href="cart.php" class="btn btn-secondary">🔙 بازگشت به سبد خرید</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
