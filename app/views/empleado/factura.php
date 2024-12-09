<?php
date_default_timezone_set('America/Lima'); 
$fechaHoraActual = date('d/m/Y H:i:s');
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

    // Conectar a la base de datos
    $mysqli = new mysqli("localhost", "root", "", "CafeteriaDB");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Preparar y ejecutar el procedimiento almacenado para insertar el pedido
    $stmt = $mysqli->prepare("INSERT INTO Pedidos (cliente_id, tipo_pedido, mesa_numero, sede_id, subtotal, igv, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issiddd', $cliente_id, $tipo_pedido, $mesaSeleccionada, $sede_id, $subtotal, $igv, $total);
    if ($stmt->execute()) {
        $pedido_id = $mysqli->insert_id; // Obtener el ID del pedido insertado

        // Insertar detalles del pedido (suponiendo que se pasó un array con los productos)
        $productos = [
            ['producto_id' => 1, 'cantidad' => 2, 'precio_unitario' => 5.00],
            ['producto_id' => 2, 'cantidad' => 1, 'precio_unitario' => 3.50]
        ];

        foreach ($productos as $producto) {
            $stmt = $mysqli->prepare("INSERT INTO Detalle_Pedido (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('iiid', $pedido_id, $producto['producto_id'], $producto['cantidad'], $producto['precio_unitario']);
            $stmt->execute();
        }

        // Insertar un comprobante de pago
        $tipo_comprobante = 'boleta';  // O 'factura', según sea el caso
        $serie = 'B001';
        $correlativo = 1;  // Este valor se puede manejar como un contador
        $stmt = $mysqli->prepare("INSERT INTO Comprobante_Pago (pedido_id, tipo_comprobante, serie, correlativo, subtotal, igv, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isssddd', $pedido_id, $tipo_comprobante, $serie, $correlativo, $subtotal, $igv, $total);
        $stmt->execute();

        // Si todo sale bien, mostrar mensaje de éxito
        $mensajeExito = "Pedido procesado correctamente.";
    } else {
        $mensajeExito = "Error al procesar el pedido: " . $stmt->error;
    }

    // Cerrar la conexión
    $mysqli->close();
}
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
        <div class="header">
            <span id="current-datetime"><?= $fechaHoraActual ?></span>
        </div>
        <h1>Resumen del Pedido</h1>

        <div class="form-container">
            <div class="billing-section">
                <h2>Datos de Facturación</h2>
                <div class="form-group flex-container">
                    <label>
                        <input type="checkbox" id="sin-datos-cliente" checked>
                        Sin datos del cliente
                    </label>
                </div>
                <!--<form method="POST" action="factura.php">-->
                <form method="POST" action="">
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