<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: ../index.php");
    exit;
}

include_once __DIR__ . '/../models/Recetas.php'; // Modelo de recetas

$accion = $_POST['accion'] ?? $_GET['accion'] ?? null;
$estadoId = $_GET['estado'] ?? 1; // valor por defecto: Activo

// --- GUARDAR NUEVA RECETA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $accion === 'guardar') {
    $resultado = guardarReceta($_POST);

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Receta guardada correctamente.";
    } else {
        $_SESSION['error'] = "Error al guardar receta: $resultado";
    }
    header("Location: /Farmacia/views/receta/listar.php");
    exit;
}

// --- ACTUALIZAR RECETA EXISTENTE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $accion === 'actualizar') {
    $resultado = actualizarReceta($_POST);

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Receta actualizada correctamente.";
    } else {
        $_SESSION['error'] = "Error al actualizar receta: $resultado";
    }
    header("Location: /Farmacia/views/receta/listar.php");
    exit;
}

// --- ELIMINAR / DESACTIVAR RECETA ---
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $accion === 'desactivar' && isset($_GET['id'])) {
    $resultado = eliminarReceta($_GET['id'], 2); // Estado 2 = Inactivo

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Receta desactivada correctamente.";
    } else {
        $_SESSION['error'] = "Error al desactivar receta: $resultado";
    }
    header("Location: /Farmacia/views/receta/listar.php");
    exit;
}

// --- ACTIVAR RECETA ---
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $accion === 'activar' && isset($_GET['id'])) {
    $resultado = eliminarReceta($_GET['id'], 1); // Estado 1 = Activo

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Receta activada correctamente.";
    } else {
        $_SESSION['error'] = "Error al activar receta: $resultado";
    }
    header("Location: /Farmacia/views/receta/listar.php");
    exit;
}

// --- LISTAR RECETAS ---
if ($accion === 'listar' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $recetas = obtenerRecetasPorEstado($estadoId);
    include_once __DIR__ . '/../views/receta/listar.php';
    exit;
}

// --- Si no coincide con ninguna acción conocida ---
echo "Acción no válida.";
?>

