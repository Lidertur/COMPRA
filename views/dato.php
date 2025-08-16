<?php 
    if (!isset($_SESSION)) session_start();
    if (!isset($_SESSION['rol'])) {
        header('Location: ?c=login');
        exit;
    }
    $rol = $_SESSION['rol'];
    include 'views/navbar.php'; 
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Datos</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-light">
        <div class="container py-5">
            <h2 class="mb-4 text-center">Gestión de Datos</h2>
            <form method="GET" class="mb-4 row">
                <input type="hidden" name="c" value="dato">
                <div class="col-md-10">
                    <input type="text" name="buscar" value="<?= $_GET['buscar'] ?? '' ?>" class="form-control" placeholder="Buscar por descripción, tipo, fecha, etc.">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Buscar</button>
                </div>
            </form>
            <input type="hidden" name="tipo" id="tipo">
            <?php if ($rol == 1 || $rol == 2): ?>
                <div class="d-flex justify-content-end gap-2 mb-3">
                    <button id="btnOC" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modaldato">+ Nueva OC</button>
                    <button id="btnIT" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaldato">+ Nuevo ítem en OC actual</button>
                    <?php if ($_SESSION['rol'] == 1): ?>
                        <button id="btnDato" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modaldato">Agregar dato</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white shadow-sm small">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th><th>IT</th><th>OC</th><th>ITOC</th><th>Fecha</th><th>Tipo</th><th>Descripción</th><th>Cant.</th><th>Valor</th><th>Desc.</th>
                            <th>Total</th><th>Abono</th><th>F. Abono</th><th>Por</th><th>Obs.</th><th>N° Elec.</th><th>Usuario</th><th>Proveedor</th><th>Movil</th><th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datos as $d): ?>
                            <tr>
                                <td><?= $d['idD'] ?></td>
                                <td><?= $d['it'] ?></td>
                                <td><?= $d['oc'] ?></td>
                                <td><?= $d['itoc'] ?></td>
                                <td><?= $d['fecha'] ?></td>
                                <td><?= $d['tipo'] ?></td>
                                <td><?= $d['descripcion'] ?></td>
                                <td><?= $d['cantidad'] ?></td>
                                <td><?= $d['valor'] ?></td>
                                <td><?= $d['descuento'] ?></td>
                                <td><?= $d['total'] ?></td>
                                <td><?= $d['abono'] ?></td>
                                <td><?= $d['afecha'] ?></td>
                                <td><?= $d['apor'] ?></td>
                                <td><?= $d['observacion'] ?></td>
                                <td><?= $d['nelectronica'] ?></td>
                                <td><?= $d['usuario_nombre'] ?? $d['idU'] ?></td>
                                <td><?= $d['proveedor_nombre'] ?? $d['idP'] ?></td>
                                <td><?= $d['movil_placa'] ?? $d['idM'] ?></td>
                                <td class="text-center">
                                    <?php if ($rol == 1): ?>
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                                data-bs-target="#modaldato"
                                                onclick='cargardato(<?= json_encode($d) ?>)'>Editar</button>
                                        <a href="?c=dato&a=eliminar&id=<?= $d['idD'] ?>" 
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar este dato?')">Eliminar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="modaldato" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form method="POST" action="?c=dato&a=guardar" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Formulario Dato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <input type="hidden" name="idD" id="idD">
                        <div class="col-md-4">
                            <label class="form-label">IT</label>
                            <input type="text" name="it" id="it" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">OC</label>
                            <input type="text" name="oc" id="oc" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">ITOC</label>
                            <input type="text" name="itoc" id="itoc" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tipo</label>
                            <input type="text" name="tipo" id="tipo" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Valor</label>
                            <input type="number" name="valor" id="valor" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Descuento</label>
                            <input type="number" name="descuento" id="descuento" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Total</label>
                            <input type="number" name="total" id="total" class="form-control" readonly>
                        </div>
                        <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const cantidadInput = document.getElementById("cantidad");
                            const valorInput = document.getElementById("valor");
                            const descuentoInput = document.getElementById("descuento");
                            const totalInput = document.getElementById("total");

                            function calcularTotal() {
                                let cantidad = parseFloat(cantidadInput.value) || 0;
                                let valor = parseFloat(valorInput.value) || 0;
                                let descuento = parseFloat(descuentoInput.value) || 0;

                                let total = (cantidad * valor) - descuento;

                                totalInput.value = total >= 0 ? total : 0;
                            }

                            cantidadInput.addEventListener("input", calcularTotal);
                            valorInput.addEventListener("input", calcularTotal);
                            descuentoInput.addEventListener("input", calcularTotal);
                        });
                        </script>
                        <div class="col-md-4">
                            <label class="form-label">Abono</label>
                            <input type="numer" name="abono" id="abono" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> >
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha de Abono</label>
                            <input type="date" name="afecha" id="afecha" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> >
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Por</label>
                            <input type="text" name="apor" id="apor" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> >
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Observación</label>
                            <input type="text" name="observacion" id="observacion" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> >
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">N° Electrónica</label>
                            <input type="numer" name="nelectronica" id="nelectronica" class="form-control" <?= $rol != 1 ? 'readonly' : '' ?> >
                        </div>
                        <!-- Selects dinámicos -->
                        <div class="col-md-4">
                            <label class="form-label">Usuario</label>
                            <select name="idU" id="idU" class="form-select" <?= ($rol != 1 && $rol != 2) ? 'disabled' : '' ?> required>
                                <option value="">Seleccione</option>
                                <?php foreach ($usuarios as $u): ?>
                                    <option value="<?= $u['idU'] ?>"><?= $u['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Proveedor</label>
                            <select name="idP" id="idP" class="form-select" <?= $rol != 1 ? 'disabled' : '' ?> required>
                                <option value="">Seleccione</option>
                                <?php foreach ($proveedores as $p): ?>
                                    <option value="<?= $p['idP'] ?>"><?= $p['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Móvil</label>
                            <select name="idM" id="idM" class="form-select" <?= $rol != 1 ? 'disabled' : '' ?> required>
                                <option value="">Seleccione</option>
                                <?php foreach ($moviles as $m): ?>
                                    <option value="<?= $m['idM'] ?>"><?= $m['placa'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php if ($rol == 1): ?>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.getElementById('btnOC').addEventListener('click', () => {
                fetch('?c=dato&a=generar&tipo=oc')
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('tipo').value = 'oc';
                        document.getElementById('oc').value = data.oc;
                        document.getElementById('it').value = data.it;
                        document.getElementById('itoc').value = data.itoc;
                        document.getElementById('fecha').value = data.fecha;
                    });
            });
            document.getElementById('btnIT').addEventListener('click', () => {
                fetch('?c=dato&a=generar&tipo=it')
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('tipo').value = 'it';
                        document.getElementById('oc').value = data.oc;
                        document.getElementById('it').value = data.it;
                        document.getElementById('itoc').value = data.itoc;
                        document.getElementById('fecha').value = data.fecha;
                    });
            });
            document.getElementById('btnDato').addEventListener('click', () => {
                document.getElementById('tipo').value = 'dato';
                const campos = ['it','oc','itoc','fecha'];
                campos.forEach(c => document.getElementById(c).value = '');
            });
        </script>
        <script>    
            document.getElementById('btnOC').addEventListener('click', function () {
                document.getElementById('tipo').value = 'oc';
            });
            document.getElementById('btnIT').addEventListener('click', function () {
                document.getElementById('tipo').value = 'it';
            });
            document.getElementById('btnDato').addEventListener('click', function () {
                document.getElementById('tipo').value = 'dato';
            });
        </script>
        <script>
            function cargardato(d) {
                document.getElementById('idD').value = d.idD;
                    const campos = ['it','oc','itoc','fecha','tipo','descripcion','cantidad','valor','descuento','total',
                                    'abono','afecha','apor','observacion','nelectronica'];
                    campos.forEach(c => {
                        document.getElementById(c).value = d[c] ?? '';
                    });
                document.getElementById('idU').value = d.idU;
                document.getElementById('idP').value = d.idP;
                document.getElementById('idM').value = d.idM;
            }
        </script>
        <script>
            document.querySelector('[data-bs-target="#modaldato"]').addEventListener('click', () => {
                const campos = ['idD','it','oc','itoc','fecha','tipo','descripcion','cantidad','valor','descuento','total',
                                'abono','afecha','apor','observacion','nelectronica','idU','idP','idM'];
                campos.forEach(c => {
                    const el = document.getElementById(c);
                    if (el) el.value = '';
                });
            });
        </script>
    </body>
</html>