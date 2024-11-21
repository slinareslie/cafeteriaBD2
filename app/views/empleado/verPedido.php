<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pedidos Pendientes</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>

<body>
    <h1>Pedidos Pendientes</h1>
    <ul>
        <?php foreach ($pedidos as $pedido): ?>
        <li>Pedido #<?php echo $pedido['pedido_id']; ?> - Cliente: <?php echo $pedido['cliente_nombre']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>