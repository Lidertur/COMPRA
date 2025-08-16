<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('./models/usuario.php');
class navbarControllers {
    private $usuario;
    public function __construct() {
        session_start(); // Asegura acceso a $_SESSION
        $this->usuario = new usuario;
    }

    public function index() {
        if (!isset($_SESSION['rol'])) {
            header('Location: ?c=login'); // Si no hay rol, redirigir
            exit;
        }

        $rol = $_SESSION['rol'];
        require_once 'views/navbar.php'; // rol se pasa automáticamente a la vista
    }
}
