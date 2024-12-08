<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PATOMAR -CAFE</title>
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
                    <li class="nav-item"><a class="nav-link" href="#nosotros">Nosotros</a></li>
                </ul>
            </div>
            
            <a class="navbar-brand mx-auto" href="#">
                <img src="../app//views/img/patomar3.png" alt="Patomar Café" style="height: 50px;">
            </a>
            
            <div class="d-flex align-items-center">
                <ul class="navbar-nav me-3">                   
                    <li class="nav-item"><a class="nav-link" href="#sedes">Sedes</a></li>
                </ul>
                <form action="index.php?controller=empleado&action=verReporte" method="POST">
                    <a href="javascript:void(0);" onclick="this.closest('form').submit();" class="text-decoration-none">
                        <span style="color: #ddd;">Reporte</span>
                    </a>
                </form>
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
                        <form action="index.php?controller=empleado&action=seleccionarProductos" method="POST">
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
