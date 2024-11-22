<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h1>Datos recibidos</h1>";
    echo "<pre>";
    print_r($_POST); 
    echo "</pre>";
} else {
    echo "<p>No se enviaron datos al servidor.</p>";
}
echo "<pre>";
print_r($_POST);
echo "</pre>";
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
        <h1>Carro de compra delivery</h1>

        <div class="form-container">
          
            <div class="billing-section">
                <h2>Datos de Facturación</h2>
                <form action="index.php?controller=cliente&action=finalizarCompra" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre_cliente" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos">
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
                        <input type="text" id="nro_documento" name="nro_documento" placeholder="Número de documento">
                    </div>
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
                    <div class="form-group">
                        <label for="forma_pago">Forma de Pago</label>
                        <select id="forma_pago" name="forma_pago">
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sede elegida</label>
                        <p>Sede1</p>
                    </div>
                </form>
            </div>

            
            <div class="summary-section">
                <h2>Resumen de Compra</h2>
                <div id="cart-summary">
                    <p>Subtotal: S/ <?php echo number_format($subtotal, 2); ?></p>
                    <p>IGV (18%): S/ <?php echo number_format($igv, 2); ?></p>
                    <p>
                        Delivery
                        <input type="checkbox" id="delivery-checkbox">
                        <span id="delivery-amount">S/ 0.00</span>
                    </p>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const deliveryCheckbox = document.getElementById('delivery-checkbox');
                            const deliveryAmount = document.getElementById('delivery-amount');

                            deliveryCheckbox.addEventListener('change', () => {
                                if (deliveryCheckbox.checked) {
                                    deliveryAmount.textContent = "S/ 12.00"; // Cambia el monto al activarlo
                                } else {
                                    deliveryAmount.textContent = "S/ 0.00"; // Restaura a cero al desactivarlo
                                }
                            });
                        });
                    </script>
                    <p>Total: S/ <?php echo number_format($total, 2); ?></p>
                </div>
                <button class="btn-confirm">Hacer Pedido</button>
            </div>




    </div>
    <script src="../public/assets/js/functions.js"></script>s
</body>

</html>