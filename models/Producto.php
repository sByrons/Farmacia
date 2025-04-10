<?php
include_once __DIR__ . '/../config/database/conexion.php';


function listarProductosPorEstado($estadoId) {
    // Conectar a la base de datos
    $conn = conectarOracle("admin");

    if (!$conn) {
        $e = oci_error();
        die("Error: " . $e['message']);
    }

    // Crear un cursor para la salida
    $cursor = oci_new_cursor($conn);

    // Preparar el llamado al procedimiento
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_PRODUCTO_PKG.PRODUCTO_CONSULTAR_POR_ESTADO(:P_ESTADO_ID, :P_CURSOR); END;");

    // Vincular los parámetros
    oci_bind_by_name($stmt, ":P_ESTADO_ID", $estadoId, 32);  // Vincula el estado
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);  // Vincula el cursor

    // Ejecutar el procedimiento
    oci_execute($stmt);

    // Ejecutar el cursor
    oci_execute($cursor);

    // Recorrer los resultados
    $productos = [];
    while ($row = oci_fetch_assoc($cursor)) {
        $productos[] = $row;
    }

    // Cerrar el cursor
    oci_free_cursor($cursor);

    // Retornar los resultados
    return $productos;
}



// Función para insertar un producto
function guardarProducto($datos) {
    $conn = conectarOracle("admin");

    $nombre        = $datos['nombre'];
    $descripcion   = $datos['descripcion'];
    $precio        = $datos['precio'];
    $estadoId      = $datos['estado_id'];

    $sql = "
    BEGIN
        FARMACIA.FIDE_PRODUCTO_PKG.PRODUCTO_INSERTAR_SP(
            :P_NOMBRE, :P_DESCRIPCION, :P_PRECIO, :P_ESTADO
        );
    END;
    ";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":P_NOMBRE",        $nombre);
    oci_bind_by_name($stmt, ":P_DESCRIPCION",   $descripcion);
    oci_bind_by_name($stmt, ":P_PRECIO",        $precio);
    oci_bind_by_name($stmt, ":P_ESTADO",        $estadoId);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    } else {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return "Error al guardar producto: " . $e['message'];
    }
}

// Función para actualizar un producto
function actualizarProducto($datos) {
    $conn = conectarOracle("admin");

    $idProducto     = $datos['id_producto'];
    $nombre         = $datos['nombre'];
    $descripcion    = $datos['descripcion'];
    $precio         = $datos['precio'];
    $estadoId       = $datos['estado_id'];

    $sql = "
    BEGIN
        FARMACIA.FIDE_PRODUCTO_PKG.PRODUCTO_ACTUALIZAR_SP(
            :P_ID_PRODUCTO, :P_NOMBRE, :P_DESCRIPCION, :P_PRECIO, :P_ESTADO
        );
    END;
    ";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":P_ID_PRODUCTO",   $idProducto);
    oci_bind_by_name($stmt, ":P_NOMBRE",        $nombre);
    oci_bind_by_name($stmt, ":P_DESCRIPCION",   $descripcion);
    oci_bind_by_name($stmt, ":P_PRECIO",        $precio);
    oci_bind_by_name($stmt, ":P_ESTADO",        $estadoId);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    } else {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return "Error al actualizar producto: " . $e['message'];
    }
}

// Función para eliminar un producto (marcar como inactivo)
function eliminarProducto($idProducto, $estadoInactivo) {
    $conn = conectarOracle("admin");

    $sql = "
    BEGIN
        FARMACIA.FIDE_PRODUCTO_PKG.PRODUCTO_ELIMINAR_SP(:P_ID_PRODUCTO, :P_ID_ESTADO_INACTIVO);
    END;
    ";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":P_ID_PRODUCTO", $idProducto);
    oci_bind_by_name($stmt, ":P_ID_ESTADO_INACTIVO", $estadoInactivo);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        return true;
    } else {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        return "Error al eliminar producto: " . $e['message'];
    }
}

// Función para consultar un producto por su ID
function obtenerProductoPorId($idProducto) {
    $conn = conectarOracle("admin");

    $cursor = oci_new_cursor($conn);
    $stmt = oci_parse($conn, "BEGIN FARMACIA.FIDE_PRODUCTO_PKG.PRODUCTO_CONSULTAR_SP(:P_ESTADO, :P_CURSOR); END;");
    oci_bind_by_name($stmt, ":P_ID_PRODUCTO", $idProducto);
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);

    $producto = oci_fetch_assoc($cursor);

    oci_free_statement($stmt);
    oci_free_statement($cursor);
    oci_close($conn);

    return $producto;
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

// Función para listar todos los productos
function listarTodosLosProductos() {
    // Conectar a la base de datos
    $conn = conectarOracle("admin");

    // Crear un cursor para la salida
    $cursor = oci_new_cursor($conn);

    // Preparar el llamado al procedimiento para obtener todos los productos
    $stmt = oci_parse($conn, "BEGIN FARMACIA.PRODUCTO_CONSULTAR_TODOS(:P_CURSOR); END;");

    // Vincular el cursor
    oci_bind_by_name($stmt, ":P_CURSOR", $cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento
    oci_execute($stmt);

    // Ejecutar el cursor
    oci_execute($cursor);

    // Recorrer los resultados
    $productos = [];
    while ($row = oci_fetch_assoc($cursor)) {
        $productos[] = $row;
    }

    // Cerrar el cursor
    oci_free_cursor($cursor);

    // Retornar los resultados
    return $productos;
}

?>



