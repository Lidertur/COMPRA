<?php
//$contraseña = "DANIEL123";
//$hash = password_hash($contraseña, PASSWORD_DEFAULT);
//echo $hash;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso - Sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f2f5, #dfe3e8);
            min-height: 100vh;
            display: flex;
            align-items: left;
            justify-content: left;
            padding: 20px;
        }
        .login-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        .login-image {
            background: url('img/login.jpg') left left/cover no-repeat;
        }
        .form-section {
            padding: 50px;
        }
        .logo-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        .nav-tabs .nav-link.active {
            background-color: #212529;
            color: white;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .tab-content {
            margin-left: -200px;
            margin-right: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row login-card" >
            <!-- Imagen / logo -->
            <div class="col-md-5 login-image d-none d-md-block">
                <!-- Imagen de fondo desde CSS -->
            </div>
            <!-- Formulario -->
            <div class="col-md-7 form-section" >
                <div class="text-left mb-4">
                    <img src="img/Logo.png" alt="Logo" class="logo-img mb-2">
                    <h4 class="fw-bold">Sistema de Órdenes</h4>
                    <p class="text-muted">Bienvenido, inicia sesión o regístrate</p>
                </div>

                <ul class="nav nav-tabs mb-3 justify-content-left" id="loginTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button">Iniciar Sesión</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button">Registrarse</button>
                    </li>
                </ul>
                <div class="tab-content" id="loginTabsContent">
                    <!-- Login -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        <form action="?c=login&a=validar" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="contraseña" class="form-label">Contraseña</label>
                                <input type="password" name="contraseña" id="contraseña" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Ingresar</button>
                        </form>
                    </div>
                    <!-- Registro -->
                    <div class="tab-pane fade" id="register" role="tabpanel">
                        <?php if (isset($registro_error)): ?>
                            <div class="alert alert-danger"><?= $registro_error ?></div>
                        <?php endif; ?>
                        <form action="?c=login&a=registrar" method="POST">
                            <div class="mb-3">
                                <label for="r_nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="r_nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="r_contraseña" class="form-label">Contraseña</label>
                                <input type="password" name="contraseña" id="r_contraseña" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" name="correo" id="correo" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
