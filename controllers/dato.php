<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include('./models/dato.php');

    class datoControllers {
        private $dato;
        public function __construct() {
            session_start(); // Asegura acceso a $_SESSION
            $this->dato = new dato;
        }
        public function index() {
            $filtro = $_GET['buscar'] ?? '';
            $datos = $this->dato->listarr($filtro);
            require_once 'views/dato.php';
        }
        public function guardar() {
            $d = new dato();
            $idU = $_SESSION['idU'] ?? null;
            $idM = $_POST['idM'] ?? null;
            $idP = $_POST['idP'] ?? null;
            $fecha = date('Y-m-d');
            $idD = $_POST['idD'] ?? null;
            // Si se está editando, usamos los valores recibidos
            if (!empty($idD)) {
                $d->setidD($idD);
                $d->setit($_POST['it']);
                $d->setoc($_POST['oc']);
                $d->setitoc($_POST['itoc']);
                $d->setfecha($_POST['fecha']);
            } else {
                // Si es un nuevo dato, se determina si es nueva OC o ítem adicional
                if (!empty($_POST['oc'])) {
                    $oc = $_POST['oc'];
                    $it = $this->dato->generarSiguienteIT($oc);
                } else {
                    $oc = $this->dato->generarNuevaOC();
                    $it = 1;
                }
                $itoc = $oc . str_pad($it, 2, "0", STR_PAD_LEFT);
                $d->setoc($oc);
                $d->setit($it);
                $d->setitoc($itoc);
                $d->setfecha($fecha);
            }
            // Validación de duplicado IT solo si es nuevo
            if (!$idD && $this->dato->existeIt($d->getit(), null)) {
                echo "<script>alert('El código IT ya está registrado.');window.history.back();</script>";
                return;
            }
            // Campos comunes
            $d->settipo($_POST['tipo'] ?? null);
            $d->setdescripcion($_POST['descripcion'] ?? null);
            $d->setcantidad($_POST['cantidad']);
            $d->setvalor($_POST['valor']);
            $d->setdescuento($_POST['descuento']);
            $d->settotal($_POST['total']);
            $d->setabono($_POST['abono']);
            $d->setafecha($_POST['afecha']);
            $d->setapor($_POST['apor']);
            $d->setobservacion($_POST['observacion']);
            $d->setnelectronica($_POST['nelectronica']);
            $d->setidU($idU);
            $d->setidP($idP);
            $d->setidM($idM);

            // Guardar o actualizar
            if (!empty($idD)) {
                $this->dato->actualizar($d);
            } else {
                $this->dato->crear($d);
            }
            header("Location: ?c=dato");
        }
        public function eliminar() {
            if (isset($_GET['id'])) {
                $this->dato->eliminar($_GET['id']);
            }
            header('Location: ?c=dato');
        }
        public function generar() {
            $tipo = $_GET['tipo'] ?? null;
            if ($tipo === 'oc') {
                $oc = $this->dato->generarNuevaOC();
                $it = 1;
            } elseif ($tipo === 'it') {
                $oc = $this->dato->obtenerUltimaOC();
                $it = $this->dato->generarSiguienteIT($oc);
            } else {
                echo json_encode(["error" => "Tipo no válido"]);
                return;
            }
            $itoc = $oc . str_pad($it, 2, "0", STR_PAD_LEFT);
            $fecha = date('Y-m-d');
            header('Content-Type: application/json');
            echo json_encode([
                "oc" => $oc,
                "it" => $it,
                "itoc" => $itoc,
                "fecha" => $fecha
            ]);
        }

    }
