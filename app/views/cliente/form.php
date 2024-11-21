<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Cliente</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>

<body>
    <h1>Registrar Cliente</h1>
    <form action="/public/cliente/registrar.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required><br>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" id="direccion" required><br>
        <button type="submit">Registrar</button>
    </form>
</body>

</html>