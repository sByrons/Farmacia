<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../models/Receta.php'; // Modelo principal
header('Location: /Farmacia/controllers/receta_Controller.php?accion=crear');

$accion = $_POST['accion'] ?? $_GET['accion'] ?? null;

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

// --- ELIMINAR RECETA ---
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $accion === 'eliminar' && isset($_GET['id'])) {
    $resultado = eliminarReceta($_GET['id']);

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Receta eliminada correctamente.";
    } else {
        $_SESSION['error'] = "Error al eliminar receta: $resultado";
    }
    header("Location: /Farmacia/views/receta/listar.php");
    exit;
}

// --- ACCESO DIRECTO: redireccionar a listado ---
// --- ACCESO DIRECTO: redireccionar a listado ---
if (file_exists(__DIR__ . '/../views/receta/listar.php')) {
    header("Location: /Farmacia/views/receta/listar.php");
    exit;
} else {
    echo "Archivo listar.php no encontrado en /views/receta/";
}


// RecetaController.php

include_once realpath(__DIR__ . '/../models/Receta.php');
include_once realpath(__DIR__ . '/../models/Estado.php');

// Obtener el filtro de estado (si existe en la URL)
$estadoId = isset($_GET['estado']) ? $_GET['estado'] : 1; // Por defecto, filtro por "activo" (1)

// Obtener las recetas con el estado filtrado
$recetas = obtenerRecetasPorEstado($estadoId); // Función que obtiene las recetas filtradas por estado

// Pasar las recetas y el estado a la vista
include_once realpath(__DIR__ . '/../views/receta/listar.php');

