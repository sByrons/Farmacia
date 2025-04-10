<?php
session_start();
include_once __DIR__ . '/../models/Recetas.php';

if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $resultado = eliminarReceta($_GET['id']);
    $_SESSION[$resultado === true ? 'mensaje' : 'error'] = $resultado === true ? "Receta eliminada correctamente." : $resultado;
    header("Location: listar_recetas.php");
    exit;
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'guardar_receta') {
        include_once realpath(__DIR__ . '/../models/Recetas.php');

        // Asegúrate de que la función guardarReceta exista en tu modelo
        guardarReceta($_POST);

        // Redirigir a la vista principal de recetas
        header('Location: /Farmacia/views/receta.php');
        exit();
    } else {
        echo "Acción no válida.";
    }
} else {
    // Redirige a la vista de creación de recetas si se accede por GET
    header('Location: /Farmacia/views/receta.php');
    exit();
}
