<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Pendientes</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>

<body>
    <h3>Pedidos Pendientes</h3>
    <ul>
        <?php foreach ($pedidos as $pedido): ?>
        <li>
            Pedido #<?php echo $pedido['pedido_id']; ?> - Fecha: <?php echo $pedido['fecha_pedido']; ?> - Total: S/
            <?php echo $pedido['total']; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>