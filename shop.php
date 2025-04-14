<?php
session_start();
include 'db.php';

// گرفتن محصولات از دیتابیس
$result = $conn->query("SELECT * FROM products");

// تابع محاسبه مجموع سبد خرید
function get_cart_total() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/shop_style.css">
    <title>فروشگاه</title>
</head>
<body>
    <div class="container mt-5">

            <!-- Navbar -->
            <div class="d-flex justify-content-end mb-4">
                <div class=" text-center">
                    <div class="row">
                            <div class="col">
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                        <?= $_SESSION['username'] ?? '<i class="fas fa-user"></i> حساب کاربری' ?>
                                     </button>
                                <ul class="dropdown-menu text-center">
                                    <?php if (isset($_SESSION['username'])): ?>
                                        <li><a class="dropdown-item" href="logout_customers.php">خروج</a></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item" href="login_customers.php">وارد شوید</a></li>
                                        <li><a class="dropdown-item" href="register_customers.php">ثبت نام کنید</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                    </div>
                    <div class="col">
                    
                    </div>
                    <div class="col">
                    
                    </div>
                </div>
            </div>
            </div>

            <!-- Cart Info -->
            <div class="container mt-5">
                <div class="alert alert-info text-center">
                    <a href="cart.php">سبد خرید شما: <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) . " محصول - " . get_cart_total() . " تومان" : "خالی"; ?></a>
                </div>

                <h3 class="text-center mb-4">محصولات فروشگاه</h3>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { ?>
                            <div class="col">
                                <div class="card shadow-sm">
                                    <img src="uploads/<?php echo $row["image"]; ?>" class="card-img-top" alt="تصویر محصول" id="img" style="">

                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                                        <p class="card-text"><?php echo $row["description"]; ?></p>
                                        <p class="card-text"><strong><?php echo $row["price"]; ?> تومان</strong></p>

                                        <?php if (isset($_SESSION['username'])): ?>
                                            <!-- دکمه افزودن به سبد خرید برای کاربران لاگین شده -->
                                            <a href="add_to_cart.php?id=<?php echo $row["id"]; ?>" class="btn btn-success">افزودن به سبد خرید</a>
                                        <?php else: ?>
                                            <!-- پیغام برای کاربران لاگین نکرده -->
                                            <a href="login_customers.php" class="btn btn-warning">برای افزودن به سبد خرید وارد شوید</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="col-12"><div class="alert alert-warning text-center">هیچ محصولی یافت نشد</div></div>
                    <?php } ?>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
