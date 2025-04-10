<?php
include_once __DIR__ . '/../config/database/conexion.php';

function insertarDetalleReceta($datos) {
    $conn = conectarOracle("admin");

    $sql = "BEGIN 
        FARMACIA.FIDE_DETALLE_RECETA_PKG.DETALLE_RECETA_INSERTAR_SP(
            :P_ID_RECETA, :P_ID_PRODUCTO, :P_CANTIDAD, 
            :P_ID_UNIDAD, :P_FRECUENCIA_HORAS, :P_DURACION, :P_ID_ESTADO
        ); 
    END;";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":P_ID_RECETA",         $datos['id_receta']);
    oci_bind_by_name($stmt, ":P_ID_PRODUCTO",       $datos['id_producto']);
    oci_bind_by_name($stmt, ":P_CANTIDAD",          $datos['cantidad']);
    oci_bind_by_name($stmt, ":P_ID_UNIDAD",         $datos['id_unidad']);
    oci_bind_by_name($stmt, ":P_FRECUENCIA_HORAS",  $datos['frecuencia']);
    oci_bind_by_name($stmt, ":P_DURACION",          $datos['duracion']);
    oci_bind_by_name($stmt, ":P_ID_ESTADO",         $datos['id_estado']);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    } else {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return "Error al insertar: " . $e['message'];
    }
}
?>
