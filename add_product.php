<?php
// اتصال به دیتابیس
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? '';
    $description = $_POST["description"] ?? '';
    $price = $_POST["price"] ?? 0;

    // بررسی ساده اعتبار قیمت
    if (!is_numeric($price) || $price < 0) {
        echo "<div class='alert alert-danger text-center'>قیمت وارد شده نامعتبر است.</div>";
        exit;
    }

    // استفاده از Prepared Statement
    $stmt = $conn->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $description, $price);

    if ($stmt->execute()) {
        header("Location: product_list.php");
        exit;
    } else {
        echo "<div class='alert alert-danger text-center'>خطا در افزودن محصول: " . $conn->error . "</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>افزودن محصول</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/add_product_style.css">
</head>
<body class="bg">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
          <div class="card-header btn btn-custom text-white text-center fs-5 fw-bold">
            <span style="color: #2b2b2b;">افزودن محصول جدید</span>
          </div>
          <div class="card-body">
            <form method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">نام محصول</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="مثال: گوشی موبایل" required>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">توضیحات</label>
                <textarea name="description" id="description" class="form-control" rows="4" placeholder="توضیحات محصول را وارد کنید..." required></textarea>
              </div>
              <div class="mb-4">
                <label for="price" class="form-label">قیمت (تومان)</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" placeholder="مثال: 2500000" required>
              </div>
              <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-outline-success px-4">ذخیره</button>
                <a href="product_list.php" class="btn btn-outline-danger px-4">لغو</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
