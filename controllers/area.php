<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('./models/area.php');
class areaControllers {
    private $area;
    public function __construct() {
        session_start(); // Asegura acceso a $_SESSION
        $this->area = new area;
    }
    public function index() {
        $filtro = $_GET['buscar'] ?? '';
        $areas = $this->area->listarr($filtro);
        require_once 'views/area.php';
    }
    public function guardar() {
        $p = new area();
        $p->setnombre($_POST['nombre']);
        $idA = $_POST['idA'] ?? null;
        if ($this->area->existeNombre($_POST['nombre'], $idA)){
            echo "<script>alert('El nombre ya está registrado.');window.history.back();</script>";
        return;
        }
        if (!empty($idA)){
            $p->setidA($idA);
            $this->area->actualizar($p);
        } else{
            $this->area->crear($p);
        }
        header("Location: ?c=area");
    }
    public function eliminar() {
    if (isset($_GET['id'])) {
        $this->area->eliminar($_GET['id']);
    }
    header('Location: ?c=area');
}

}