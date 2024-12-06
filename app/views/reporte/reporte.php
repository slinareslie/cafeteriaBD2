<?php
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

    .report-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1>Generar Reporte de Usuarios</h1>

        <!-- Formulario para filtros (ahora sin la opción de sedes) -->
        <form id="reportForm">
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio">

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin">

            <button type="submit">Generar Reporte</button>
        </form>

        <!-- Sección para mostrar el reporte -->
        <div class="report-section">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($usuarios) > 0): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td><?php echo $usuario['fecha_registro']; ?></td>
                        <td><a href="detalle.php?id=<?php echo $usuario['id']; ?>">Ver Detalles</a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4">No se encontraron usuarios para el reporte.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    // Funcionalidad para mostrar el reporte después de generar
    document.getElementById('reportForm').addEventListener('submit', function(event) {
        event.preventDefault();
        // Aquí iría la lógica para obtener los datos según las fechas seleccionadas
        document.querySelector('.report-section').style.display = 'block';
    });
    </script>

</body>

</html>