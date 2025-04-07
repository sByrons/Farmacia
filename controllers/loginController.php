<?php
session_start();
include_once __DIR__ . '/../models/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    
    $tipo = validarUsuario($usuario, $contrasena);

    if ($tipo !== false) {
        
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tipo'] = $tipo;

        
        if ($tipo == 1) {
            header('Location: ../controllers/adminController.php');
        } elseif ($tipo == 2) {
            header('Location: ../dashboard_empleado.php');
        } else {
            echo "Tipo de usuario desconocido.";
        }
        exit;
    } else {
        
        header('Location: ../index.php?error=1');
        exit;
    }
} else {
    
    header('Location: ../index.php');
    exit;
}
?>
