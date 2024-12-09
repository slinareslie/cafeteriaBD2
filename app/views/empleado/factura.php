<?php
session_start(); 
date_default_timezone_set('America/Lima'); 
$fechaHoraActual = date('d/m/Y H:i:s');
$mensajeError = ''; // Variable para manejar el error
$mensajeExito = '';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $cliente_id = isset($_POST['cliente_id']) ? intval($_POST['cliente_id']) : null;
    $tipo_pedido = isset($_POST['tipo_pedido']) ? $_POST['tipo_pedido'] : 'local';
    $mesaSeleccionada = isset($_POST['mesa']) ? intval($_POST['mesa']) : null;
    $sede_id = isset($_POST['sede_id']) ? intval($_POST['sede_id']) : null;
    $cartTotalValue = isset($_POST['cart_total_value']) && is_numeric($_POST['cart_total_value']) 
        ? floatval($_POST['cart_total_value']) 
        : 0.00;

    $subtotal = $cartTotalValue; 
    $igv = $subtotal * 0.18; 
    $total = $subtotal + $igv;

    // Validación de campos obligatorios
    if (empty($_POST['nombre_cliente']) || empty($_POST['apellidos']) || empty($_POST['nro_documento'])) {
        $mensajeError = "Por favor, complete todos los campos obligatorios (Nombre, Apellidos, Número de documento).";
    } else {
        // Guardar las variables en la sesión
        $_SESSION['cliente_id'] = $cliente_id;
        $_SESSION['tipo_pedido'] = $tipo_pedido;
        $_SESSION['mesa'] = $mesaSeleccionada;
        $_SESSION['sede_id'] = $sede_id;
        $_SESSION['subtotal'] = $subtotal;
        $_SESSION['igv'] = $igv;
        $_SESSION['total'] = $total;

        // Guardar los datos del cliente
        $_SESSION['nombre_cliente'] = $_POST['nombre_cliente'];
        $_SESSION['apellidos'] = $_POST['apellidos'];
        $_SESSION['tipo_documento'] = $_POST['tipo_documento'];
        $_SESSION['nro_documento'] = $_POST['nro_documento'];
        $_SESSION['correo'] = $_POST['correo'] ?? '';
        $_SESSION['telefono'] = $_POST['telefono'] ?? '';
        $_SESSION['direccion'] = $_POST['direccion'] ?? '';

        // Guardar los productos si están disponibles en el formulario
        $_SESSION['productos'] = isset($_POST['productos']) ? $_POST['productos'] : [];

        // Si todo está bien, redirigir a pedidoRealizado.php
        $_SESSION['order_success'] = true;
        header("Location: pedidoRealizado.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Facturación</title>
    <style>
    body {
        font-family: BlinkMacSystemFont;
        background-color: #e9aa17;
        color: #aa4d19;
        line-height: 1.6;
        padding: 0px;
        margin: 0px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #hero {
        background: url('../app/views/img/factura.png') no-repeat center center;
        background-size: cover;
        font-family: BlinkMacSystemFont;
        height: 50vh;
        color: white;
        width: 100%;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .tabs {
        position: relative;
        /* Permite posicionar elementos dentro del contenedor */
        display: flex;
        flex-wrap: wrap;
        /* Permite que los elementos se distribuyan en varias filas si es necesario */
        justify-content: center;
        /* Centra las imágenes horizontalmente */
        align-items: center;
        /* Centra las imágenes verticalmente */
        gap: 20px;
        margin-bottom: 20px;
        min-height: 150px;
        /* Aumenta el tamaño mínimo del contenedor */
        padding: 20px;
        border-radius: 15px;
        background: rgba(0, 0, 0, 0.5);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 5);
        background-size: cover;
        background-position: center;
    }
    </style>
</head>

<body>
    <div class="fact-container">
        <div class="header">
            <span id="current-datetime"><?= $fechaHoraActual ?></span>
        </div>
        <div class="tabs"
            style="background: url('../app/views/img/factura.png') no-repeat center center; background-size: cover; padding: 20px; text-align: center; border-radius: 15px;">
            <h2 class="text-center mb-5"
                style="background-color: rgba(255,255, 255, 0.3); color: white; padding: 10px 20px; border-radius: 15px; display: inline-block; margin: 0 auto;">
                Resumen de Pedido
            </h2>
        </div>
        <div class="form-container">
            <div class="billing-section">
                <h2>Datos de Facturación</h2>
                <?php if ($mensajeError): ?>
                <div class="alert alert-danger"><?= $mensajeError ?></div>
                <?php endif; ?>
                <div class="form-group flex-container">
                    <label>
                        <input type="checkbox" id="sin-datos-cliente" onclick="toggleCamposAdicionales()">
                        Sin datos del cliente
                    </label>
                </div>
                <form action="index.php?controller=empleado&action=pedidoRealizado" method="POST">
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
                    <div id="campos-adicionales" style="display: none;">
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" name="correo" placeholder="Correo">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Celular</label>
                            <input type="text" id="telefono" name="telefono" placeholder="Teléfono">
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" name="direccion" placeholder="Distrito/calle">
                        </div>
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
                    <input type="hidden" name="mesa" value="<?= $mesaSeleccionada ?>">
                    <button type="submit" class="btn-confirm">Confirmar Pedido</button>
                </form>
            </div>

            <div class="summary-section">
                <h2>Mesa Seleccionada</h2>
                <p><strong>Mesa: </strong><?= $mesaSeleccionada ?></p>
                <h2>Resumen de Pedido</h2>
                <p>SubTotal: <span id="subtotal-display">S/ <?= number_format($subtotal, 2) ?></span></p>
                <p>IGV (18%): <span id="igv-display">S/ <?= number_format($igv, 2) ?></span></p>
                <p>Total: <span id="total-display">S/ <?= number_format($total, 2) ?></span></p>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkbox = document.getElementById("sin-datos-cliente");
        const camposAdicionales = document.getElementById("campos-adicionales");
        const subtotalHidden = document.querySelector("input[name='subtotal']");
        const igvHidden = document.querySelector("input[name='igv']");
        const totalHidden = document.querySelector("input[name='total']");

        const subtotalDisplay = document.getElementById("subtotal-display");
        const igvDisplay = document.getElementById("igv-display");
        const totalDisplay = document.getElementById("total-display");

        function updateValues() {
            const subtotal = parseFloat(subtotalHidden.value) || 0;
            const igv = subtotal * 0.18;
            const total = subtotal + igv;

            igvDisplay.textContent = `S/ ${igv.toFixed(2)}`;
            totalDisplay.textContent = `S/ ${total.toFixed(2)}`;

            igvHidden.value = igv.toFixed(2);
            totalHidden.value = total.toFixed(2);
        }

        updateValues();

        subtotalHidden.addEventListener("input", updateValues);
        checkbox.addEventListener("change", function() {
            if (checkbox.checked) {
                camposAdicionales.style.display = "none";
            } else {
                camposAdicionales.style.display = "block";
            }
        });

        if (checkbox.checked) {
            camposAdicionales.style.display = "none";
        } else {
            camposAdicionales.style.display = "block";
        }
    });
    </script>
    <script src="../public/assets/js/functions.js"></script>
</body>

</html>