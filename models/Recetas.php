<?php
include_once __DIR__ . '/../config/database/conexion.php';

function insertarReceta($datos) {
    $conn = conectarOracle("admin");
    $sql = "BEGIN FARMACIA.FIDE_RECETA_PKG.RECETA_INSERTAR_SP(:P_ID_USUARIO, :P_FECHA, :P_ID_ESTADO); END;";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":P_ID_USUARIO", $datos['id_usuario']);
    oci_bind_by_name($stmt, ":P_FECHA", $datos['fecha']);
    oci_bind_by_name($stmt, ":P_ID_ESTADO", $datos['id_estado']);
    return oci_execute($stmt) ? true : oci_error($stmt)['message'];
}

function listarRecetas($estado) {
    $conn = conectarOracle("admin");
    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_RECETA_PKG.RECETA_LISTAR_SP(:P_ESTADO, :P_CURSOR); END;");
    oci_bind_by_name($stmt, ":P_ESTADO", $estado);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt); oci_execute($cursor);
    $recetas = [];
    while ($row = oci_fetch_assoc($cursor)) $recetas[] = $row;
    return $recetas;
}

function eliminarReceta($id) {
    $conn = conectarOracle("admin");
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_RECETA_PKG.RECETA_ELIMINAR_SP(:P_ID_RECETA); END;");
    oci_bind_by_name($stmt, ":P_ID_RECETA", $id);
    return oci_execute($stmt) ? true : oci_error($stmt)['message'];
}
