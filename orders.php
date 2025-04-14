<?php
session_start();
include 'db.php';

// گرفتن داده‌های سفارشات
$sql = "SELECT * FROM orders_table";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سفارشات</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/orders_style.css">

    <!-- فونت و استایل سفارشی -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">📋 لیست سفارشات</h3>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>شناسه</th>
                    <th>نام</th>
                    <th>تلفن</th>
                    <th>قیمت</th>
                    <th>آدرس</th>
                    <th>تاریخ</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['order_number']}</td>
                                <td>{$row['price']} تومان</td>
                                <td>{$row['address']}</td>
                                <td>{$row['created_at']}</td>
                                <td>
                                    <a href='view_order.php?id={$row['id']}' class='btn btn-info btn-sm'>جزئیات</a>
                                    <a href='update_order.php?id={$row['id']}&status=done' class='btn btn-success btn-sm ml-2'>انجام شد</a>
                                    <a href='update_order.php?id={$row['id']}&status=cancel' class='btn btn-danger btn-sm ml-2'>کنسل شد</a>
                                    <a href='delete_order.php?id={$row['id']}' class='btn btn-danger btn-sm ml-2' onclick='return confirm(\"آیا از حذف این سفارش مطمئن هستید؟\");'>حذف</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>هیچ سفارشی یافت نشد</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="container text-center">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <a href="product_list.php" class="btn btn-outline-danger btn-lg">برگشت</a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</body>
</html>
