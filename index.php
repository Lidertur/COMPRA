<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    require_once "bd/Database.php";
    if (!isset($_GET['c'])) {
        require_once 'controllers/login.php';
        $controller = new LoginControllers();
        call_user_func(array($controller,"Index"));
    } else {
        $controller = $_GET ["c"];
        require_once "controllers/$controller.php";
        $controller = ucwords($controller)."Controllers";
        $controller = new $controller;
        $accion =isset($_GET["a"]) ? $_GET["a"] :"Index";
        call_user_func(array($controller, $accion));
    }
?>