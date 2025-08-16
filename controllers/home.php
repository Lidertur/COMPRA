<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include('./models/usuario.php');

class homeControllers {
    private $usuario;

    public function __construct() {
        $this->usuario = new usuario;
    }

    public function index() {
        require_once 'views/home.php';
    }
}