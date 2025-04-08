<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: ../index.php");
    exit;
}

include_once __DIR__ . '/../models/usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'guardar') {
    $resultado = guardarUsuario($_POST);

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Usuario creado correctamente.";
    } else {
        $_SESSION['error'] = $resultado;
    }

    header("Location: ../controllers/usuarioController.php");
    exit;
}


if (isset($_GET['accion']) && $_GET['accion'] == 'crear') {
    $puestos = obtenerPuestos();
    $tipos = obtenerTiposUsuario();
    $estados = obtenerEstados();
    $provincias = obtenerProvincias();
    $tiposTelefono = obtenerTiposTelefono();



    include_once __DIR__ . '/../views/usuario/crear.php';
    exit;
}

if (isset($_GET['accion']) && in_array($_GET['accion'], ['desactivar', 'activar']) && isset($_GET['id'])) {
    $idUsuario = $_GET['id'];
    $nuevoEstado = ($_GET['accion'] === 'desactivar') ? 2 : 1; // 1 = Activo, 2 = Inactivo

    $resultado = cambiarEstadoUsuario($idUsuario, $nuevoEstado);

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Estado del usuario actualizado correctamente.";
    } else {
        $_SESSION['error'] = $resultado;
    }

    header("Location: ../controllers/usuarioController.php");
    exit;
}

if (isset($_GET['accion']) && $_GET['accion'] === 'editar' && isset($_GET['id'])) {
    $idUsuario = $_GET['id'];

    $usuario = obtenerUsuarioPorId($idUsuario);
    $puestos = obtenerPuestos();
    $tipos = obtenerTiposUsuario();
    $estados = obtenerEstados();

    include_once __DIR__ . '/../views/usuario/editar.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
    $resultado = actualizarUsuario($_POST);

    if ($resultado === true) {
        $_SESSION['mensaje'] = "Usuario actualizado correctamente.";
    } else {
        $_SESSION['error'] = $resultado;
    }

    header("Location: ../controllers/usuarioController.php");
    exit;
}


$estadoId = isset($_GET['estado']) ? intval($_GET['estado']) : 1;
$usuarios = listarUsuariosPorEstado($estadoId);
include_once __DIR__ . '/../views/usuario/listar.php';

