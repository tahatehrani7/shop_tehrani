<?php
include 'db.php';
$id = $_GET['id'] ?? null;

if (!$id) die("شناسه محصول مشخص نیست.");

$res = $conn->query("SELECT * FROM products WHERE id = $id");
if ($res->num_rows == 0) die("محصول یافت نشد.");
$row = $res->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirm']))
        $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: product_list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حذف محصول</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/delete_product_style.css">
</head>
<body>
<div class="container mt-5 form-container">
    <div class="card">
        <div class="card-header">
            حذف محصول
        </div>
        <div class="card-body text-center">
            <p class="mb-4" style="font-size: 1.2rem; color:aliceblue;">آیا مطمئن هستید که محصول زیر حذف شود؟</p>
            <div class="product-info text-start mb-4">
                <p><strong>نام:</strong> <?= htmlspecialchars($row['name']) ?></p>
                <p><strong>توضیحات:</strong> <?= htmlspecialchars($row['description']) ?></p>
                <p><strong>قیمت:</strong> <?= $row['price'] ?> تومان</p>
            </div>
            <form method="POST" class="d-flex justify-content-between">
                <button name="confirm" class="btn btn-cancel w-50 me-2"><i class="fas fa-trash-alt me-1"></i> حذف</button>
                <a href="product_list.php" class="btn btn-cancel w-50"><i class="fas fa-times me-1"></i> لغو</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
