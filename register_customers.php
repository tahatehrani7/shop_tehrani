<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // بررسی ایمیل تکراری
    $sql = "SELECT * FROM customers WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='alert alert-danger'>این ایمیل قبلاً ثبت شده است.</div>";
    } else {
        // ذخیره اطلاعات کاربر جدید
        $sql = "INSERT INTO customers (name, email, password, phone, created_at) VALUES ('$name', '$email', '$password', '$phone', NOW())";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['username'] = $name;
            header("Location: shop.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>خطا در ثبت نام.</div>";
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ثبت نام</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f7f7f7; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ccc; }
        .btn { width: 100%; padding: 10px; margin-top: 10px; }
    </style>
</head>
<body>

<div class="form-container">
    <h3 class="text-center">ثبت نام مشتری</h3>
    <form method="POST">
        <input type="text" name="name" placeholder="نام" required>
        <input type="email" name="email" placeholder="آدرس ایمیل" required>
        <input type="password" name="password" placeholder="رمز عبور" required>
        <input type="text" name="phone" placeholder="تلفن" required>
        <button type="submit" class="btn btn-primary">ثبت نام</button>
        <a href="shop.php" class="btn btn-danger mt-2">لغو</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
