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
    <title>Confirmación de Pedido</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
    /* Estilos Generales */
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .wrapper {
        text-align: center;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 400px;
    }

    .hidden {
        display: none;
    }

    /* Animación Cargando */
    .loader {
        border: 16px solid #f3f3f3;
        /* Light grey */
        border-top: 16px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
        margin: 0 auto;
    }

    .spinner {
        animation: spin 2s linear infinite;
    }

    /* Animación de Giro */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Título y Mensajes */
    .title {
        font-size: 24px;
        color: #333;
        margin: 20px 0;
    }

    .message {
        font-size: 18px;
        color: #27ae60;
        margin: 10px 0;
    }

    .factura {
        margin: 20px 0;
        padding: 10px;
        background-color: #ecf0f1;
        border-radius: 8px;
    }

    .factura h2 {
        margin-bottom: 10px;
        color: #34495e;
    }

    .btn {
        text-decoration: none;
        padding: 10px 20px;
        background-color: #3498db;
        color: white;
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #2980b9;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Animación para la carga del pedido -->
        <div id="loader" class="loader">
            <div class="spinner"></div>
        </div>

        <div id="content" class="content hidden">
            <h1 class="title">Pedido Confirmado</h1>
            <p class="message"><?= $mensajeExito ?></p>

            <div class="factura">
                <h2>Factura</h2>
                <p><strong>Fecha: </strong><?= $fechaHoraActual ?></p>
                <p><strong>Total: </strong>S/ <?= number_format($total, 2) ?></p>
            </div>

            <a href="../home/index.php" class="btn btn-primary" >Regresar a la Página Principal</a>
        </div>
    </div>

    <script>
    // Mostrar la página después de procesar el pedido
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.getElementById('loader').classList.add('hidden');
            document.getElementById('content').classList.remove('hidden');
        }, 3000); // Simulamos que el proceso toma 3 segundos.
    });
    </script>
</body>

</html>