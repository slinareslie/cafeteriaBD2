<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CafeteriaDB";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$Sedes = [];
// Obtener las sedes
$sql = "SELECT * FROM sedes";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $Sedes[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sede_id = $_POST['sede'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $accion = $_POST['accion'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes Cafetería</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
    }

    form {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
    }

    input[type="date"],
    select {
        padding: 8px;
        margin: 5px;
        border: 1px solid #ddd;
    }

    button {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .report-section {
        margin-top: 20px;
    }

    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1>Generar Reportes de Cafetería</h1>

        <form method="POST">
            <label for="sede">Selecciona una sede:</label>
            <select name="sede" id="sede" required>
                <option value="">Seleccione una sede</option>
                <?php foreach ($Sedes as $sede): ?>
                <option value="<?php echo $sede['sede_id']; ?>"><?php echo $sede['nombre_sede']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="fecha_inicio">Fecha de inicio:</label>
            <input type="date" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de fin:</label>
            <input type="date" name="fecha_fin" required>

            <label for="accion">Seleccione el reporte:</label>
            <select name="accion" required>
                <option value="1">Listado de clientes por delivery</option>
                <option value="2">Ranking de productos vendidos</option>
                <option value="3">Pedidos por hora en mesa</option>
                <option value="4">Clientes con pedidos mayores a 50 soles</option>
                <option value="5">Monto total de ventas por sede</option>
            </select>

            <button type="submit">Generar Reporte</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            switch ($accion) {
    case '1':
        // Reporte 1: Listado de clientes por delivery
        $sql = "
            SELECT c.nombre, c.direccion, c.telefono, p.fecha_pedido
            FROM Clientes c
            JOIN Pedidos p ON c.cliente_id = p.cliente_id
            WHERE p.sede_id = ? 
            AND p.tipo_pedido = 'delivery'
            AND p.fecha_pedido BETWEEN ? AND ?
        ";
        echo "sede_id: " . $sede_id . "\n";
echo "fecha_inicio: " . $fecha_inicio . "\n";
echo "fecha_fin: " . $fecha_fin . "\n";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $sede_id, $fecha_inicio, $fecha_fin);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<div class='report-section'><h2>Clientes que pidieron por delivery</h2>";
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Fecha Pedido</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['nombre']}</td><td>{$row['direccion']}</td><td>{$row['telefono']}</td><td>{$row['fecha_pedido']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }
        echo "</div>";
        break;

    case '2':
        // Reporte 2: Ranking de productos vendidos
        $sql = "
            SELECT pr.nombre_producto, SUM(dp.cantidad) AS total_vendido
            FROM Pedidos p
            JOIN Detalle_Pedido dp ON p.pedido_id = dp.pedido_id
            JOIN Productos pr ON dp.producto_id = pr.producto_id
            WHERE p.sede_id = ? 
            AND p.tipo_pedido = 'delivery' 
            AND p.fecha_pedido BETWEEN ? AND ?
            GROUP BY pr.nombre_producto
            ORDER BY total_vendido DESC
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $sede_id, $fecha_inicio, $fecha_fin);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<div class='report-section'><h2>Ranking de Productos Vendidos por Delivery</h2>";
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Producto</th><th>Cantidad Vendida</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['nombre_producto']}</td><td>{$row['total_vendido']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }
        echo "</div>";
        break;

    case '3':
        // Reporte 3: Cantidad de pedidos por hora
        $sql = "
            SELECT HOUR(p.fecha_pedido) AS hora, COUNT(*) AS total_pedidos
            FROM Pedidos p
            WHERE p.sede_id = ? 
            AND p.fecha_pedido BETWEEN ? AND ?
            GROUP BY HOUR(p.fecha_pedido)
            HAVING hora BETWEEN 9 AND 20
            ORDER BY hora
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $sede_id, $fecha_inicio, $fecha_fin);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<div class='report-section'><h2>Cantidad de Pedidos por Hora</h2>";
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Hora</th><th>Total Pedidos</th></tr>";
            for ($i = 9; $i <= 20; $i++) {
                $found = false;
                while ($row = $result->fetch_assoc()) {
                    if ($row['hora'] == $i) {
                        echo "<tr><td>{$i}-".($i+1)."</td><td>{$row['total_pedidos']}</td></tr>";
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    echo "<tr><td>{$i}-".($i+1)."</td><td>0</td></tr>";
                }
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }
        echo "</div>";
        break;

    case '4':
        // Reporte 4: Clientes con pedidos mayores a 50 Soles
        $sql = "
            SELECT c.nombre, c.direccion, c.telefono, p.total
            FROM Clientes c
            INNER JOIN Pedidos p ON c.cliente_id = p.cliente_id
            WHERE p.sede_id = ? 
            AND p.tipo_pedido = 'mesa' 
            AND p.fecha_pedido = ? 
            AND p.total > 50
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $sede_id, $fecha_inicio);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<div class='report-section'><h2>Clientes con Pedidos Mayores a 50 Soles</h2>";
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Total</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['nombre']}</td><td>{$row['direccion']}</td><td>{$row['telefono']}</td><td>{$row['total']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }
        echo "</div>";
        break;

    case '5':
        // Reporte 5: Monto Total de Ventas por Sede
        $sql = "
            SELECT SUM(p.total) AS monto_total
            FROM Pedidos p
            WHERE p.sede_id = ? 
            AND p.fecha_pedido BETWEEN ? AND ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $sede_id, $fecha_inicio, $fecha_fin);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<div class='report-section'><h2>Monto Total de Ventas por Sede</h2>";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<p>Monto Total de Ventas: S/. " . number_format($row['monto_total'], 2) . "</p>";
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }
        echo "</div>";
        break;
        }

        }
?>

</body>

</html>