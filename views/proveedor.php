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
        <title>Proveedores</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-light">
        <div class="container py-5">
            <h2 class="mb-4 text-center">Gestión de Proveedores</h2>
            <form method="GET" class="mb-4 row">
                <input type="hidden" name="c" value="proveedor">
                <div class="col-md-10">
                    <input type="text" name="buscar" value="<?= $_GET['buscar'] ?? '' ?>" class="form-control" placeholder="Buscar por nombre, NIT o producto">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Buscar</button>
                </div>
            </form>
           <?php if ($rol == 1 || $rol == 2): ?>
                <div class="text-end mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalProveedor">Agregar Proveedor</button>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white shadow-sm">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th><th>IT</th><th>NIT</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Contacto</th>
                            <th>Correo</th><th>Producto</th><th>Tipo</th><th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proveedores as $p): ?>
                            <tr>
                                <td><?= $p['idP'] ?></td>
                                <td><?= $p['it'] ?></td>
                                <td><?= $p['nit'] ?></td>
                                <td><?= $p['nombre'] ?></td>
                                <td><?= $p['direccion'] ?></td>
                                <td><?= $p['telefono'] ?></td>
                                <td><?= $p['contacto'] ?></td>
                                <td><?= $p['correo'] ?></td>
                                <td><?= $p['producto'] ?></td>
                                <td><?= $p['tipo'] ?></td>
                                <td class="text-center">
                                    <?php if ($rol == 1): ?>
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#modalProveedor"
                                            onclick='cargarProveedor(<?= json_encode($p) ?>)'>Editar</button>

                                        <a href="?c=proveedor&a=eliminar&id=<?= $p['idP'] ?>" 
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal Crear/Editar -->
        <div class="modal fade" id="modalProveedor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="?c=proveedor&a=guardar" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Formulario Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <input type="hidden" name="idP" id="idP">
                        <div class="col-md-4">
                            <label class="form-label">IT</label>
                            <input type="number" name="it" id="it" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">NIT</label>
                            <input type="text" name="nit" id="nit" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contacto</label>
                            <input type="text" name="contacto" id="contacto" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" id="correo" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Producto</label>
                            <input type="text" name="producto" id="producto" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo</label>
                            <input type="text" name="tipo" id="tipo" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
        function cargarProveedor(p) {
            document.getElementById('idP').value = p.idP;
            document.getElementById('it').value = p.it;
            document.getElementById('nit').value = p.nit;
            document.getElementById('nombre').value = p.nombre;
            document.getElementById('direccion').value = p.direccion;
            document.getElementById('telefono').value = p.telefono;
            document.getElementById('contacto').value = p.contacto;
            document.getElementById('correo').value = p.correo;
            document.getElementById('producto').value = p.producto;
            document.getElementById('tipo').value = p.tipo;
        }
        </script>
    </body>
</html>