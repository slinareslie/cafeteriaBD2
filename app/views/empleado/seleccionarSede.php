<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seleccionar Sede</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>

<body>
    <h1>Selecciona una Sede</h1>
    <div id="sede-container">
        <div class="sede-grid">
            <?php foreach ($sedes as $sede): ?>
            <div class="sede-card">
                <h3><?php echo htmlspecialchars($sede['nombre_sede']); ?></h3>
                <p><?php echo htmlspecialchars($sede['direccion_sede']); ?></p>
                <form action="index.php?controller=empleado&action=seleccionarProductos" method="POST">
                    <button type="submit" name="sede_id" value="<?php echo $sede['sede_id']; ?>" class="btn-select">
                        Seleccionar Sede
                    </button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>