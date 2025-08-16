<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['rol'])) {
    header('Location: ?c=login');
    exit;
}
$rol = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <title>navbar</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="?c=home">ORDENES DE COMPRA</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido" aria-controls="navbarContenido" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContenido">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?= ($_GET['c'] ?? '') == 'home' ? 'active' : '' ?>" href="?c=home">Inicio</a>
                        </li>
                        <?php if ($rol == 1): // ADMIN ?>
                            <li class="nav-item"><a class="nav-link" href="?c=area">Área</a></li>
                            <li class="nav-item"><a class="nav-link" href="?c=dato">Data</a></li>
                            <li class="nav-item"><a class="nav-link" href="?c=movil">Móvil</a></li>
                            <li class="nav-item"><a class="nav-link" href="?c=proveedor">Proveedor</a></li>
                            <li class="nav-item"><a class="nav-link" href="?c=usuario">Usuario</a></li>
                            <li class="nav-item"><a class="nav-link" href="?c=config">config</a></li>
                        <?php elseif ($rol == 2): // COMPRADOR ?>
                            <li class="nav-item"><a class="nav-link" href="?c=dato">Data</a></li>
                            <li class="nav-item"><a class="nav-link" href="?c=proveedor">Proveedor</a></li>
                        <?php elseif ($rol == 3): // VISITANTE ?>
                            <li class="nav-item"><a class="nav-link" href="?c=home">Consulta</a></li>
                        <?php endif; ?>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="perfilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="img/logo.png" alt="Perfil" width="30" height="30" class="rounded-circle me-2">
                                <?= $_SESSION['nombre'] ?? '' ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="perfilDropdown">
                                <li>
                                    <a class="dropdown-item text-danger" href="?c=login&a=logout">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </body>
</html>