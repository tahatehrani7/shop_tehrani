<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = $_GET['id'];
$order = $conn->query("SELECT * FROM orders_table WHERE id = $order_id")->fetch_assoc();
$items = $conn->query("SELECT * FROM order_items WHERE order_id = $order_id");
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جزئیات سفارش</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/view_order_style.css">
</head>
<body>

    <div class="container my-5">
        <div class=" shadow-lg p-4 rounded">
            <h3 class="text-center mb-4">جزئیات سفارش شماره <?= $order['id']; ?></h3>

            <div class="mb-4">
                <p><strong>👤 نام مشتری:</strong> <?= htmlspecialchars($order['name']); ?></p>
                <p><strong>📍 آدرس ارسال:</strong> <?= htmlspecialchars($order['address']); ?></p>
                <p><strong>💰 قیمت کل:</strong> <?= number_format($order['price']); ?> تومان</p>
                <p><strong>📅 تاریخ سفارش:</strong> <?= $order['created_at']; ?></p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover ">
                    <thead class="text-center th_font">
                        <tr>
                            <th  style="color: rgb(0, 0, 0);">شناسه محصول</th>
                            <th style="color: rgb(0, 0, 0);">نام محصول</th>
                            <th style="color: rgb(0, 0, 0);">قیمت</th>
                            <th style="color: rgb(0, 0, 0);">تعداد</th>
                            <th style="color: rgb(0, 0, 0);">قیمت کل</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $items->fetch_assoc()): ?>
                            <tr class="text-center align-middle">
                                <td><?= $row["id"]; ?></td>
                                <td><?= htmlspecialchars($row["product_name"]); ?></td>
                                <td><?= number_format($row["product_price"]); ?> تومان</td>
                                <td><?= $row["quantity"]; ?></td>
                                <td><?= number_format($row["total_price"]); ?> تومان</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="orders.php" class="btn btn-primary px-4">بازگشت به لیست سفارشات</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
