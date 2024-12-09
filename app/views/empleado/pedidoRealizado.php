<?php
session_start();


date_default_timezone_set('America/Lima'); 
$fechaHoraActual = date('d/m/Y H:i:s');
$mensajeExito = '';


if (isset($_POST['mesa'], $_POST['subtotal'], $_POST['igv'], $_POST['total'])) {
    
    $cliente_id = 1;
    $tipo_pedido = 'local';
    $sede_id = $_POST['sede_id'];
    $mesaSeleccionada = $_POST['mesa'];
    $subtotal = $_POST['subtotal'];
    $igv = $_POST['igv'];
    $total = $_POST['total'];

    
    $nombre_cliente = isset($_POST['nombre_cliente']) ? $_POST['nombre_cliente'] : '';
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
    $tipo_documento = isset($_POST['tipo_documento']) ? $_POST['tipo_documento'] : '';
    $nro_documento = isset($_POST['nro_documento']) ? $_POST['nro_documento'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';

    
    $productos = isset($_POST['productos']) ? $_POST['productos'] : [];

    
    $mysqli = new mysqli("srv1006.hstgr.io", "u472469844_est27", "#Bd00027", "u472469844_est27");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    
    $stmt = $mysqli->prepare("INSERT INTO Pedidos (cliente_id, tipo_pedido, mesa_numero, sede_id, subtotal, igv, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issiddd', $cliente_id, $tipo_pedido, $mesaSeleccionada, $sede_id, $subtotal, $igv, $total);
    if ($stmt->execute()) {
        $pedido_id = $mysqli->insert_id; 

        
        foreach ($productos as $producto) {
            $stmt = $mysqli->prepare("INSERT INTO Detalle_Pedido (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('iiid', $pedido_id, $producto['producto_id'], $producto['cantidad'], $producto['precio_unitario']);
            $stmt->execute();
        }

        
        $tipo_comprobante = 'boleta';  
        $serie = 'B001';
        $correlativo = 1;  
        $stmt = $mysqli->prepare("INSERT INTO Comprobante_Pago (pedido_id, tipo_comprobante, serie, correlativo, subtotal, igv, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isssddd', $pedido_id, $tipo_comprobante, $serie, $correlativo, $subtotal, $igv, $total);
        $stmt->execute();

        
        $mensajeExito = "Pedido procesado correctamente.";
    } else {
        $mensajeExito = "Error al procesar el pedido: " . $stmt->error;
    }

    
    $mysqli->close();

    
    session_unset();
    session_destroy();
} else {
    $mensajeExito = "No se han recibido los datos necesarios.";
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
        overflow: hidden;
        transition: all 0.3s ease-in-out;
    }

    .hidden {
        display: none;
    }

    .loader {
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .title {
        font-size: 28px;
        color: #34495e;
        margin: 20px 0;
        font-weight: 500;
    }

    .message {
        font-size: 18px;
        color: #27ae60;
        margin: 10px 0;
        font-weight: 400;
    }

    .factura {
        margin: 20px 0;
        padding: 15px;
        background-color: #ecf0f1;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .factura h2 {
        margin-bottom: 10px;
        color: #34495e;
        font-weight: 500;
    }

    .btn {
        text-decoration: none;
        padding: 12px 25px;
        background-color: #F6BC1D;
        color: white;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 500;
        transition: background-color 0.3s ease, transform 0.3s ease;
        margin-top: 20px;
    }

    .btn:hover {
        background-color: #2980b9;
        transform: scale(1.05);
    }

    .btn:active {
        transform: scale(0.98);
    }
    </style>
</head>

<body>
    <div class="wrapper">

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

            <a href="../../../public/index.php" class="btn btn-primary">Regresar a la Página Principal</a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.getElementById('loader').classList.add('hidden');
            document.getElementById('content').classList.remove('hidden');
        }, 1000);
    });
    </script>
</body>

</html>