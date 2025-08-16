<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    // Verifica si el usuario ha iniciado sesión
    if (!isset($_SESSION['rol'])) {
        header('Location: ?c=login');
        exit;
    }

    $rol = $_SESSION['rol']; // Necesario para mostrar menús según el rol
    include 'views/navbar.php'; 
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Moviles</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-light">
        <div class="container py-5">
            <h2 class="mb-4 text-center">Gestión de Moviles</h2>
            <form method="GET" class="mb-4 row">
                <input type="hidden" name="c" value="movil">
                <div class="col-md-10">
                    <input type="text" name="buscar" value="<?= $_GET['buscar'] ?? '' ?>" class="form-control" placeholder="Buscar por nombre">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Buscar</button>
                </div>
            </form>
           <?php if ($rol == 1): ?>
                <div class="text-end mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalmovil">Agregar movil</button>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white shadow-sm">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th><th>Numero movil</th><th>placa</th><th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($moviles as $p): ?>
                            <tr>
                                <td><?= $p['idM'] ?></td>
                                <td><?= $p['nmovil'] ?></td>
                                <td><?= $p['placa'] ?></td>
                                <td class="text-center">
                                    <?php if ($rol == 1): ?>
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#modalmovil"
                                            onclick='cargarmovil(<?= json_encode($p) ?>)'>Editar</button>

                                          <a href="?c=movil&a=eliminar&id=<?= $p['idM'] ?>" 
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar este movil?')">Eliminar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal Crear/Editar -->
        <div class="modal fade" id="modalmovil" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="?c=movil&a=guardar" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Formulario movil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <input type="hidden" name="idM" id="idM">
                        <div class="col-md-4">
                            <label class="form-label">Movil</label>
                            <input type="text" name="nmovil" id="nmovil" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">placa</label>
                            <input type="text" name="placa" id="placa" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
        function cargarmovil(p) {
            document.getElementById('idM').value = p.idM;
            document.getElementById('nmovil').value = p.nmovil;
            document.getElementById('placa').value = p.placa;
            
        }
        </script>
    </body>
</html>