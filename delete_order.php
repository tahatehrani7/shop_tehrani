<?php
include 'db.php';  // اتصال به دیتابیس

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // آماده‌سازی و اجرای دستور حذف
    $sql = "DELETE FROM orders_table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('سفارش با موفقیت حذف شد.'); window.location.href = 'orders.php';</script>";
    } else {
        echo "<script>alert('خطا در حذف سفارش.'); window.location.href = 'orders.php';</script>";
    }
}
?>
