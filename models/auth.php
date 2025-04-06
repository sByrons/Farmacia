<?php
include_once __DIR__ . '/../config/database/conexion.php';

function validarUsuario($usuario, $contrasena) {

    $conn = oci_connect("FARMACIA", "123", "//localhost/XEPDB1");

    if (!$conn) {
        $e = oci_error();
        die("Error al conectar con Oracle: " . $e['message']);
    }

    $sql = "BEGIN FIDE_USUARIOS_PKG.USUARIOS_VALIDAR_SP(:P_USUARIO, :P_CONTRASENA, :P_ID_TIPO); END;";

    $stmt = oci_parse($conn, $sql);

    // Enlazamos los parámetros
    oci_bind_by_name($stmt, ":P_USUARIO", $usuario);
    oci_bind_by_name($stmt, ":P_CONTRASENA", $contrasena);
    oci_bind_by_name($stmt, ":P_ID_TIPO", $id_tipo, 10); // OUT

    oci_execute($stmt);

    // Si es NULL, login fallido
    if ($id_tipo === null) {
        return false;
    }

    return $id_tipo; // 1 = Admin, 2 = Empleado (por ejemplo)
}
?>

