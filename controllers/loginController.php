<?php
session_start();
include_once __DIR__ . '/../models/auth.php';

// Verifica que se haya enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // Llama al modelo para validar
    $tipo = validarUsuario($usuario, $contrasena);

    if ($tipo !== false) {
        // Guarda datos en sesión
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tipo'] = $tipo;

        // Redirige según el tipo
        if ($tipo == 1) {
            header('Location: ../dashboard_admin.php');
        } elseif ($tipo == 2) {
            header('Location: ../dashboard_empleado.php');
        } else {
            echo "Tipo de usuario desconocido.";
        }
        exit;
    } else {
        // Usuario inválido
        header('Location: ../index.php?error=1');
        exit;
    }
} else {
    // Acceso directo al controlador sin POST
    header('Location: ../index.php');
    exit;
}
?>
