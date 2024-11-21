<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Disponibles</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>

<body>
    <header>
        <div class="logo">Cafetería</div>
    </header>

    <main>
        <section class="search-sort">
            <form method="GET" action="/public/index.php?controller=producto&action=listar">
                <input type="text" name="buscar" class="search-bar" placeholder="Buscar productos..."
                    value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>">

                <select name="ordenar" class="sort-select">
                    <option value="p.nombre_producto"
                        <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'p.nombre_producto') ? 'selected' : ''; ?>>
                        Los más pedidos</option>
                    <option value="hp.precio ASC"
                        <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'hp.precio ASC') ? 'selected' : ''; ?>>
                        De menor a mayor</option>
                    <option value="hp.precio DESC"
                        <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'hp.precio DESC') ? 'selected' : ''; ?>>
                        De mayor a menor</option>
                </select>

                <select name="categoria" class="category-select">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat['categoria']; ?>"
                        <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat['categoria']) ? 'selected' : ''; ?>>
                        <?php echo ucfirst($cat['categoria']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn-search">Buscar</button>
            </form>
        </section>

        <section class="products">
            <?php if (empty($productos)): ?>
            <p>No se encontraron productos con los criterios seleccionados.</p>
            <?php else: ?>
            <?php foreach ($productos as $producto): ?>
            <div class="product-card">
                <img src="/public/assets/images/placeholder.jpg" alt="Imagen de Producto">
                <h3><?php echo htmlspecialchars($producto['nombre_producto']); ?></h3>
                <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                <p class="price">S/ <?php echo number_format($producto['precio'], 2); ?></p>
                <form method="POST" action="/public/index.php?controller=pedido&action=agregar">
                    <input type="hidden" name="producto_id" value="<?php echo $producto['producto_id']; ?>">
                    <label for="cantidad-<?php echo $producto['producto_id']; ?>">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad-<?php echo $producto['producto_id']; ?>" value="1"
                        min="1">
                    <button type="submit" class="add-to-cart">Agregar al carrito</button>
                </form>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>