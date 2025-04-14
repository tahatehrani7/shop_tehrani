<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$name || !$email || !$password) {
        $error = "همه فیلدها الزامی هستند.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "ایمیل نامعتبر است.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = "این ایمیل قبلاً ثبت شده است.";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $passwordHash);

            if ($stmt->execute()) {
                $_SESSION['username'] = $name;
                header("Location: product_list.php");
                exit();
            } else {
                $error = "خطا در ثبت‌نام، لطفاً دوباره تلاش کنید.";
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1f2029;
            color: #ffeba7;
            line-height: 1.7;
            font-weight: 300;
        }

        .card-3d-wrap {
            position: relative;
            width: 440px;
            max-width: 100%;
            height: auto;
            margin: auto;
            margin-top: 60px;
            perspective: 800px;
        }

        .card-front {
            background-color: #2b2e38;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            padding: 40px;
        }

        .form-style {
            background-color: #1f2029;
            border: none;
            color: #c4c3ca;
            padding: 13px 20px 13px 20px;
            width: 100%;
            border-radius: 4px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(21,21,21,0.2);
        }

        .form-style::placeholder {
            color: #c4c3ca;
        }

        .btn {
            border-radius: 4px;
            height: 44px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: #ffeba7;
            color: #000;
            width: 100%;
            transition: all 200ms linear;
        }

        .btn:hover {
            background-color: #000;
            color: #ffeba7;
            box-shadow: 0 8px 24px rgba(16,39,112,0.2);
        }

        .alert {
            background-color: #ff4d4f;
            color: #fff;
            border: none;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        h3 {
            font-weight: 600;
            text-align: center;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<div class="card-3d-wrap">
    <div class="card-front">
        <h3>ثبت‌نام</h3>
        <?php if (isset($error)) echo "<div class='alert'>$error</div>"; ?>
        <form method="POST">
            <input type="text" name="name" class="form-style" placeholder="نام" required>
            <input type="email" name="email" class="form-style" placeholder="آدرس ایمیل" required>
            <input type="password" name="password" class="form-style" placeholder="رمز عبور" required>
            <button type="submit" class="btn">ثبت‌نام</button>
            <a href="product_list.php" class="btn mt-3">بازگشت</a>
        </form>
    </div>
</div>

</body>
</html>
