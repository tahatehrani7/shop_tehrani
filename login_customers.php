<?php
include('db.php');
session_start();

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email'");
    $user = mysqli_fetch_assoc($res);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['name'];
        $_SESSION['user_id'] = $user['id'];
        header("Location: shop.php");
        exit;
    } else {
        $error = "ایمیل یا رمز اشتباه است!";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود مشتری</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/login_customers_style.css">
</head>
<body>

<div class="form-container">
    <h3 class="text-center">ورود مشتری</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="آدرس ایمیل" required>
        <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="رمز عبور" required>
        </div>
        <button type="submit" class="btn btn-primary">ورود</button>
        <a href="shop.php" class="btn btn-danger mt-2">بازگشت</a>
    </form>
</div>

</body>
</html>
