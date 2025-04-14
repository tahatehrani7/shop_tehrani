<?php
session_start();
if (!isset($_SESSION['payment_success'])) {
    header("Location: shop.php");
    exit();
}

// گرفتن اطلاعات فاکتور
$invoice = $_SESSION['invoice'] ?? [];
$items = $invoice['items'] ?? [];
$order_number = $invoice['order_number'] ?? '';
$total = $invoice['total'] ?? 0;
$address = $invoice['address'] ?? '';
$phone = $invoice['phone'] ?? '';

// حذف سشن موفقیت بعد از نمایش فاکتور
unset($_SESSION['payment_success']);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاکتور پرداخت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/success_style.css">
    <style>
        .invoice-box {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            border: 2px dashed #198754;
            box-shadow: 0 0 10px rgba(0,0,0,.15);
            font-size: 16px;
            line-height: 24px;
            background: #f8fff8;
            color: #333;
        }
        .invoice-box table {
            width: 100%;
        }
        .invoice-box table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 8px rgba(0,0,0,0.1); /* اختیاری، برای زیبایی بیشتر */
        }

    </style>
</head>
<body>

<div class="invoice-box">
    <h3 class="text-success">✅ پرداخت با موفقیت انجام شد!</h3>
    <p style="color:#ab310a;"><strong>شماره سفارش:</strong> <?= htmlspecialchars($order_number) ?></p>
    <p style="color:#ab310a;"><strong>شماره تلفن:</strong> <?= ($phone) ?></p>
    <p style="color:#ab310a;"><strong>آدرس:</strong> <?= ($address) ?></p>

    <hr>

    <h5>🧾 جزئیات سفارش:</h5>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>نام محصول</th>
                <th>قیمت واحد</th>
                <th>تعداد</th>
                <th>قیمت کل</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= number_format($item['price']) ?> تومان</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['price'] * $item['quantity']) ?> تومان</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h5 class="text-end mt-4">💰 مجموع پرداختی: <span class="text-success"><?= number_format($total) ?> تومان</span></h5>

    <div class="text-center mt-4">
        <a href="shop.php" class="btn btn-info">🏠 بازگشت به فروشگاه</a>
        <button class="btn btn-info ms-2" onclick="window.print()">🖨️ چاپ فاکتور</button>
    </div>
</div>

</body>
</html>
