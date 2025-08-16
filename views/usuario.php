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
        <title>Usuarios</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-light">
        <div class="container py-5">
            <h2 class="mb-4 text-center">Gestión de usuarios</h2>
            <form method="GET" class="mb-4 row">
                <input type="hidden" name="c" value="usuario">
                <div class="col-md-10">
                    <input type="text" name="buscar" value="<?= $_GET['buscar'] ?? '' ?>" class="form-control" placeholder="Buscar por nombre, NIT o producto">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Buscar</button>
                </div>
            </form>
           <?php if ($rol == 1): ?>
                <div class="text-end mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalusuario">Agregar usuario</button>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white shadow-sm">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th><th>ROL</th><th>Nombre</th><th>Teléfono</th>
                            <th>Correo</th><th>IDA</th><th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $p): ?>
                            <tr>
                                <td><?= $p['idA'] ?></td>
                                <td><?= $p['rol'] ?></td>
                                <td><?= $p['nombre'] ?></td>
                                <td><?= $p['telefono'] ?></td>
                                <td><?= $p['correo'] ?></td>
                                <td><?= $p['idA'] ?></td>
                                <td class="text-center">
                                    <?php if ($rol == 1): ?>
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#modalusuario"
                                            onclick='cargarusuario(<?= json_encode($p) ?>)'>Editar</button>

                                        <a href="?c=usuario&a=eliminar&id=<?= $p['idU'] ?>" 
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal Crear/Editar -->
        <div class="modal fade" id="modalusuario" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="?c=usuario&a=guardar" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Formulario usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <input type="hidden" name="idU" id="idU">
                        <div class="col-md-4">
                            <label class="form-label">rol</label>
                            <input type="text" name="rol" id="rol" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" id="correo" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Area</label>
                            <input type="text" name="idA" id="idA" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
        function cargarusuario(p) {
            document.getElementById('idU').value = p.idU;
            document.getElementById('rol').value = p.rol;
            document.getElementById('nombre').value = p.nombre;
            document.getElementById('telefono').value = p.telefono;
            document.getElementById('correo').value = p.correo;
            document.getElementById('idA').value = p.idA;
        }
        </script>
    </body>
</html>