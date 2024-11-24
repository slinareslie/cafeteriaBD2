<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seleccionar Productos</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>

<body>
    <h1>Selecciona los Productos</h1>
    

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

        <form action="index.php?controller=empleado&action=factura" method="POST">
            <input type="hidden" name="cart_details" id="cart-details">
            <input type="hidden" name="subtotal" id="subtotal">
            <input type="hidden" name="igv" id="igv">
            <input type="hidden" name="total" id="total">
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
                            Agregar pedido
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <div id="cart-modal" class="modal hidden">
            <div class="modal-content">
                <div class="modal-header">
                    <span id="current-datetime"></span>
                    <span class="close-button" onclick="toggleCart()">×</span>
                </div>
                <h2>Pedido Nro 010</h2>
                <div class="form-row">
                    <label for="mesa">Mesa:</label>
                    <select id="mesa">
                        <option value="1">Mesa 1</option>
                        <option value="2">Mesa 2</option>
                        <option value="3">Mesa 3</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="empleado">Atiende:</label>
                    <select id="empleado">
                        <option value="1">Empleado 1</option>
                        <option value="2">Empleado 2</option>
                        <option value="3">Empleado 3</option>
                    </select>
                </div>
                <div id="cart-items"></div>
                <p class="total">Total: S/ <span id="cart-total">0.00</span></p>
                <button type="submit" class="btn-confirm">Proceder al Pago</button>
            </div>
            <form action="factura.php" method="POST">

                <input type="hidden" name="mesa" id="hidden-mesa" value="">

                <input type="hidden" name="cart_total_value" id="cart-total-value">
                <input type="hidden" name="subtotal" id="subtotal">
                <input type="hidden" name="igv" id="igv">
                <input type="hidden" name="total" id="total">
            </form>

            <script> 
                document.addEventListener("DOMContentLoaded", function () {
                    const mesaSelect = document.getElementById('mesa'); 
                    const hiddenMesaInput = document.getElementById('hidden-mesa'); 
                    if (mesaSelect) {
                        mesaSelect.addEventListener('change', function () {
                            hiddenMesaInput.value = mesaSelect.value;
                        });

                        hiddenMesaInput.value = mesaSelect.value;
                    }
                });
            </script>

        </div>            

            
            <input type="hidden" name="cart_total_value" id="cart-total-value">
        </form>

        <button id="cart-button">
            Ver Pedido
        </button>
    </div>
    <script src="../public/assets/js/functions.js"></script>
</body>

</html>