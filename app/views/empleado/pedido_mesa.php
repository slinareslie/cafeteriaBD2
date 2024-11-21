<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido de Mesa</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>

<body>
    <h3>Pedido de Mesa <?php echo $pedido['pedido_id']; ?></h3>
    <p>Total: S/ <?php echo $pedido['total']; ?></p>
</body>

</html>