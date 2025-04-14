<?php
session_start();

// بررسی اینکه آیا شناسه محصول ارسال شده است یا خیر
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // بررسی اینکه آیا سبد خرید در سشن موجود است
    if (isset($_SESSION['cart'])) {
        // حذف محصول از سبد خرید
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $product_id) {
                unset($_SESSION['cart'][$key]); // حذف محصول از آرایه سبد خرید
                break;
            }
        }

        // بازگرداندن به صفحه سبد خرید
        header("Location: cart.php");
        exit();
    }
}
?>
