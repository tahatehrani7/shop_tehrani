<?php
session_start();
include 'db.php';

$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>لیست محصولات</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="css/product_list_style.css">
  <style>
    .table-responsive table{
      width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 8px rgba(0,0,0,0.1); /* اختیاری، برای زیبایی بیشتر */
    }
  </style>
</head>
<body>

<div class="container">

  <!-- نوار کاربری -->
    <div class="">
    <div class="row">
      <div class="col">
        <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
          <?= $_SESSION['username'] ?? '<i class="fas fa-user"></i> حساب کاربری' ?>
        </button>
        <ul class="dropdown-menu text-center">
          <?php if (isset($_SESSION['username'])): ?>
            <li><a class="dropdown-item" href="logout.php">خروج</a></li>
          <?php else: ?>
            <li><a class="dropdown-item" href="login.php">ورود</a></li>
          <?php endif; ?>
        </ul>
      </div>
      <div class="col">
        
      </div>
      <div class="col">
        
      </div>
    </div>
  </div> 

  <!-- عنوان -->
  <h3 class="text-center">لیست محصولات</h3>

  <!-- دکمه‌ها -->
  <div class="d-flex justify-content-center mb-4 gap-3">
    <a href="orders.php" class="btn btn-custom"><i class="fas fa-box"></i> سفارشات</a>
    <a href="add_product.php" class="btn btn-custom"><i class="fas fa-plus"></i> افزودن محصول</a>
  </div>

  <!-- جدول -->
  <div class="table-responsive">
    <table class="table table-dark-custom text-center align-middle">
      <thead>
        <tr>
          <th>شناسه</th>
          <th>نام</th>
          <th>توضیح</th>
          <th>قیمت</th>
          <th>تصویر</th>
          <th style="width: 120px;">عملیات</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($products->num_rows > 0): ?>
          <?php while($product = $products->fetch_assoc()): ?>
            <tr>
              <td><?= $product['id'] ?></td>
              <td><?= $product['name'] ?></td>
              <td><?= $product['description'] ?></td>
              <td><?= $product['price'] ?> تومان</td>
              <td><img src="uploads/<?= $product['image'] ?>" style="max-width:50px;" alt="تصویر"></td>
              <td>
                <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئن هستید؟')"><i class="fas fa-trash-alt"></i></a>
                <a href="edit_image.php?id=<?= $product['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-image"></i></a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6">محصولی یافت نشد</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
