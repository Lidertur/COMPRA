<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('./models/proveedor.php');
class proveedorControllers {
    private $proveedor;
    public function __construct() {
        session_start(); // Asegura acceso a $_SESSION
        $this->proveedor = new proveedor;
    }
    public function index() {
        $filtro = $_GET['buscar'] ?? '';
        $proveedores = $this->proveedor->listarr($filtro);
        require_once 'views/proveedor.php';
    }
    public function guardar() {
        $p = new proveedor();
        $p->setit($_POST['it']);
        $p->setnit($_POST['nit']);
        $p->setnombre($_POST['nombre']);
        $p->setdireccion($_POST['direccion']);
        $p->settelefono($_POST['telefono']);
        $p->setcontacto($_POST['contacto']);
        $p->setcorreo($_POST['correo']);
        $p->setproducto($_POST['producto']);
        $p->settipo($_POST['tipo']);
        $idP = $_POST['idP'] ?? null;
        if ($this->proveedor->existeNit($_POST['nit'], $idP)) {
            echo "<script>alert('El NIT ya está registrado.');window.history.back();</script>";
            return;
        }
        if (!empty($idP)) {
            $p->setidP($idP);
            $this->proveedor->actualizar($p);
        } else {
            $this->proveedor->crear($p);
        }
        header("Location: ?c=proveedor");
    }
    public function eliminar() {
        if (isset($_GET['id'])) {
            $this->proveedor->eliminar($_GET['id']);
        }
        header('Location: ?c=proveedor');
    }
}
