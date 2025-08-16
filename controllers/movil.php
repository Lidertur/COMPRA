<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('./models/movil.php');
class movilControllers {
    private $movil;
    public function __construct() {
        session_start(); // Asegura acceso a $_SESSION
        $this->movil = new movil;
    }
    public function index() {
        $filtro = $_GET['buscar'] ?? '';
        $moviles = $this->movil->listarr($filtro);
        require_once 'views/movil.php';
    }
    public function guardar() {
        $p = new movil();
        $p->setnmovil($_POST['nmovil']);
        $p->setplaca($_POST['placa']);
        $idM = $_POST['idM'] ?? null;
        if ($this->movil->existePlaca($_POST['placa'], $idM)){
            echo "<script>alert('La placa ya está registrado.');window.history.back();</script>";
        return;
        }
        if (!empty($idM)){
            $p->setidM($idM);
            $this->movil->actualizar($p);
        } else{
            $this->movil->crear($p);
        }
        header("Location: ?c=movil");
    }
    public function eliminar() {
        if (isset($_GET['id'])) {
            $this->movil->eliminar($_GET['id']);
        }
        header('Location: ?c=movil');
    }
}