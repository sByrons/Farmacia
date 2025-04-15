<?php
function conectarOracle($rol) {
    $host = "//localhost/XEPDB1";  // Cambiar si usás otro nombre de servicio

    if ($rol === "system") {
        $usuario = "aejjiiQS06";
        $clave = "farmacia";
    } elseif ($rol === "123") {
        $usuario = "FARMACIA_EMPLEADO";
        $clave = "empleado123";
    } else {
        die("❌ Rol inválido para la conexión.");
    }

    $conn = oci_connect($usuario, $clave, $host);
    
    if (!$conn) {
        $e = oci_error();
        die("❌ Error de conexión con Oracle: " . $e['message']);
    }

    return $conn;
}

?>
