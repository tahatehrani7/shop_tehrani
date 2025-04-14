<?php
include 'db.php';
$id = $_GET['id'] ?? null;
if (!$id) exit(header("Location: product_list.php"));

$res = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $res->fetch_assoc();
if (!$product) exit(header("Location: product_list.php"));

$dir = "uploads/";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete_image"])) {
        if ($product['image'] && file_exists($dir . $product['image']))
            unlink($dir . $product['image']);
        $conn->query("UPDATE products SET image = NULL WHERE id = $id");
        echo "<script>alert('تصویر حذف شد!'); location.href='edit_image.php?id=$id';</script>";
    }

    if (isset($_FILES["image"])) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $newName = "product_$id.$ext";
        $filePath = $dir . $newName;

        if (!in_array($ext, ['jpg', 'jpeg', 'png']) || !getimagesize($_FILES["image"]["tmp_name"]))
            exit("<script>alert('فایل نامعتبر است!'); history.back();</script>");

        if (!is_dir($dir)) mkdir($dir);
        if ($product['image'] && file_exists($dir . $product['image'])) unlink($dir . $product['image']);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $filePath)) {
            $conn->query("UPDATE products SET image = '$newName' WHERE id = $id");
            echo "<script>alert('تصویر بروزرسانی شد!'); location.href='edit_image.php?id=$id';</script>";
        } else echo "خطا در آپلود فایل!";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش تصویر</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/edit_image_style.css">
</head>
<body>
<div class="container mt-5">
    <h4 class="text-center mb-4">ویرایش تصویر محصول</h4>
    <div class="text-center mb-3">
        <?php if ($product['image'] && file_exists("uploads/" . $product['image'])): ?>
            <img src="uploads/<?= $product['image'] ?>" class="img-thumbnail" width="200">
            <form method="POST"><button name="delete_image" class="btn btn-danger mt-2">حذف تصویر</button></form>
        <?php else: ?>
            <p class="text-danger">تصویری موجود نیست.</p>
        <?php endif; ?>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image" class="form-control mb-3" required>
        <button class="btn btn-success">آپلود</button>
        <a href="product_list.php" class="btn btn-secondary">بازگشت</a>
    </form>
</div>
</body>
</html>
