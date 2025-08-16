<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('./models/usuario.php');
class usuarioControllers {
    private $usuario;
    public function __construct() {
        session_start(); // Asegura acceso a $_SESSION
        $this->usuario = new usuario;
    }
    public function index() {
        $filtro = $_GET['buscar'] ?? '';
        $usuarios = $this->usuario->listarr($filtro);
        require_once 'views/usuario.php';
    }
    public function guardar() {
        $p = new usuario();
        $p->setrol($_POST['rol']);
        $p->setnombre($_POST['nombre']);
        $p->settelefono($_POST['telefono']);
        $p->setcorreo($_POST['correo']);
        $p->setidA($_POST['idA']);
        $idU = $_POST['idU'] ?? null;
        if ($this->usuario->existenombre($_POST['nit'], $idU)) {
            echo "<script>alert('El nombre ya está registrado.');window.history.back();</script>";
            return;
        }
        if (!empty($idU)) {
            $p->setidU($idU);
            $this->usuario->actualizar($p);
        } else {
            $this->usuario->crear($p);
        }
        header("Location: ?c=usuario");
    }
    public function eliminar() {
        if (isset($_GET['id'])) {
            $this->usuario->eliminar($_GET['id']);
        }
        header('Location: ?c=usuario');
    }
}
