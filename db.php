<?php
$host = "localhost";  // سرور (برای لوکال هاست همین می‌مونه)
$user = "root";       // نام کاربری پیش‌فرض در XAMPP
$password = "";       // رمز پیش‌فرض خالیه
$database = "shop_db"; // نام دیتابیسی که ساختی

// اتصال به دیتابیس
$conn = new mysqli($host, $user, $password, $database);

// بررسی اتصال
if ($conn->connect_error) {
}
else{
}
?>