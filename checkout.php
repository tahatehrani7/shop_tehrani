<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['order_info'] = [
        'fullname' => $_POST['fullname'],
        'address' => $_POST['address'],
        'payment_type' => $_POST['payment_type'],
        'total' => array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $_SESSION['cart'] ?? []))
    ];
    header("Location: process_payment.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>پرداخت</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h3 class="text-center mb-4">پرداخت</h3>

  <?php
  $total = 0;
  if (!empty($_SESSION['cart'])) {
      foreach ($_SESSION['cart'] as $item)
          $total += $item['price'] * $item['quantity'];
      echo "<p class='text-end fw-bold'>مجموع: " . number_format($total) . " تومان</p>";
  } else {
      echo "<div class='alert alert-warning text-center'>سبد خرید خالی است</div>";
  }
  ?>

  <form method="POST" class="mt-4">
    <input class="form-control mb-3" name="fullname" placeholder="نام و نام خانوادگی" required>
    <input class="form-control mb-3" name="address" placeholder="آدرس" required>
    <select class="form-select mb-3" name="payment_type" required>
      <option value="credit_card">کارت بانکی</option>
      <option value="cash_on_delivery">پرداخت در محل</option>
    </select>
    <button class="btn btn-success w-100">پرداخت</button>
  </form>
</div>
</body>
</html>
