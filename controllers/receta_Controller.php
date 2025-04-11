<?php
session_start();
include_once __DIR__ . '/../models/receta.php';

if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $resultado = eliminarReceta($_GET['id']);
    $_SESSION[$resultado === true ? 'mensaje' : 'error'] = $resultado === true ? "Receta eliminada correctamente." : $resultado;
    header("Location: listar_recetas.php");
    exit;
}
