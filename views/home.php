<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    // Verifica si el usuario ha iniciado sesión
    if (!isset($_SESSION['rol'])) {
        header('Location: ?c=login');
        exit;
    }

    $rol = $_SESSION['rol']; // Necesario para mostrar menús según el rol
    include 'views/navbar.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <div class="container mt-4">
    <h7>Bienvenido, <?= $_SESSION['nombre'] ?? 'Usuario' ?> </h7>
    <p>Esta es la página de inicio.</p>
</div>

</body>
</html>