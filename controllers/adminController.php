<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: ../index.php");
    exit;
}

include_once __DIR__ . '/../models/dashboard.php';

$usuariosActivos    = contarUsuariosActivos();
$productosTotales   = contarProductos();
$facturasHoy        = contarFacturasHoy();
$proveedores        = contarProveedores();


include_once __DIR__ . '/../views/admin/dashboard_admin.php';
