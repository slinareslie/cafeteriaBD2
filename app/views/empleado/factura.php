<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>

<body>
    <h3>Resumen de Facturación</h3>
    <p>Comprobante: <?php echo $pago['tipo_comprobante']; ?> - Total: S/ <?php echo $pago['total']; ?></p>
    <p>Pago realizado con: <?php echo $pago['metodo_pago']; ?></p>
</body>

</html>