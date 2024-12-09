<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión o Registrarse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: url('../app/views/img/cafeteria.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    .form-container {
        max-width: 400px;
        margin: auto;
        margin-top: 5%;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 20px;
    }

    .nav-tabs .nav-link.active {
        background-color: #f6bc1d;
        color: white !important;
        border-radius: 5px;
    }

    .form-control {
        border-radius: 10px;
    }

    .btn-primary {
        background-color: #f6bc1d;
        border: none;
    }

    .btn-primary:hover {
        background-color: #cfa019;
    }

    .navbar {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .navbar-brand img {
        height: 40px;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="../app/views/img/patomar5.png" alt="Patomar Café">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>
    <div class="form-container">
        <ul class="nav nav-tabs justify-content-center mb-4" id="authTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
                    type="button" role="tab" aria-controls="login" aria-selected="true">
                    Iniciar Sesión
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button"
                    role="tab" aria-controls="register" aria-selected="false">
                    Registrarse
                </button>
            </li>
        </ul>
        <div class="tab-content" id="authTabContent">
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                <form>
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="loginEmail" placeholder="ejemplo@correo.com">
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="loginPassword" placeholder="Contraseña">
                    </div>
                    <div class="d-grid">
                        <button
                            onclick="event.preventDefault(); window.location.href='index.php?controller=cliente&action=seleccionarSede';"
                            class="btn btn-primary">Cliente</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                <form>
                    <div class="mb-3">
                        <label for="registerName" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="registerName" placeholder="Tu nombre">
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="registerEmail" placeholder="ejemplo@correo.com">
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="registerPassword" placeholder="Contraseña">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirmPassword"
                            placeholder="Repetir contraseña">
                    </div>
                    <div class="d-grid">
                        <button
                            onclick="event.preventDefault(); window.location.href='index.php?controller=empleado&action=seleccionarSede';"
                            class="btn btn-primary">Empleado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>