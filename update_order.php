<?php
include 'db.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = $_GET['id'];
    $status = $_GET['status'];

    // بروزرسانی وضعیت سفارش در دیتابیس
    $sql = "UPDATE orders_table SET status='$status' WHERE id=$order_id";

    if ($conn->query($sql) === TRUE) {
        // بعد از بروزرسانی به صفحه لیست سفارشات بازگشت داده می‌شود
        echo "<script>alert('وضعیت سفارش به روز شد.'); window.location.href='orders.php';</script>";
    } else {
        echo "خطا در به روزرسانی وضعیت: " . $conn->error;
    }
}
?>
