<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seleccionar Productos</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    #hero {
        background: url('../app/views/img/cafeteria.jpg') no-repeat center center;
        background-size: cover;
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
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#nosotros">Nosotros</a></li>
                </ul>
            </div>
            
            <a class="navbar-brand mx-auto" href="#">
                <img src="../app/views/img/patomar3.png" alt="Patomar Café" style="height: 50px;">
            </a>
            
            <div class="d-flex align-items-center">
                <ul class="navbar-nav me-3">
                    <li class="nav-item"><a class="nav-link" href="#productos">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sedes">Sedes</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="hero">
        <img src="../app/views/img/patomar5.png" alt="Patomar Café" style="height: 20px;">
        <h1>Nuestra Carta</h1>        
    </section>

    <div id="products-container">
        <div id="productos" class="container py-5" style="position: relative; background: url('../app/views/img/productos.jpg') no-repeat center center; background-size: cover; color: white;">
            <h2 class="text-center mb-5" style="background-color: rgba(0, 0, 0, 0.5); display: inline-block; padding: 10px 20px; border-radius: 5px;">Nuestros Productos</h2>
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="product-card position-relative" onclick="showCategory('promociones')">
                        <img src="../app/views/img/expresso.jpg" alt="Promociones" class="img-fluid rounded">
                        <div class="overlay">
                            <span>Promociones</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="product-card position-relative" onclick="showCategory('bebidas')">
                        <img src="../app/views/img/bebidasfrias.jpg" alt="Bebidas" class="img-fluid rounded">
                        <div class="overlay">
                            <span>Bebidas Frías</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="product-card position-relative" onclick="showCategory('comidas')">
                        <img src="../app/views/img/comidas.jpg" alt="Comidas" class="img-fluid rounded">
                        <div class="overlay">
                            <span>Comidas</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="product-card position-relative" onclick="showCategory('postres')">
                        <img src="../app/views/img/postres.jpg" alt="Postres" class="img-fluid rounded">
                        <div class="overlay">
                            <span>Postres</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            #productos .product-card {
                position: relative;
                overflow: hidden;
            }

            #productos img {
                transition: transform 0.3s;
            }

            #productos .overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(246, 188, 29, 0.9); 
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0; 
                transition: opacity 0.3s ease;
            }

            #productos .overlay span {
                color: #000;
                font-weight: bold;
                font-size: 1.2rem;
            }

            #productos .product-card:hover img {
                transform: scale(1.1);
            }

            #productos .product-card:hover .overlay {
                opacity: 1; 
            }
        </style>

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

            
            <div class="modal fade" id="cart-modal" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog">
                    <div  class="modal-content">
                        <div class="modal-header">
                            <span id="current-datetime"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn-confirm">Realizar compra</button>
                        </div>
                    </div>
                </div>    
                
                <form action="factura.php" method="POST">
                    <input type="hidden" name="mesa" id="hidden-mesa" value="">
                    <input type="hidden" name="cart_total_value" id="cart-total-value">
                    <input type="hidden" name="subtotal" id="subtotal">
                    <input type="hidden" name="igv" id="igv">
                    <input type="hidden" name="total" id="total">
                </form>
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
            
            <input type="hidden" name="cart_total_value" id="cart-total-value">
        </form>

        <button id="ver-pedido" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cart-modal">
            Ver pedido
        </button>

        <script>
            document.getElementById('cart-button').addEventListener('click', function() {
                // Abre el modal con id cart-modal
                var myModal = new bootstrap.Modal(document.getElementById('carrito'));
                myModal.show();
            });
        </script>
    </div>
    
    <footer class="bg-dark text-white text-center py-3">
        <p>© 2024 Mi Cafetería. Todos los derechos reservados.</p>
    </footer>
    <script src="../public/assets/js/functions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>