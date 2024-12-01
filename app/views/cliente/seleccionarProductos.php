<?php
$sede_id = isset($_POST['sede_id']) ? $_POST['sede_id'] : null;

if (!$sede_id) {
    header("Location: seleccionarSede.php");
    exit;
}

$mesas = Mesa::obtenerMesasPorSede($sede_id);
$empleados = Empleado::obtenerEmpleadosPorSede($sede_id);
$productos = Producto::getAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seleccionar Productos</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>

<body>
    <h1>Selecciona los Productos</h1>
    <button id="cart-button">
        🛒 Ver Carrito
    </button>

    <div id="cart-modal" class="modal hidden">
        <div class="modal-content">
            <span class="close-button" onclick="toggleCart()">×</span>
            <h2>Carrito de Compras</h2>
            <div id="cart-items"></div>
            <p class="total">Total: S/ <span id="cart-total">0.00</span></p>
            <button class="btn-confirm">Proceder al Pago</button>
        </div>
    </div>

    <div id="products-container">
        <div class="tabs">
            <button class="tab-button" onclick="showCategory('bebidas')">Bebidas</button>
            <button class="tab-button" onclick="showCategory('comidas')">Comidas</button>
            <button class="tab-button" onclick="showCategory('postres')">Postres</button>
        </div>

        <div class="search-sort-container">
            <input type="text" id="search-bar" placeholder="Buscar productos..." oninput="filterProducts()">
            <select id="sort-options" onchange="sortProducts()">
                <option value="default">Ordenar por</option>
                <option value="asc">Precio: Menor a Mayor</option>
                <option value="desc">Precio: Mayor a Menor</option>
            </select>
        </div>

        <form action="index.php?controller=cliente&action=confirmarCompra" method="POST">
            <input type="hidden" name="cart_details" id="cart-details">
            <input type="hidden" name="subtotal" id="subtotal">
            <input type="hidden" name="igv" id="igv">
            <input type="hidden" name="total" id="total">

            <div class="form-row">
                <label for="mesa">Mesa:</label>
                <select id="mesa" name="mesa">
                    <option value="">Selecciona una Mesa</option>
                    <?php foreach ($mesas as $mesa): ?>
                    <option value="<?php echo $mesa['mesa_id']; ?>">Mesa <?php echo $mesa['numero_mesa']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <label for="empleado">Atiende:</label>
                <select id="empleado" name="empleado">
                    <option value="">Selecciona un Empleado</option>
                    <?php foreach ($empleados as $empleado): ?>
                    <option value="<?php echo $empleado['empleado_id']; ?>"><?php echo $empleado['nombre_empleado']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="products-grid" id="products-grid">
                <?php foreach ($productos as $producto): ?>
                <div class="product-card" data-name="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"
                    data-price="<?php echo $producto['precio']; ?>"
                    data-category="<?php echo $producto['categoria']; ?>">
                    <img src="https://placehold.co/300x200"
                        alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" class="product-image">
                    <h3><?php echo htmlspecialchars($producto['nombre_producto']); ?></h3>
                    <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <p class="price">S/ <?php echo number_format($producto['precio'], 2); ?></p>
                    <div class="quantity-container">
                        <label for="cantidad-<?php echo $producto['producto_id']; ?>">Cantidad:</label>
                        <input type="number" id="cantidad-<?php echo $producto['producto_id']; ?>"
                            name="cantidad[<?php echo $producto['producto_id']; ?>]" value="1" min="1">
                    </div>
                    <div class="product-selection">
                        <label>
                            <input type="checkbox" name="productos[]" value="<?php echo $producto['producto_id']; ?>">
                            Agregar al carrito
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn-confirm">Proceder al Pago</button>
            <input type="hidden" name="cart_total_value" id="cart-total-value">
            <input type="hidden" name="sede_id" value="<?php echo $sede_id; ?>">
        </form>
    </div>

    <script src="../public/assets/js/functions.js"></script>
</body>

</html>