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
    <title>Configuración de Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center">CONFIGURAR ACCESOS</h2>

    <div class="text-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar nuevo acceso</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white shadow-sm align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Rol</th>
                    <th>Nombre del Menú</th>
                    <th>Enlace</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menusPorRol as $rol => $items): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td class="text-center"><?= $nombresRol[$rol] ?></td>
                            <td><?= $item['label'] ?></td>
                            <td><code><?= $item['link'] ?></code></td>
                            <td class="text-center">
                                <!-- Botón Editar -->
                                <button class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditar"
                                    data-rol="<?= $rol ?>"
                                    data-label="<?= htmlspecialchars($item['label']) ?>"
                                    data-link="<?= htmlspecialchars($item['link']) ?>">
                                    Editar
                                </button>

                                <!-- Formulario Eliminar -->
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="rol" value="<?= $rol ?>">
                                    <input type="hidden" name="link" value="<?= htmlspecialchars($item['link']) ?>">
                                    <button type="submit" name="eliminar" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar este acceso?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar acceso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="rol" id="editRol">
                <input type="hidden" name="old_link" id="editOldLink">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="label" class="form-control" id="editLabel" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Enlace</label>
                    <input type="text" name="link" class="form-control" id="editLink" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="editar" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar nuevo acceso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select" required>
                        <?php foreach ($nombresRol as $id => $nombre): ?>
                            <option value="<?= $id ?>"><?= $nombre ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="label" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Enlace</label>
                    <input type="text" name="link" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="agregar" class="btn btn-success">Agregar</button>
            </div>
        </form>
    </div>
</div>

<script>
// Pasar datos al modal de edición
const modalEditar = document.getElementById('modalEditar');
modalEditar.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    document.getElementById('editRol').value = button.getAttribute('data-rol');
    document.getElementById('editOldLink').value = button.getAttribute('data-link');
    document.getElementById('editLabel').value = button.getAttribute('data-label');
    document.getElementById('editLink').value = button.getAttribute('data-link');
});
</script>

</body>
</html>
