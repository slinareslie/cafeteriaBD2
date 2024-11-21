<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Facturación</title>
</head>

<body>
    <h1>Detalles de Facturación</h1>
    <form action="index.php?controller=cliente&action=finalizarCompra" method="POST">
        <input type="text" name="nombre_cliente" placeholder="Nombre">
        <input type="text" name="telefono" placeholder="Teléfono">
        <input type="text" name="direccion" placeholder="Dirección">
        <button type="submit">Finalizar Compra</button>
    </form>
</body>

</html>