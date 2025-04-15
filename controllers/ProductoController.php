<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: ../index.php");
    exit;
}

include_once __DIR__ . '/../models/producto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    if ($_POST['accion'] === 'guardar') {
        // Guardar producto
        $resultado = guardarProducto($_POST);

        if ($resultado === true) {
            $_SESSION['mensaje'] = "Producto creado correctamente.";
        } else {
            $_SESSION['error'] = $resultado;
        }

        header("Location: ../controllers/productoController.php");
        exit;
    }

    if ($_POST['accion'] === 'actualizar') {
        // Actualizar producto
        $resultado = actualizarProducto($_POST);

        if ($resultado === true) {
            $_SESSION['mensaje'] = "Producto actualizado correctamente.";
        } else {
            $_SESSION['error'] = $resultado;
        }

        header("Location: ../controllers/productoController.php");
        exit;
    }
}

// Manejo de acciones para crear, editar, eliminar, activar y desactivar productos
if (isset($_GET['accion']) && $_GET['accion'] === 'crear') {
    $estados = obtenerEstados();  // Suponiendo que existe una función para obtener los estados
    include_once __DIR__ . '/../views/producto/crear.php';
    exit;
}

if (isset($_GET['accion']) && in_array($_GET['accion'], ['eliminar', 'activar']) && isset($_GET['id'])) {
    $idProducto = $_GET['id'];
    $nuevoEstado = ($_GET['accion'] === 'eliminar') ? 2 : 1; // 1 = Activo, 2 = Inactivo

    $resultado = eliminarProducto($idProducto, $nuevoEstado);

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Estado del producto actualizado correctamente.";
    } else {
        $_SESSION['error'] = $resultado;
    }

    header("Location: ../controllers/productoController.php");
    exit;
}
if (isset($_GET['accion']) && $_GET['accion'] === 'desactivar' && isset($_GET['id'])) {
    $idProducto = $_GET['id'];
    $nuevoEstado = 2; // Estado 2 = Inactivo (según tu lógica)

    $resultado = eliminarProducto($idProducto, $nuevoEstado); // Asumiendo que "eliminarProducto" maneja la actualización de estado

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Producto desactivado correctamente.";
    } else {
        $_SESSION['error'] = $resultado;
    }

    header("Location: ../controllers/productoController.php");
    exit;
}


 if (isset($_GET['accion']) && $_GET['accion'] === 'editar' && isset($_GET['id'])) {
    $idProducto = $_GET['id'];
    $producto = obtenerProductoPorId($idProducto);
    $estados = obtenerEstados();  
    include_once __DIR__ . '/../views/producto/editar.php';
    exit;
}




// Mostrar lista de productos
$estadoId = isset($_GET['estado']) ? intval($_GET['estado']) : 1;
$productos = listarProductosPorEstado($estadoId);
include_once __DIR__ . '/../views/producto/listar.php';

