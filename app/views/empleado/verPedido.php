<?php
// Decodificar los datos del carrito recibidos
$cartDetails = isset($_POST['cart_details']) ? json_decode($_POST['cart_details'], true) : [];
$cartTotal = isset($_POST['cart_total']) ? $_POST['cart_total'] : '0.00';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pedido Mesa</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>

<body>
    <style>
        body {
            font-family: BlinkMacSystemFont;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
    </style>
    <div class="containerP">
        <header>
            <h1>Pedido Nro 010</h1>
            <div class="header-right">
                <span class="time">14:00:10</span>
                <div class="date-picker">
                    <input type="date">
                    <button class="calendar-btn">📅</button>
                </div>
            </div>
        </header>

        <div class="order-details">
            <?php if (!empty($cartDetails)): ?>
                <?php foreach ($cartDetails as $item): ?>
                    <div class="order-item">
                        <input type="number" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1">
                        <span><?php echo htmlspecialchars($item['name']); ?></span>
                        <span class="price"><?php echo htmlspecialchars($item['price']); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos en el pedido.</p>
            <?php endif; ?>
        </div>

        <div class="total">
            <hr>
            <span>Total S/. </span>
            <span class="price"><?php echo htmlspecialchars($cartTotal); ?></span>
        </div>

        <div class="submit-order">
            <button>Hacer Pedido</button>
        </div>
    </div>
    <script src="../public/assets/js/functions.js"></script>
</body>

</html>