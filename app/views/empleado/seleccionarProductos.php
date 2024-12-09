<?php
$sede_id = $_POST['sede_id'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seleccionar Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/style.css">

</head>

<style>
#hero {
    background: url('../app/views/img/cafeteria.jpg') no-repeat center center;
    background-size: cover;
    font-family: BlinkMacSystemFont;
    height: 50vh;
    color: white;
    width: 100vw;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.navbar {
    height: 100px;
    transition: background-color 0.3s ease, height 0.3s ease;
}

.navbar-brand img {
    height: 80px;
}

.navbar.scrolled {
    background-color: rgba(246, 188, 29, 0.9) !important;
    height: 80px;
}

#hero h1 {
    font-size: 4rem;
    font-weight: bold;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
}

#hero p {
    font-size: 1.5rem;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #f8f9fa;
    border-radius: 10px;
}
</style>
</head>


<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                </ul>
            </div>

            <a class="navbar-brand mx-auto" href="#">
                <img src="../app/views/img/patomar3.png" alt="Patomar Café" style="height: 50px;">
            </a>

            <div class="d-flex align-items-center">
                <ul class="navbar-nav me-3">
                    <li class="nav-item"><a class="nav-link" href="#products-container">Productos</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="hero">
        <img src="../app/views/img/patomar5.png" alt="Patomar Café" style="height: 20px;">
        <h1>Nuestra Carta</h1>
    </section>

    <div id="products-container">
        <div class="tabs"
            style="background: url('../app/views/img/productos.jpg') no-repeat center center; background-size: cover; padding: 20px; text-align: center; border-radius: 15px;">
            <h2 class="text-center mb-5"
                style="background-color: rgba(0, 0, 0, 0.5); color: white; padding: 10px 20px; border-radius: 15px; display: inline-block; margin: 0 auto;">
                Productos
            </h2>
            <div class="tab-image-container">
                <img src="../app/views/img/expresso.jpg" alt="Bebidas" class="tab-image" style="cursor: pointer;">
                <div class="overlay" onclick="showCategory('bebidas')">
                    <p>Bebidas</p>
                </div>
            </div>
            <div class="tab-image-container">
                <img src="../app/views/img/comidas.jpg" alt="Comidas" class="tab-image" style="cursor: pointer;">
                <div class="overlay" onclick="showCategory('comidas')">
                    <p>Comidas</p>
                </div>
            </div>
            <div class="tab-image-container">
                <img src="../app/views/img/postres.jpg" alt="Postres" class="tab-image" style="cursor: pointer;">
                <div class="overlay" onclick="showCategory('postres')">
                    <p>Postres</p>
                </div>
            </div>
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
            <input type="hidden" name="sede_id" value="<?php echo htmlspecialchars($sede_id); ?>">

            <div class="products-grid" id="products-grid">
                <?php foreach ($productos as $producto): ?>
                <div class="product-card" data-name="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"
                    data-price="<?php echo $producto['precio']; ?>"
                    data-category="<?php echo $producto['categoria']; ?>">
                    <?php 
                    // Switch para seleccionar la imagen según el ID de la sede
                    switch ($producto['producto_id']) {
                        case 1:
                            $imagen = 'prod1.jpg';
                            break;
                        case 2:
                            $imagen = 'prod2.jpg';
                            break;
                        case 3:
                            $imagen = 'prod3.jpg';
                            break;
                        case 4:
                            $imagen = 'prod4.jpg';
                            break;
                        case 5:
                            $imagen = 'prod5.jpg';
                            break;
                        case 6:
                            $imagen = 'prod6.jpg';
                            break;
                        case 7:
                            $imagen = 'prod7.jpg';
                            break;
                        case 8:
                            $imagen = 'prod8.jpg';
                            break;
                        default:
                            $imagen = 'default-sede.jpg';
                    }
                    ?>
                    <img src="../app/views/img/<?php echo htmlspecialchars($imagen); ?>"
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
                        <select id="mesa" name="mesa">
                            <?php foreach ($mesas as $mesa): ?>
                            <option value="<?php echo $mesa['mesa_id']; ?>">
                                <?php echo 'Mesa ' . $mesa['mesa_id']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="empleado">Atiende:</label>
                        <select id="empleado" name="empleado">
                            <?php foreach ($empleados as $empleado): ?>
                            <option value="<?php echo $empleado['empleado_id']; ?>">
                                <?php echo htmlspecialchars($empleado['nombre_empleado']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="cart-items"></div>
                    <p class="total">Total: S/ <span id="cart-total">0.00</span></p>
                    <button type="submit" class="btn-confirm">Proceder al Pago</button>
                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const mesaSelect = document.getElementById('mesa');
                        const hiddenMesaInput = document.getElementById('hidden-mesa');
                        if (mesaSelect) {
                            mesaSelect.addEventListener('change', function() {
                                hiddenMesaInput.value = mesaSelect.value;
                            });
                            hiddenMesaInput.value = mesaSelect.value;
                        }
                    });
                    </script>
                </div>
                <form action="factura.php" method="POST">
                    <input type="hidden" name="mesa" id="hidden-mesa" value="">
                    <input type="hidden" name="cart_total_value" id="cart-total-value">
                    <input type="hidden" name="subtotal" id="subtotal">
                    <input type="hidden" name="igv" id="igv">
                    <input type="hidden" name="total" id="total">
                </form>
            </div>

            <input type="hidden" name="cart_total_value" id="cart-total-value">
        </form>
        <button id="cart-button">
            Ver Pedido
        </button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    </script>
    <footer class="bg-dark text-white text-center py-3">
        <p>© 2024 Mi Cafetería. Todos los derechos reservados.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/assets/js/functions.js"></script>
</body>

</html>