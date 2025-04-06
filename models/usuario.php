<?php
include_once __DIR__ . '/../config/database/conexion.php';

function listarUsuariosPorEstado($estadoId) {
    $conn = conectarOracle("admin");

    if (!$conn) {
        $e = oci_error();
        die(" Error: " . $e['message']);
    }

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_USUARIOS_PKG.USUARIOS_LISTAR_SP(:P_ESTADO, :P_CURSOR); END;");
    oci_bind_by_name($stmt, ":P_ESTADO", $estadoId);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);

    return $cursor;
}

?>