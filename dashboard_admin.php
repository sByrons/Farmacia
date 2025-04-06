<?php
session_start();

// Verifica si está logueado y si es tipo admin
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Bienvenido, administrador <?php echo $_SESSION['usuario']; ?>!</h1>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
