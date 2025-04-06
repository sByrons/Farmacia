<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: ../index.php");
    exit;
}

include_once __DIR__ . '/../models/usuario.php';

$estadoId = isset($_GET['estado']) ? intval($_GET['estado']) : 1;

$usuarios = listarUsuariosPorEstado($estadoId);

include_once __DIR__ . '/../views/usuario/listar.php';

