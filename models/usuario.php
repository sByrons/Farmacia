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

function obtenerProvincias() {
    $conn = conectarOracle("admin");
    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_CATALOGOS_PKG.LISTAR_PROVINCIAS_SP(:P_CURSOR); END;");
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
    return $cursor;
}

function obtenerCantonesPorProvincia($idProvincia) {
    $conn = conectarOracle("admin");
    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_CATALOGOS_PKG.LISTAR_CANTONES_SP(:P_ID_PROVINCIA, :P_CURSOR); END;");
    oci_bind_by_name($stmt, ":P_ID_PROVINCIA", $idProvincia);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
    return $cursor;
}

function obtenerDistritosPorCanton($idCanton) {
    $conn = conectarOracle("admin");
    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_CATALOGOS_PKG.LISTAR_DISTRITOS_SP(:P_ID_CANTON, :P_CURSOR); END;");
    oci_bind_by_name($stmt, ":P_ID_CANTON", $idCanton);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
    return $cursor;
}

function obtenerTiposTelefono() {
    $conn = conectarOracle("admin");

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_CATALOGOS_PKG.LISTAR_TIPOS_TELEFONO_SP(:P_CURSOR); END;");
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
    $cedula      = $datos['cedula'];
    $id_tipo     = $datos['id_tipo'];
    $id_estado   = $datos['id_estado'];

    $usuario     = ($id_tipo == 1 || $id_tipo == 2) ? $datos['usuario'] : null;
    $contrasena  = ($id_tipo == 1 || $id_tipo == 2) ? $datos['contrasena'] : null;
    $id_puesto   = ($id_tipo == 1 || $id_tipo == 2) ? $datos['id_puesto'] : null;

    $telefono    = $datos['telefono'];
    $id_tipo_tel = $datos['id_tipo_telefono'];

    $provincia   = $datos['provincia'];
    $canton      = $datos['canton'];
    $distrito    = $datos['distrito'];
    $direccion   = $datos['direccion_exacta'];


    $idGenerado = 0;

    $sql = "
    DECLARE
        V_ID_USUARIO NUMBER;
    BEGIN
        -- Insertar usuario
        FARMACIA.FIDE_USUARIOS_PKG.USUARIOS_INSERTAR_SP(
            :P_NOMBRE, :P_APELLIDO, :P_CEDULA, :P_USUARIO, :P_CONTRASENA,
            :P_ID_PUESTO, :P_ID_TIPO, :P_ID_ESTADO, :P_EMAIL,
            
            V_ID_USUARIO
        );

        -- Insertar dirección
        FARMACIA.FIDE_CONTACTO_PKG.INSERTAR_DIRECCION_SP(
            :P_PROVINCIA, :P_CANTON, :P_DISTRITO, :P_DIRECCION,
            V_ID_USUARIO, NULL, :P_ID_ESTADO
        );

        -- Insertar teléfono
        FARMACIA.FIDE_CONTACTO_PKG.INSERTAR_TELEFONO_SP(
            :P_TELEFONO, :P_ID_TIPO_TEL, V_ID_USUARIO, NULL, :P_ID_ESTADO
        );

        :P_ID_GENERADO := V_ID_USUARIO;
    END;
    ";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":P_NOMBRE",     $nombre);
    oci_bind_by_name($stmt, ":P_APELLIDO",   $apellido);
    oci_bind_by_name($stmt, ":P_CEDULA",     $cedula);
    oci_bind_by_name($stmt, ":P_USUARIO",    $usuario);
    oci_bind_by_name($stmt, ":P_CONTRASENA", $contrasena);
    oci_bind_by_name($stmt, ":P_ID_PUESTO",  $id_puesto);
    oci_bind_by_name($stmt, ":P_ID_TIPO",    $id_tipo);
    oci_bind_by_name($stmt, ":P_ID_ESTADO",  $id_estado);
    oci_bind_by_name($stmt, ":P_EMAIL",      $email);
    

    
    oci_bind_by_name($stmt, ":P_PROVINCIA",  $provincia);
    oci_bind_by_name($stmt, ":P_CANTON",     $canton);
    oci_bind_by_name($stmt, ":P_DISTRITO",   $distrito);
    oci_bind_by_name($stmt, ":P_DIRECCION",  $direccion);

    
    oci_bind_by_name($stmt, ":P_TELEFONO",     $telefono);
    oci_bind_by_name($stmt, ":P_ID_TIPO_TEL",  $id_tipo_tel);

    
    oci_bind_by_name($stmt, ":P_ID_GENERADO", $idGenerado, -1, SQLT_INT);

    
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

    $idUsuario    = $datos['id_usuario'];
    $nombre       = $datos['nombre'];
    $apellido     = $datos['apellido'];
    $usuario      = ($datos['id_tipo'] == 1 || $datos['id_tipo'] == 2) ? $datos['usuario'] : null;
    $contrasena   = ($datos['id_tipo'] == 1 || $datos['id_tipo'] == 2) ? $datos['contrasena'] : null;
    $idPuesto     = ($datos['id_tipo'] == 1 || $datos['id_tipo'] == 2) ? $datos['id_puesto'] : null;
    $idTipo       = $datos['id_tipo'];
    $idEstado     = $datos['id_estado'];
    $email        = $datos['email'];
    $cedula       = $datos['cedula'];

    $telefono     = $datos['telefono'];
    $idTipoTel    = $datos['id_tipo_telefono'];

    $provincia    = $datos['provincia'];
    $canton       = $datos['canton'];
    $distrito     = $datos['distrito'];
    $direccion    = $datos['direccion_exacta'];

    $sql = "
    BEGIN
        -- Actualizar datos del usuario
        FARMACIA.FIDE_USUARIOS_PKG.USUARIOS_ACTUALIZAR_SP(
            :P_ID_USUARIO, :P_NOMBRE, :P_APELLIDO, :P_CEDULA, :P_USUARIO,
            :P_CONTRASENA, :P_ID_PUESTO, :P_ID_TIPO, :P_ID_ESTADO, :P_EMAIL
        );

        -- Actualizar dirección
        FARMACIA.FIDE_CONTACTO_PKG.ACTUALIZAR_DIRECCION_SP(
            :P_ID_USUARIO, :P_PROVINCIA, :P_CANTON, :P_DISTRITO,
            :P_DIRECCION, :P_ID_ESTADO
        );

        -- Actualizar teléfono
        FARMACIA.FIDE_CONTACTO_PKG.ACTUALIZAR_TELEFONO_SP(
            :P_ID_USUARIO, :P_TELEFONO, :P_ID_TIPO_TEL, :P_ID_ESTADO
        );
    END;
    ";

    $stmt = oci_parse($conn, $sql);

    // Datos usuario
    oci_bind_by_name($stmt, ":P_ID_USUARIO",  $idUsuario);
    oci_bind_by_name($stmt, ":P_NOMBRE",      $nombre);
    oci_bind_by_name($stmt, ":P_APELLIDO",    $apellido);
    oci_bind_by_name($stmt, ":P_CEDULA",      $cedula);
    oci_bind_by_name($stmt, ":P_USUARIO",     $usuario);
    oci_bind_by_name($stmt, ":P_CONTRASENA",  $contrasena);
    oci_bind_by_name($stmt, ":P_ID_PUESTO",   $idPuesto);
    oci_bind_by_name($stmt, ":P_ID_TIPO",     $idTipo);
    oci_bind_by_name($stmt, ":P_ID_ESTADO",   $idEstado);
    oci_bind_by_name($stmt, ":P_EMAIL",       $email);

    // Dirección
    oci_bind_by_name($stmt, ":P_PROVINCIA",   $provincia);
    oci_bind_by_name($stmt, ":P_CANTON",      $canton);
    oci_bind_by_name($stmt, ":P_DISTRITO",    $distrito);
    oci_bind_by_name($stmt, ":P_DIRECCION",   $direccion);

    // Teléfono
    oci_bind_by_name($stmt, ":P_TELEFONO",    $telefono);
    oci_bind_by_name($stmt, ":P_ID_TIPO_TEL", $idTipoTel);

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