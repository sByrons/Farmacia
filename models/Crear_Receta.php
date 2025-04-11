<?php
include_once __DIR__ . '/../config/database/conexion.php';

// 1. Listar recetas por estado
function listarRecetasPorEstado($estadoId) {
    $conn = conectarOracle("admin");

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_RECETA_PKG.RECETA_LISTAR_SP(:P_ESTADO, :P_CURSOR); END;");

    oci_bind_by_name($stmt, ":P_ESTADO", $estadoId);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);

    $recetas = [];
    while ($row = oci_fetch_assoc($cursor)) {
        $recetas[] = $row;
    }

    oci_free_cursor($cursor);
    oci_close($conn);
    return $recetas;
}

// 2. Guardar receta
function guardarReceta($datos) {
    $conn = conectarOracle("admin");

    $idUsuario = $datos['id_usuario'];
    $fecha = $datos['fecha'];
    $idEstado = $datos['id_estado'];

    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_RECETA_PKG.RECETA_INSERTAR_SP(:P_ID_USUARIO, :P_FECHA, :P_ID_ESTADO); END;");

    oci_bind_by_name($stmt, ":P_ID_USUARIO", $idUsuario);
    oci_bind_by_name($stmt, ":P_FECHA", $fecha);
    oci_bind_by_name($stmt, ":P_ID_ESTADO", $idEstado);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    } else {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return "Error al guardar receta: " . $e['message'];
    }
}

// 3. Eliminar receta (marcar como inactiva)
function eliminarReceta($idReceta) {
    $conn = conectarOracle("admin");

    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_RECETA_PKG.RECETA_ELIMINAR_SP(:P_ID_RECETA); END;");
    oci_bind_by_name($stmt, ":P_ID_RECETA", $idReceta);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    } else {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return "Error al eliminar receta: " . $e['message'];
    }
}

// 4. Consultar una receta por ID
function obtenerRecetaPorId($idReceta) {
    $conn = conectarOracle("admin");

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_RECETA_PKG.RECETA_CONSULTAR_SP(:P_ID_RECETA, :P_CURSOR); END;");

    oci_bind_by_name($stmt, ":P_ID_RECETA", $idReceta);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);

    $receta = oci_fetch_assoc($cursor);

    oci_free_cursor($cursor);
    oci_close($conn);
    return $receta;
}

// 5. Actualizar receta (opcional, si tienes el SP en Oracle)
function actualizarReceta($datos) {
    $conn = conectarOracle("admin");

    $idReceta = $datos['id_receta'];
    $idUsuario = $datos['id_usuario'];
    $fecha = $datos['fecha'];
    $idEstado = $datos['id_estado'];

    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_RECETA_PKG.RECETA_ACTUALIZAR_SP(:P_ID_RECETA, :P_ID_USUARIO, :P_FECHA, :P_ID_ESTADO); END;");

    oci_bind_by_name($stmt, ":P_ID_RECETA", $idReceta);
    oci_bind_by_name($stmt, ":P_ID_USUARIO", $idUsuario);
    oci_bind_by_name($stmt, ":P_FECHA", $fecha);
    oci_bind_by_name($stmt, ":P_ID_ESTADO", $idEstado);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    } else {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return "Error al actualizar receta: " . $e['message'];
    }
}

?>
