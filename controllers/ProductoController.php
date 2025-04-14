<?php
session_start();

// Verifica que haya una sesión iniciada y que el usuario sea tipo 1 (admin o médico por ejemplo)
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: ../index.php");
    exit;
}

// MODELOS
include_once __DIR__ . '/../models/Receta.php';
include_once __DIR__ . '/../models/Producto.php';
include_once __DIR__ . '/../models/UnidadDosis.php';
include_once __DIR__ . '/../models/Estado.php';


// --- GUARDAR NUEVA RECETA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'guardar') {
    $resultado = guardarReceta($_POST);

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Receta guardada correctamente.";
    } else {
        $_SESSION['error'] = "Error al guardar receta: $resultado";
    }

    header("Location: ../controllers/receta_Controller.php");
    exit;
}


// --- ACTUALIZAR RECETA EXISTENTE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'actualizar') {
    $resultado = actualizarReceta($_POST);

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Receta actualizada correctamente.";
    } else {
        $_SESSION['error'] = "Error al actualizar receta: $resultado";
    }

    header("Location: ../controllers/receta_Controller.php");
    exit;
}


// --- CAMBIAR ESTADO (activar / desactivar) ---
if (isset($_GET['accion']) && in_array($_GET['accion'], ['activar', 'desactivar']) && isset($_GET['id'])) {
    $idReceta = $_GET['id'];
    $nuevoEstado = ($_GET['accion'] === 'activar') ? 1 : 2;

    $resultado = cambiarEstadoReceta($idReceta, $nuevoEstado); // Esta función deberías tenerla en Receta.php

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Estado de la receta actualizado correctamente.";
    } else {
        $_SESSION['error'] = "Error al cambiar estado: $resultado";
    }

    header("Location: ../controllers/receta_Controller.php");
    exit;
}


// --- CARGAR FORMULARIO DE CREACIÓN ---
if (isset($_GET['accion']) && $_GET['accion'] === 'crear') {
    $productos = obtenerProductos();
    $unidades = obtenerUnidadesDosis();
    $estados   = obtenerEstados();

    include_once __DIR__ . '/../views/receta/crear.php';
    exit;
}


// --- CARGAR FORMULARIO DE EDICIÓN ---
if (isset($_GET['accion']) && $_GET['accion'] === 'editar' && isset($_GET['id'])) {
    $idReceta = $_GET['id'];
    $receta = obtenerRecetaPorId($idReceta); // Esta función debe retornar receta y su detalle
    $detalle_receta = $receta['detalle'];

    $productos = obtenerProductos();
    $unidades  = obtenerUnidadesDosis();
    $estados   = obtenerEstados();

    include_once __DIR__ . '/../views/receta/editar.php';
    exit;
}


// --- LISTADO POR ESTADO (filtro opcional) ---
$estadoId = isset($_GET['estado']) ? intval($_GET['estado']) : 1;
$recetas = obtenerRecetasPorEstado($estadoId);

include_once __DIR__ . '/../views/receta/listar.php';
