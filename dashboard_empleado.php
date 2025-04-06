<?php
session_start();

// Verifica si está logueado y si es tipo empleado
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 2) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Empleado</title>
</head>
<body>
    <h1>Bienvenido, empleado <?php echo $_SESSION['usuario']; ?>!</h1>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
