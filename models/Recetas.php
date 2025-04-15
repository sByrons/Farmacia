<?php

function conectarOracle($usuario) {
    $conn = oci_connect($usuario, 'contraseña', 'localhost/XE');
    if (!$conn) {
        $error = oci_error();
        die("Conexión fallida: " . $error['message']);
    }
    return $conn;
}

// Obtener Estados (para listar en el formulario)
function obtenerEstados() {
    $conn = conectarOracle("admin");
    $sql = "SELECT ESTADO_ID_ESTADO_PK, DESCRIPCION FROM FIDE_ESTADO_TB";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    return $stmt;
}

// Guardar Receta
function guardarReceta($datos) {
    $conn = conectarOracle("admin");

    $idPaciente  = $datos['id_paciente'];
    $idMedico    = $datos['id_medico'];
    $fecha       = $datos['fecha'];
    $estadoId    = $datos['estado_id'];

    $sql = "
    BEGIN
        FARMACIA.FIDE_RECETA_PKG.RECETA_INSERTAR_SP(
            :P_ID_PACIENTE,
            :P_ID_MEDICO,
            :P_FECHA_RECETA,
            :P_ESTADO
        );
    END;
    ";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":P_ID_PACIENTE",    $idPaciente);
    oci_bind_by_name($stmt, ":P_ID_MEDICO",      $idMedico);
    oci_bind_by_name($stmt, ":P_FECHA_RECETA",   $fecha);
    oci_bind_by_name($stmt, ":P_ESTADO",         $estadoId);

    $resultado = oci_execute($stmt);

    if (!$resultado) {
        $error = oci_error($stmt);
        return "Error al guardar receta: " . $error['message'];
    }

    oci_free_statement($stmt);
    oci_close($conn);
    return true;
}

// Actualizar Receta
function actualizarReceta($datos) {
    $conn = conectarOracle("admin");

    $idReceta    = $datos['id_receta'];
    $idPaciente  = $datos['id_paciente'];
    $idMedico    = $datos['id_medico'];
    $fecha       = $datos['fecha'];
    $estadoId    = $datos['estado_id'];

    $sql = "
    BEGIN
        FARMACIA.FIDE_RECETA_PKG.RECETA_ACTUALIZAR_SP(
            :P_ID_RECETA,
            :P_ID_PACIENTE,
            :P_ID_MEDICO,
            :P_FECHA_RECETA,
            :P_ESTADO
        );
    END;
    ";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":P_ID_RECETA",     $idReceta);
    oci_bind_by_name($stmt, ":P_ID_PACIENTE",   $idPaciente);
    oci_bind_by_name($stmt, ":P_ID_MEDICO",     $idMedico);
    oci_bind_by_name($stmt, ":P_FECHA_RECETA",  $fecha);
    oci_bind_by_name($stmt, ":P_ESTADO",        $estadoId);

    $resultado = oci_execute($stmt);

    if (!$resultado) {
        $error = oci_error($stmt);
        return "Error al actualizar receta: " . $error['message'];
    }

    oci_free_statement($stmt);
    oci_close($conn);
    return true;
}

// Eliminar Receta (Desactivarla)
function eliminarReceta($idReceta, $estadoInactivo) {
    $conn = conectarOracle("admin");

    $sql = "
    BEGIN
        FARMACIA.FIDE_RECETA_PKG.RECETA_ELIMINAR_SP(
            :P_ID_RECETA,
            :P_ESTADO_INACTIVO
        );
    END;
    ";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":P_ID_RECETA",       $idReceta);
    oci_bind_by_name($stmt, ":P_ESTADO_INACTIVO", $estadoInactivo);

    $resultado = oci_execute($stmt);

    if (!$resultado) {
        $error = oci_error($stmt);
        return "Error al eliminar receta: " . $error['message'];
    }

    oci_free_statement($stmt);
    oci_close($conn);
    return true;
}

// Obtener Recetas por Estado
function obtenerRecetasPorEstado($estadoId) {
    $conn = conectarOracle("admin");

    $sql = "SELECT r.RECETA_ID_RECETA_PK, r.FECHA, u.NOMBRE AS USUARIO, e.DESCRIPCION AS ESTADO
            FROM FIDE_RECETA_TB r
            JOIN FIDE_USUARIOS_TB u ON r.ID_USUARIO = u.USUARIOS_ID_USUARIO_PK
            JOIN FIDE_ESTADO_TB e ON r.ID_ESTADO = e.ESTADO_ID_ESTADO_PK
            WHERE r.ID_ESTADO = :estadoId";

    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':estadoId', $estadoId);
    oci_execute($stid);

    $recetas = [];
    while ($row = oci_fetch_assoc($stid)) {
        $recetas[] = $row;
    }

    oci_free_statement($stid);
    oci_close($conn);

    return $recetas;
}

?>
