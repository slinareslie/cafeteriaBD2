<?php
$cartDetails = isset($_POST['cart_details']) ? json_decode($_POST['cart_details'], true) : [];
$subtotal = isset($_POST['subtotal']) ? floatval($_POST['subtotal']) : 0.00;
$igv = isset($_POST['igv']) ? floatval($_POST['igv']) : 0.00;
$total = isset($_POST['total']) ? floatval($_POST['total']) : 0.00;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <title>Facturación</title>
</head>

<body>
    <div class="container">
        <h1>Resumen del Pedido</h1>
        <div class="form-container">
            <div class="billing-section">
                <h2>Datos de Facturación</h2>
                <form action="pasarela_pago.php" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre_cliente" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_documento">Tipo de documento</label>
                        <select id="tipo_documento" name="tipo_documento">
                            <option value="dni">DNI</option>
                            <option value="pasaporte">Pasaporte</option>
                            <option value="carnet_extranjeria">Carnet de Extranjería</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nro_documento">Nro. de Documento</label>
                        <input type="text" id="nro_documento" name="nro_documento" placeholder="Número de documento"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" placeholder="Correo" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Celular</label>
                        <input type="text" id="telefono" name="telefono" placeholder="Teléfono" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" placeholder="Distrito/calle" required>
                    </div>
                    <div class="form-group">
                        <label for="forma_pago">Forma de Pago</label>
                        <select id="forma_pago" name="forma_pago">
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                        </select>
                    </div>
                    <input type="hidden" name="subtotal" value="<?= number_format($subtotal, 2) ?>">
                    <input type="hidden" name="igv" value="<?= number_format($igv, 2) ?>">
                    <input type="hidden" name="total" id="total-hidden" value="<?= number_format($total, 2) ?>">
                    <button type="submit" class="btn-confirm">Confirmar Pedido</button>
                </form>
            </div>
            <div class="summary-section">
                <h2>Resumen de Compra</h2>
                <ul>
                    <?php foreach ($cartDetails as $product): ?>
                    <li>
                        <?= htmlspecialchars($product['name']) ?> -
                        <?= $product['quantity'] ?> x S/ <?= number_format($product['price'], 2) ?> =
                        S/ <?= number_format($product['total'], 2) ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <p>Subtotal: <span>S/ <?= number_format($subtotal, 2) ?></span></p>
                <p>IGV (18%): <span>S/ <?= number_format($igv, 2) ?></span></p>
                <p>Total: <span id="total-display">S/ <?= number_format($total, 2) ?></span></p>
            </div>
        </div>
    </div>
</body>

</html>