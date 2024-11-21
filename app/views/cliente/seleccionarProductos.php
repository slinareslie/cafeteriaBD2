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
        <div class="search-sort-container">
            <input type="text" id="search-bar" placeholder="Buscar productos..." oninput="filterProducts()">
            <select id="sort-options" onchange="sortProducts()">
                <option value="default">Ordenar por</option>
                <option value="asc">Precio: Menor a Mayor</option>
                <option value="desc">Precio: Mayor a Menor</option>
            </select>
        </div>
        <form action="index.php?controller=cliente&action=confirmarCompra" method="POST">
            <div class="products-grid" id="products-grid">
                <?php foreach ($productos as $producto): ?>
                <div class="product-card" data-name="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"
                    data-price="<?php echo $producto['precio']; ?>">
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
            <button type="submit" class="btn-confirm">Confirmar</button>
        </form>
    </div>
    <script src="../public/assets/js/functions.js"></script>
</body>

</html>