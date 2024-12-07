<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cafetería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    #hero {
        background: url('../app//views/img/cafeteria.jpg') no-repeat center center;
        background-size: cover;
        height: 100vh;
        color: white;
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

</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#nosotros">Nosotros</a></li>
                </ul>
            </div>
            
            <a class="navbar-brand mx-auto" href="#">
                <img src="../app//views/img/patomar3.png" alt="Patomar Café" style="height: 50px;">
            </a>
            
            <div class="d-flex align-items-center">
                <ul class="navbar-nav me-3">
                    <li class="nav-item"><a class="nav-link" href="#productos">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sedes">Sedes</a></li>
                </ul>
                <a onclick="location.href='login.html'" class="btn btn-outline-light btn-sm">Iniciar Sesión</a>
            </div>
        </div>
    </nav>

    <section id="hero">
        <img src="../app//views/img/patomar5.png" alt="Patomar Café" style="height: 250px;">
        <h1>Bienvenidos a PATOMAR CAFÉ</h1>
        <p>El mejor café para ti.</p>
    </section>

    <main class="mt-5">
        <div id="nosotros" class="container py-5">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="text-center mb-4">Sobre Nosotros</h2>
                    <p>
                        En nuestra cafetería, combinamos pasión por el café y el compromiso con la calidad para ofrecerte una experiencia única. 
                        Cada taza es preparada con granos seleccionados y técnicas artesanales, acompañada de un ambiente acogedor donde puedes relajarte, 
                        trabajar o compartir momentos especiales. Creemos en la importancia de los detalles y en el poder de una buena conversación 
                        alrededor de un excelente café. ¡Bienvenido a nuestra casa!
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="../app//views/img/patito.jpg" alt="Patito" class="img-fluid rounded">
                </div>
            </div>
        </div>

        <div id="productos" class="container py-5" style="position: relative; background: url('../app//views/img/productos.jpg') no-repeat center center; background-size: cover; color: white;">
            <h2 class="text-center mb-5" style="background-color: rgba(0, 0, 0, 0.5); display: inline-block; padding: 10px 20px; border-radius: 5px;">Nuestros Productos</h2>
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="product-card position-relative">
                        <img src="../app//views/img/expresso.jpg" alt="Promociones" class="img-fluid rounded">
                        <div class="overlay">
                            <span>Promociones</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="product-card position-relative">
                        <img src="../app//views/img/bebidasfrias.jpg" alt="Bebidas" class="img-fluid rounded">
                        <div class="overlay">
                            <span>Bebidas Frías</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="product-card position-relative">
                        <img src="../app//views/img/comidas.jpg" alt="Comidas" class="img-fluid rounded">
                        <div class="overlay">
                            <span>Comidas</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="product-card position-relative">
                        <img src="../app//views/img/postres.jpg" alt="Postres" class="img-fluid rounded">
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
  
        <div id="sedes" class="container py-5 text-center">
            <h2 class="mb-5">Nuestras Sedes</h2>
            <div class="row justify-content-center">
                <?php foreach ($sedes as $sede): ?>
                <div class="col-md-4 mb-4">
                    <div class="card border-0">
                        <?php 
                        switch ($sede['sede_id']) {
                            case 1:
                                $imagen = 'sede-central.jpg';
                                break;
                            case 2:
                                $imagen = 'sede-norte.jpg';
                                break;
                            case 3:
                                $imagen = 'sede-sur.jpg';
                                break;
                            default:
                                $imagen = 'default-sede.jpg'; 
                        }
                        ?>
                        <form action="index.php?controller=cliente&action=seleccionarProductos" method="POST">
                            <button type="submit" name="sede_id" value="<?php echo $sede['sede_id']; ?>" class="border-0 p-0 bg-transparent">
                                <img src="../app/views/img/<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo htmlspecialchars($sede['nombre_sede']); ?>" class="card-img-top img-fluid rounded">
                            </button>
                        </form>
                        <div class="card-body">
                            <p class="card-text fw-bold"><?php echo htmlspecialchars($sede['nombre_sede']); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($sede['direccion_sede']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            #sedes h2 {
                font-size: 2.5rem;
                font-weight: bold;
                color: #333;
            }

            #sedes img {
                transition: transform 0.3s ease;
            }

            #sedes img:hover {
                transform: scale(1.05); 
            }

            #sedes .card-text {
                font-size: 1.2rem;
                color: #555;
            }
        </style>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <p>© 2024 Mi Cafetería. Todos los derechos reservados.</p>
    </footer>

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
