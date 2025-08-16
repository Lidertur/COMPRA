<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include('./models/usuario.php');

class LoginControllers {
    private $usuario;

    public function __construct() {
        $this->usuario = new usuario;
    }

    public function index() {
        require_once 'views/login.php';
    }

    public function validar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $contraseña = $_POST['contraseña'] ?? '';

            $usuario = $this->usuario->validarLogin($nombre, $contraseña);

            if ($usuario) {
                $_SESSION['idU'] = $usuario['idU'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];

                // Redirigir según el rol
                switch ($usuario['rol']) {
                    case 1:
                        header('Location: ?c=home'); // Admin
                        break;
                    case 2:
                        header('Location: ?c=home'); // Por ejemplo, Comprador
                        break;
                    case 3:
                        header('Location: ?c=home'); // Otro tipo de usuario
                        break;
                    default:
                        header('Location: ?c=home'); // Rol desconocido
                        break;
                }
            } else {
                // Error de credenciales
                $error = "Nombre o contraseña incorrectos.";
                require_once 'views/login.php';
            }
        }
    }
    public function registrar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'] ?? '';
        $contraseña = $_POST['contraseña'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $correo = $_POST['correo'] ?? '';

        // Validar si ya existe
        $usuarios = $this->usuario->listar();
        foreach ($usuarios as $u) {
            if ($u['nombre'] == $nombre) {
                $registro_error = "Ese nombre ya está registrado.";
                require_once 'views/login.php';
                return;
            }
        }

        // Insertar nuevo usuario con rol por defecto (ej: 2)
       $this->usuario->crear(2, $nombre, $contraseña, $telefono, $correo);


        header('Location: ?c=login');
    }
}


    public function logout() {
        session_start();
        session_destroy();
        header('Location: ?c=login');
    }
}
