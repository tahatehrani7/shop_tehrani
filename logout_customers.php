<?php
// شروع جلسه
session_start();

// از بین بردن همه متغیرهای جلسه
session_unset();

// خاتمه دادن به جلسه
session_destroy();

// هدایت به صفحه ورود
header("Location: shop.php");
exit(); // برای جلوگیری از اجرای بیشتر کد بعد از هدایت
?>
