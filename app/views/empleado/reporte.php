<?php
$servername = "srv1006.hstgr.io";
$username = "u472469844_est27";
$password = "#Bd00027";
$dbname = "u472469844_est27";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
error_reporting(0);
$Sedes = [];

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
    $fecha = $_POST['fecha'];
    $fecha_fin = $_POST['fecha_fin'];
    $accion = $_POST['accion'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTE CAFETERIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <style>
    #hero {
        background: url('../app//views/img/reporte.jpg') no-repeat center center;
        background-size: cover;
        font-family: BlinkMacSystemFont;
        height: 80vh;
        color: white;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin-top: 0px;
    }

    .navbar {
        height: 100px;
        transition: background-color 0.3s ease, height 0.3s ease;
    }

    .navbar-brand img {
        height: 80px;
    }

    .navbar.scrolled {
        background-color: rgba(246, 188, 29, 0.9) !important;
        height: 80px;
    }

    #hero h1 {
        font-size: 4rem;
        font-weight: bold;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    }

    #hero p {
        font-size: 1.5rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }


    .reporte {
        width: 80%;
        height: 100vh;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        background-color: #e6b222;
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
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                </ul>
            </div>
            <a class="navbar-brand mx-auto" href="#">
                <img src="../app//views/img/patomar3.png" alt="Patomar Café" style="height: 50px;">
            </a>

        </div>
    </nav>

    <section id="hero">
        <img src="../app//views/img/patomar5.png" alt="Patomar Café" style="height: 250px;">
        <h1>Reportes de Cafeteria</h1>
    </section>

    <div class="reporte">

        <form method="POST">
            <label for="sede">Selecciona una sede:</label>
            <select name="sede" id="sede" required>
                <option value="">Seleccione una sede</option>
                <?php foreach ($Sedes as $sede): ?>
                <option value="<?php echo $sede['sede_id']; ?>"
                    <?php echo (isset($_POST['sede']) && $_POST['sede'] == $sede['sede_id']) ? 'selected' : ''; ?>>
                    <?php echo $sede['nombre_sede']; ?>
                </option>
                <?php endforeach; ?>
            </select>


            <div id="fecha-rango" style="display: none;">
                <label for="fecha_inicio">Fecha de inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio"
                    value="<?php echo isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : ''; ?>">

                <label for="fecha_fin">Fecha de fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin"
                    value="<?php echo isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : ''; ?>">
            </div>


            <div id="fecha-especifica" style="display: none;">
                <label for="fecha">Fecha específica:</label>
                <input type="date" name="fecha" id="fecha"
                    value="<?php echo isset($_POST['fecha']) ? $_POST['fecha'] : ''; ?>">
            </div>


            <label for="accion">Seleccione el reporte:</label>
            <select name="accion" id="accion" onchange="mostrarCamposFecha()" required>
                <option value="1" <?php echo (isset($_POST['accion']) && $_POST['accion'] == 1) ? 'selected' : ''; ?>>
                    Reporte 1: Clientes por Delivery</option>
                <option value="2" <?php echo (isset($_POST['accion']) && $_POST['accion'] == 2) ? 'selected' : ''; ?>>
                    Reporte 2: Ranking de Productos Vendidos</option>
                <option value="3" <?php echo (isset($_POST['accion']) && $_POST['accion'] == 3) ? 'selected' : ''; ?>>
                    Reporte 3: Cantidad de Pedidos por Hora</option>
                <option value="4" <?php echo (isset($_POST['accion']) && $_POST['accion'] == 4) ? 'selected' : ''; ?>>
                    Reporte 4: Clientes con Pedidos Mayores a 50 Soles</option>
                <option value="5" <?php echo (isset($_POST['accion']) && $_POST['accion'] == 5) ? 'selected' : ''; ?>>
                    Reporte 5: Monto Total de Ventas por Sede</option>
            </select>

            <button type="submit">Generar Reporte</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            switch ($accion) {
    case '1':
        
        $sql = "
            SELECT c.nombre, c.direccion, c.telefono, p.fecha_pedido
            FROM Clientes c
            JOIN Pedidos p ON c.cliente_id = p.cliente_id
            WHERE p.sede_id = ? 
            AND p.tipo_pedido = 'delivery'
            AND p.fecha_pedido BETWEEN ? AND ?
        ";
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
        
        $sql = "
            SELECT HOUR(p.fecha_pedido) AS hora, COUNT(*) AS total_pedidos
            FROM Pedidos p
            WHERE p.sede_id = ? 
            AND DATE(p.fecha_pedido) = ?
            GROUP BY HOUR(p.fecha_pedido)
            HAVING hora BETWEEN 9 AND 20
            ORDER BY hora
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $sede_id, $fecha);
        $stmt->execute();
        $result = $stmt->get_result();

        
        $horas = range(9, 20);
        $pedidos_por_hora = [];

        
        while ($row = $result->fetch_assoc()) {
            $pedidos_por_hora[$row['hora']] = $row['total_pedidos'];
        }

        echo "<div class='report-section'><h2>Cantidad de Pedidos por Hora</h2>";
        echo "<table><tr><th>Hora</th><th>Total Pedidos</th></tr>";
        
        
        foreach ($horas as $hora) {
            $total_pedidos = isset($pedidos_por_hora[$hora]) ? $pedidos_por_hora[$hora] : 0;
            echo "<tr><td>{$hora}-".($hora + 1)."</td><td>{$total_pedidos}</td></tr>";
        }
        
        echo "</table></div>";
        break;

    case '4':
    

    $sql = "
        SELECT c.nombre, c.direccion, c.telefono, p.total
        FROM Clientes c
        INNER JOIN Pedidos p ON c.cliente_id = p.cliente_id
        WHERE p.sede_id = ? 
        AND p.tipo_pedido = 'local' 
        AND DATE(p.fecha_pedido) = ?
        AND p.total > 50
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $sede_id, $fecha);  
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        document.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        </script>
</body>

<script>
function mostrarCamposFecha() {
    const accion = document.getElementById("accion").value;
    const fechaRango = document.getElementById("fecha-rango");
    const fechaEspecifica = document.getElementById("fecha-especifica");

    if (accion === "1" || accion === "2" || accion === "5") {
        fechaRango.style.display = "block";
        fechaEspecifica.style.display = "none";
    } else if (accion === "3" || accion === "4") {
        fechaRango.style.display = "none";
        fechaEspecifica.style.display = "block";
    } else {
        fechaRango.style.display = "none";
        fechaEspecifica.style.display = "none";
    }
}


window.onload = mostrarCamposFecha;

document.addEventListener("DOMContentLoaded", function() {
    mostrarCamposFecha();
});
</script>

</html>