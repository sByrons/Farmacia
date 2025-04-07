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

function obtenerPuestos() {
    $conn = conectarOracle("admin");

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_CATALOGOS_PKG.LISTAR_PUESTOS_SP(:P_CURSOR); END;");
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);

    return $cursor;
}

function obtenerTiposUsuario() {
    $conn = conectarOracle("admin");

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_CATALOGOS_PKG.LISTAR_TIPOS_USUARIO_SP(:P_CURSOR); END;");
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);

    return $cursor;
}

function obtenerEstados() {
    $conn = conectarOracle("admin");

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_CATALOGOS_PKG.LISTAR_ESTADOS_SP(:P_CURSOR); END;");
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);

    return $cursor;
}

function guardarUsuario($datos) {
    $conn = conectarOracle("admin");

    $nombre      = $datos['nombre'];
    $apellido    = $datos['apellido'];
    $email       = $datos['email'];
    $id_tipo     = $datos['id_tipo'];
    $id_estado   = $datos['id_estado'];

    $usuario     = ($id_tipo == 1 || $id_tipo == 2) ? $datos['usuario'] : null;
    $contrasena  = ($id_tipo == 1 || $id_tipo == 2) ? $datos['contrasena'] : null;
    $id_puesto   = ($id_tipo == 1 || $id_tipo == 2) ? $datos['id_puesto'] : null;

    $sql = "BEGIN FARMACIA.FIDE_USUARIOS_PKG.USUARIOS_INSERTAR_SP(
        :P_NOMBRE, :P_APELLIDO, :P_USUARIO, :P_CONTRASENA,
        :P_ID_PUESTO, :P_ID_TIPO, :P_ID_ESTADO, :P_EMAIL
    ); END;";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":P_NOMBRE",     $nombre);
    oci_bind_by_name($stmt, ":P_APELLIDO",   $apellido);
    oci_bind_by_name($stmt, ":P_USUARIO",    $usuario);
    oci_bind_by_name($stmt, ":P_CONTRASENA", $contrasena);
    oci_bind_by_name($stmt, ":P_ID_PUESTO",  $id_puesto);
    oci_bind_by_name($stmt, ":P_ID_TIPO",    $id_tipo);
    oci_bind_by_name($stmt, ":P_ID_ESTADO",  $id_estado);
    oci_bind_by_name($stmt, ":P_EMAIL",      $email);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    } else {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return "Error al guardar usuario: " . $e['message'];
    }
}

function cambiarEstadoUsuario($idUsuario, $nuevoEstado) {
    $conn = conectarOracle("admin");

    $sql = "BEGIN FARMACIA.FIDE_USUARIOS_PKG.USUARIOS_ELIMINAR_SP(:P_ID_USUARIO, :P_ID_ESTADO); END;";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":P_ID_USUARIO", $idUsuario);
    oci_bind_by_name($stmt, ":P_ID_ESTADO", $nuevoEstado);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    } else {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return "Error al cambiar estado: " . $e['message'];
    }
}

function obtenerUsuarioPorId($idUsuario) {
    $conn = conectarOracle("admin");

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_USUARIOS_PKG.USUARIOS_CONSULTAR_SP(:P_ID_USUARIO, :P_CURSOR); END;");
    oci_bind_by_name($stmt, ":P_ID_USUARIO", $idUsuario);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);

    $usuario = oci_fetch_assoc($cursor);

    oci_free_statement($stmt);
    oci_free_statement($cursor);
    oci_close($conn);

    return $usuario;
}

function actualizarUsuario($datos) {
    $conn = conectarOracle("admin");

    $idUsuario   = $datos['id_usuario'];
    $nombre      = $datos['nombre'];
    $apellido    = $datos['apellido'];
    $usuario     = ($datos['id_tipo'] == 1 || $datos['id_tipo'] == 2) ? $datos['usuario'] : null;
    $contrasena  = ($datos['id_tipo'] == 1 || $datos['id_tipo'] == 2) ? $datos['contrasena'] : null;
    $idPuesto    = ($datos['id_tipo'] == 1 || $datos['id_tipo'] == 2) ? $datos['id_puesto'] : null;
    $idTipo      = $datos['id_tipo'];
    $idEstado    = $datos['id_estado'];
    $email       = $datos['email'];

    $sql = "BEGIN FARMACIA.FIDE_USUARIOS_PKG.USUARIOS_ACTUALIZAR_SP(
        :P_ID_USUARIO, :P_NOMBRE, :P_APELLIDO, :P_USUARIO, :P_CONTRASENA,
        :P_ID_PUESTO, :P_ID_TIPO, :P_ID_ESTADO, :P_EMAIL
    ); END;";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":P_ID_USUARIO",  $idUsuario);
    oci_bind_by_name($stmt, ":P_NOMBRE",      $nombre);
    oci_bind_by_name($stmt, ":P_APELLIDO",    $apellido);
    oci_bind_by_name($stmt, ":P_USUARIO",     $usuario);
    oci_bind_by_name($stmt, ":P_CONTRASENA",  $contrasena);
    oci_bind_by_name($stmt, ":P_ID_PUESTO",   $idPuesto);
    oci_bind_by_name($stmt, ":P_ID_TIPO",     $idTipo);
    oci_bind_by_name($stmt, ":P_ID_ESTADO",   $idEstado);
    oci_bind_by_name($stmt, ":P_EMAIL",       $email);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    } else {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return "Error al actualizar usuario: " . $e['message'];
    }
}

?>