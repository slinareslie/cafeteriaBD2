<?php
// Incluye el archivo del controlador
require_once '../controllers/reportController.php';

// Obtener las sedes desde el controlador
$controller = new ReportController();
$sedes = $controller->showSedes();
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
        display: none;
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
    </style>
</head>

<body>

    <div class="container">
        <h1>Generar Reporte de Usuarios</h1>

        <form id="reportForm">
            <label for="sede">Seleccionar Sede:</label>
            <select id="sede" name="sede">
                <option value="">Seleccione una sede</option>
                <?php foreach ($sedes as $sede): ?>
                <option value="<?= $sede['sede_id']; ?>"><?= $sede['nombre_sede']; ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="startDate">Fecha de Inicio:</label>
            <input type="date" id="startDate" name="startDate" required><br><br>

            <label for="endDate">Fecha de Fin:</label>
            <input type="date" id="endDate" name="endDate" required><br><br>

            <button type="button" onclick="generateReport()">Generar Reporte</button>
        </form>

        <div id="reportSection" class="report-section">
            <h2>Reporte de Clientes por Entrega</h2>
            <table id="reportTable" class="report-table">
                <thead>
                    <tr>
                        <th>ID Cliente</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha Pedido</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Datos del reporte se mostrarán aquí -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function generateReport() {
        const sede = document.getElementById('sede').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        if (!sede || !startDate || !endDate) {
            alert('Por favor, complete todos los campos.');
            return;
        }

        const formData = new FormData();
        formData.append('sede', sede);
        formData.append('startDate', startDate);
        formData.append('endDate', endDate);

        fetch('reportController.php?action=getDeliveryClients', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const reportSection = document.getElementById('reportSection');
                const reportTable = document.getElementById('reportTable').getElementsByTagName('tbody')[0];

                // Limpiar tabla antes de mostrar nuevos resultados
                reportTable.innerHTML = '';

                // Mostrar resultados
                if (data.length > 0) {
                    data.forEach(client => {
                        const row = reportTable.insertRow();
                        row.innerHTML = `
                            <td>${client.client_id}</td>
                            <td>${client.name}</td>
                            <td>${client.email}</td>
                            <td>${client.order_date}</td>
                        `;
                    });
                    reportSection.style.display = 'block';
                } else {
                    reportSection.style.display = 'none';
                    alert('No se encontraron clientes para este rango de fechas.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al generar el reporte.');
            });
    }
    </script>

</body>

</html>