<?php
// Aquí puedes incluir el código PHP para manejar la conexión a la base de datos y generar los reportes.
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios</title>
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

    label {
        font-weight: bold;
        margin-top: 10px;
    }

    input[type="date"] {
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

    .report-table {
        width: 100%;
        border-collapse: collapse;
    }

    .report-table th,
    .report-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .report-table th {
        background-color: #f2f2f2;
    }

    .no-data {
        text-align: center;
        color: red;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Reporte de Usuarios</h1>

        <!-- Formulario para seleccionar las fechas -->
        <!-- Formulario para seleccionar sede y rango de fechas -->

        <form action="index.php?controller=reporte&action=mostrarReporte" method="POST">
            <label for="sede">Selecciona una Sede:</label>
            <select name="sede" id="sede">
                <!-- Aquí puedes recorrer las sedes con un ciclo -->
                <?php foreach ($sedes as $sede): ?>
                <option value="<?php echo $sede['sede_id']; ?>"><?php echo $sede['nombre_sede']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="startDate">Fecha de Inicio:</label>
            <input type="date" name="startDate" id="startDate">

            <label for="endDate">Fecha de Fin:</label>
            <input type="date" name="endDate" id="endDate">

            <button type="submit">Generar Reporte</button>
        </form>


        <div class="report-section">
            <?php
            // Lógica para generar el reporte y mostrarlo en la tabla
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['startDate'], $_GET['endDate'])) {
                $startDate = $_GET['startDate'];
                $endDate = $_GET['endDate'];

                // Aquí puedes incluir el código para obtener los datos de la base de datos
                // Dependiendo de la base de datos, por ejemplo:
                // $users = getUsersByDateRange($startDate, $endDate);

                // Simulación de datos de ejemplo
                $users = [
                    ['id' => 1, 'name' => 'Juan Pérez', 'email' => 'juan@example.com', 'registration_date' => '2024-01-15'],
                    ['id' => 2, 'name' => 'Ana Gómez', 'email' => 'ana@example.com', 'registration_date' => '2024-02-20']
                ];

                if (count($users) > 0) {
                    echo '<table class="report-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo Electrónico</th>
                                    <th>Fecha de Registro</th>
                                </tr>
                            </thead>
                            <tbody>';
                    
                    foreach ($users as $user) {
                        echo '<tr>
                                <td>' . $user['id'] . '</td>
                                <td>' . $user['name'] . '</td>
                                <td>' . $user['email'] . '</td>
                                <td>' . $user['registration_date'] . '</td>
                              </tr>';
                    }

                    echo '</tbody></table>';
                } else {
                    echo '<p class="no-data">No se encontraron usuarios para el rango de fechas seleccionado.</p>';
                }
            }
            ?>
        </div>
    </div>
</body>

</html>