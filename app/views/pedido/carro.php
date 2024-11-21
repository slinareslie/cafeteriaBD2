<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carro de Compras</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>

<body>
    <header class="navbar">
        <div class="logo">Cafetería</div>
        <nav>
            <ul>
                <li><a href="#">Promociones</a></li>
                <li><a href="#">Brasas</a></li>
                <li><a href="#">Parrillas</a></li>
                <li><a href="#">Bebidas</a></li>
                <li><a href="#">Acompañamientos</a></li>
                <li><a href="#">Piqueos</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="carro">
            <h3>Resumen de la Compra</h3>
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
                <?php $total = 0; foreach ($detalles as $detalle): ?>
                <tr>
                    <td><?php echo $detalle['nombre_producto']; ?></td>
                    <td><?php echo $detalle['cantidad']; ?></td>
                    <td>S/ <?php echo $detalle['precio_unitario']; ?></td>
                    <td>S/ <?php echo $detalle['cantidad'] * $detalle['precio_unitario']; ?></td>
                </tr>
                <?php $total += $detalle['cantidad'] * $detalle['precio_unitario']; ?>
                <?php endforeach; ?>
            </table>
            <p class="total">Total: S/ <?php echo $total; ?></p>
            <button class="btn-pedido">Confirmar Pedido</button>
        </section>
    </main>
</body>

</html>