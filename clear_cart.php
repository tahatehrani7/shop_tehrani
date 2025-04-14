<?php
session_start();

// حذف کل سبد خرید
unset($_SESSION['cart']); 

// بازگشت به صفحه سبد خرید
header("Location: cart.php");
exit();
?>
