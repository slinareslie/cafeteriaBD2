<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seleccionar Sede</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">

</head>

<body>
    <h1>Selecciona una Sede</h1>
    <form action="index.php?tipo=usuario&controller=cliente&action=seleccionarProductos" method="POST">
        <select name="sede_id">
            <?php foreach ($sedes as $sede): ?>
            <option value="<?php echo $sede['sede_id']; ?>"><?php echo $sede['nombre_sede']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Seleccionar</button>
    </form>
</body>

</html>