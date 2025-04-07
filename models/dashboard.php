<?php
include_once __DIR__ . '/../config/database/conexion.php';

function contarUsuariosActivos() {
    $conn = conectarOracle("admin");

    $stmt = oci_parse($conn, "BEGIN :resultado := FARMACIA.FIDE_DASHBOARD_PKG.CONTAR_USUARIOS_ACTIVOS_FN; END;");
    oci_bind_by_name($stmt, ":resultado", $resultado, 10);
    oci_execute($stmt);

    oci_free_statement($stmt);
    oci_close($conn);

    return $resultado;
}

function contarProductos() {
    $conn = conectarOracle("admin");

    $stmt = oci_parse($conn, "BEGIN :resultado := FARMACIA.FIDE_DASHBOARD_PKG.CONTAR_PRODUCTOS_FN; END;");
    oci_bind_by_name($stmt, ":resultado", $resultado, 10);
    oci_execute($stmt);

    oci_free_statement($stmt);
    oci_close($conn);

    return $resultado;
}

function contarFacturasHoy() {
    $conn = conectarOracle("admin");

    $stmt = oci_parse($conn, "BEGIN :resultado := FARMACIA.FIDE_DASHBOARD_PKG.CONTAR_FACTURAS_HOY_FN; END;");
    oci_bind_by_name($stmt, ":resultado", $resultado, 10);
    oci_execute($stmt);

    oci_free_statement($stmt);
    oci_close($conn);

    return $resultado;
}

function contarProveedores() {
    $conn = conectarOracle("admin");

    $stmt = oci_parse($conn, "BEGIN :resultado := FARMACIA.FIDE_DASHBOARD_PKG.CONTAR_PROVEEDORES_FN; END;");
    oci_bind_by_name($stmt, ":resultado", $resultado, 10);
    oci_execute($stmt);

    oci_free_statement($stmt);
    oci_close($conn);

    return $resultado;
}
