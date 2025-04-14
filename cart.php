<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>سبد خرید</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/cart_style.css">
  <style>
    body { direction: rtl; text-align: right; }
    .total { font-weight: bold; font-size: 1.2em; }
  </style>
</head>
<body>
<div class="container mt-5">
  <h3 class="text-center mb-4">سبد خرید شما</h3>

  <?php if (!empty($_SESSION['username'])): ?>
    <p class="text-center">خوش آمدید، <?= htmlspecialchars($_SESSION['username']) ?></p>
  <?php else: ?>
    <p class="text-center text-danger">لطفاً وارد حساب کاربری شوید</p>
  <?php endif; ?>

  <?php if (!empty($_SESSION['cart'])): ?>
    <table class="table table-bordered text-center">
      <thead><tr><th>نام</th><th>قیمت</th><th>تعداد</th><th>مجموع</th><th>عملیات</th></tr></thead>
      <tbody>
        <?php $total = 0; foreach ($_SESSION['cart'] as $item): 
          $sum = $item['price'] * $item['quantity'];
          $total += $sum;
        ?>
        <tr>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td><?= number_format($item['price']) ?> تومان</td>
          <td><?= $item['quantity'] ?></td>
          <td><?= number_format($sum) ?> تومان</td>
          <td>
            <a href="decrease_item.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-warning">-</a>
            <a href="remove_item.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-danger">حذف</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="total text-end">مجموع کل: <?= number_format($total) ?> تومان</div>
  <?php else: ?>
    <div class="alert alert-warning text-center">سبد خرید خالی است</div>
  <?php endif; ?>

  <div class="text-center mt-3">
  <a href="shop.php" class="btn btn-primary">ادامه خرید</a>

  <?php if (!empty($_SESSION['username']) && !empty($_SESSION['cart'])): ?>
    <a href="process_payment.php" class="btn btn-success">پرداخت</a>
  <?php else: ?>
    <button class="btn btn-success" disabled>پرداخت</button>
  <?php endif; ?>

  <a href="clear_cart.php" class="btn btn-danger">تخلیه سبد</a>
</div>

</div>
</body>
</html>
