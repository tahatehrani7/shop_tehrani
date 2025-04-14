<?php
session_start();

if (isset($_GET['id']) && !empty($_SESSION['cart'])) {
    $id = $_GET['id'];

    // پیدا کردن آیتم در سبد خرید
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) { // اگر محصول پیدا شد
            if ($_SESSION['cart'][$key]['quantity'] > 1) {
                $_SESSION['cart'][$key]['quantity']--; // کاهش تعداد
            } else {
                unset($_SESSION['cart'][$key]); // حذف محصول اگر تعداد ۱ باشد
            }
            break;
        }
    }
}

// بازگشت به صفحه سبد خرید
header("Location: cart.php");
exit();
?>
