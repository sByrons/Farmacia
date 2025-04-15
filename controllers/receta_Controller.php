<?php
session_start();

// Validación de sesión
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: ../index.php");
    exit;
}

// Includes de modelos
include_once __DIR__ . '/../models/Receta.php';
include_once __DIR__ . '/../models/Estado.php';
include_once __DIR__ . '/../models/Producto.php';
include_once __DIR__ . '/../models/UnidadDosis.php';

// ACCIONES POST: GUARDAR o ACTUALIZAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {

    if ($_POST['accion'] === 'guardar') {
        $resultado = guardarReceta($_POST);

        if ($resultado === true) {
            $_SESSION['mensaje'] = "Receta creada correctamente.";
        } else {
            $_SESSION['error'] = $resultado;
        }

        header("Location: ../controllers/receta_Controller.php");
        exit;
    }

    if ($_POST['accion'] === 'actualizar') {
        $resultado = actualizarReceta($_POST);

        if ($resultado === true) {
            $_SESSION['mensaje'] = "Receta actualizada correctamente.";
        } else {
            $_SESSION['error'] = $resultado;
        }

        header("Location: ../controllers/receta_Controller.php");
        exit;
    }
}

// ACCIONES GET

// Crear receta
if (isset($_GET['accion']) && $_GET['accion'] === 'crear') {
    $estados = obtenerEstados();
    $productos = obtenerProductos();
    $unidades = obtenerUnidadesDosis();
    include_once __DIR__ . '/../views/receta/crear.php';
    exit;
}

// Editar receta
if (isset($_GET['accion']) && $_GET['accion'] === 'editar' && isset($_GET['id'])) {
    $idReceta = $_GET['id'];
    $receta = obtenerRecetaPorId($idReceta);
    $productos = obtenerProductos();
    $estados = obtenerEstados();
    $unidades = obtenerUnidadesDosis();

    // Asegúrate de tener esta función que carga los datos del detalle
    $detalle_receta = obtenerDetalleReceta($idReceta);

    include_once __DIR__ . '/../views/receta/editar.php';
    exit;
}

// Activar/Inactivar receta
if (isset($_GET['accion']) && in_array($_GET['accion'], ['activar', 'desactivar']) && isset($_GET['id'])) {
    $idReceta = $_GET['id'];
    $nuevoEstado = ($_GET['accion'] === 'desactivar') ? 2 : 1; // 1 = Activo, 2 = Inactivo

    $resultado = cambiarEstadoReceta($idReceta, $nuevoEstado);

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Estado de la receta actualizado correctamente.";
    } else {
        $_SESSION['error'] = $resultado;
    }

    header("Location: ../controllers/receta_Controller.php");
    exit;
}

// Mostrar listado de recetas
$estadoId = isset($_GET['estado']) ? intval($_GET['estado']) : 1;
$recetas = obtenerRecetasPorEstado($estadoId);
include_once __DIR__ . '/../views/receta/listar.php';
