<?php
// اتصال به دیتابیس
include 'db.php';

// گرفتن شناسه محصول از URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: product_list.php");
    exit;
}

// گرفتن اطلاعات محصول از دیتابیس
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

// اگر محصول یافت نشد، هدایت به صفحه محصولات
if (!$product) {
    header("Location: product_list.php");
    exit;
}

// اگر فرم ارسال شده بود
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $price = floatval($_POST["price"]);

    $update_stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
    $update_stmt->bind_param("ssdi", $name, $description, $price, $id);
    
    if ($update_stmt->execute()) {
        $message = "محصول با موفقیت بروزرسانی شد.";
    } else {
        $message = "خطا در بروزرسانی محصول: " . $conn->error;
    }
    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/edit_product_style.css">
    <title>ویرایش محصول</title>
</head>
<body>
    <div class="container mt-5 form-container">
        <div class="card">
            <div class="card-header">
                ویرایش محصول
            </div>
            <div class="card-body">
                <?php if (isset($message)): ?>
                    <div class="alert alert-info"><?= $message ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label class="form-label">شناسه محصول</label>
                        <input type="text" class="form-control" value="<?= $product['id'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-cogs icon"></i> نام محصول
                        </label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">
                            <i class="fas fa-info-circle icon"></i> توضیحات
                        </label>
                        <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price" class="form-label">
                            <i class="fas fa-tag icon"></i> قیمت
                        </label>
                        <input type="number" class="form-control" id="price" name="price" value="<?= $product['price'] ?>" required>
                    </div>

                    <button type="submit" class="btn btn-custom w-100 mt-3">بروزرسانی محصول</button>
                    <a href="product_list.php" class="btn btn-cancel w-100 mt-2">لغو</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
