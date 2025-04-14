<?php
// شروع سشن
session_start();

// حذف اطلاعات سشن
session_unset();
session_destroy();

// هدایت به صفحه اصلی یا صفحه ورود
header("Location: product_list.php");
exit();
?>
