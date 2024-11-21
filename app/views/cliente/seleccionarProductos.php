<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seleccionar Productos</title>
</head>

<body>
    <h1>Selecciona los Productos</h1>
    <form action="index.php?controller=cliente&action=confirmarCompra" method="POST">
        <?php foreach ($productos as $producto): ?>
        <div>
            <input type="checkbox" name="productos[]" value="<?php echo $producto['producto_id']; ?>">
            <?php echo $producto['nombre_producto']; ?> - S/ <?php echo $producto['precio']; ?>
        </div>
        <?php endforeach; ?>
        <button type="submit">Confirmar</button>
    </form>
</body>

</html>