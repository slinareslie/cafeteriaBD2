<?php
$cartTotalValue = isset($_POST['cart_total_value']) && is_numeric($_POST['cart_total_value']) 
    ? floatval($_POST['cart_total_value']) 
    : 0.00;

$subtotal = $cartTotalValue; 
$igv = $subtotal * 0.18; 
$total = $subtotal + $igv; 
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
            font-family: BlinkMacSystemFont;
            background-size: cover;
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
            position: relative; /* Permite posicionar elementos dentro del contenedor */
            display: flex;
            flex-wrap: wrap; /* Permite que los elementos se distribuyan en varias filas si es necesario */
            justify-content: center; /* Centra las imágenes horizontalmente */
            align-items: center; /* Centra las imágenes verticalmente */
            gap: 20px;
            margin-bottom: 20px;
            min-height: 150px; /* Aumenta el tamaño mínimo del contenedor */
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
        <div class="tabs" style="background: url('../app/views/img/factura.png') no-repeat center center; background-size: cover; padding: 20px; text-align: center; border-radius: 15px;">
            <h2 class="text-center mb-5" 
                style="background-color: rgba(255,255, 255, 0.3); color: white; padding: 10px 20px; border-radius: 15px; display: inline-block; margin: 0 auto;">
                Resumen de Pedido
            </h2>            
        </div>
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
                    <button type="submit" class="btn-confirm"  onclick="window.location.href='../app/views/empleado/pedidoRealizado.php';">Confirmar Pedido</button>
                </form>
            </div>
            <div class="summary-section">
                <h2>Resumen de Compra</h2>
                
                <p>SubTotal: <span id="subtotal-display">
                     <ul>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $cartTotalValue = $_POST['cart_total_value'] ?? '0.00';
                            echo "S/ " . htmlspecialchars($cartTotalValue);
                        }
                        ?>
                    </ul>
                </span></p>
               
                <p>IGV (18%): <span id="igv-display">S/ <?= number_format($igv, 2) ?></span></p>
                <p>Total: <span id="total-display">S/ <?= number_format($total, 2) ?></span></p>              
                

            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
        });
    </script>
    <script src="../public/assets/js/functions.js"></script>
</body>

</html>