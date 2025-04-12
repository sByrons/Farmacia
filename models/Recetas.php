<?php



include_once __DIR__ . '/../models/Recetas.php';

$productos = obtenerProductos();

// models/Receta.php
function obtenerEstados() {
    $conn = oci_connect('usuario', 'contraseña', 'localhost/XE');
    $sql = "SELECT ESTADO_ID_ESTADO_PK, DESCRIPCION FROM FIDE_ESTADO_TB";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    return $stmt;
}


function obtenerProductos() {
    return [
        ['id' => 1, 'nombre' => 'Paracetamol'],
        ['id' => 2, 'nombre' => 'Ibuprofeno'],
        ['id' => 3, 'nombre' => 'Amoxicilina']
    ];
}






// Crear receta
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

// Editar receta
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

// Eliminar receta (desactivar)
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

// Consultar receta por ID
function obtenerRecetaPorId($idReceta) {
    $conn = conectarOracle("admin");

    $stmt = oci_parse($conn, "
        BEGIN
            FARMACIA.FIDE_RECETA_PKG.RECETA_CONSULTAR_SP(
                :P_ID_RECETA,
                :P_ID_PACIENTE,
                :P_ID_MEDICO,
                :P_FECHA_RECETA
            );
        END;
    ");

    oci_bind_by_name($stmt, ":P_ID_RECETA", $idReceta);
    oci_bind_by_name($stmt, ":P_ID_PACIENTE", $idPaciente, 32);
    oci_bind_by_name($stmt, ":P_ID_MEDICO", $idMedico, 32);
    oci_bind_by_name($stmt, ":P_FECHA_RECETA", $fecha, 32);

    oci_execute($stmt);

    oci_free_statement($stmt);
    oci_close($conn);

    return [
        'ID_RECETA'    => $idReceta,
        'ID_PACIENTE'  => $idPaciente,
        'ID_MEDICO'    => $idMedico,
        'FECHA_RECETA' => $fecha
    ];
}

// Listar todas las recetas
function listarTodasLasRecetas() {
    $conn = conectarOracle("admin");

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.RECETAS_LISTAR_TODAS_SP(:P_CURSOR); END;");
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
?>
