<?php
function obtenerUnidadesDosis() {
    $conexion = oci_connect('usuario', 'contraseña', 'localhost/XE');
    $sql = "SELECT UNIDAD_DOSIS_ID_UNIDAD_PK, NOMBRE FROM FIDE_UNIDAD_DOSIS_TB";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    return $stmt;
}


function obtenerUnidadesDosis() {
    return [
        ['id' => 1, 'unidad' => 'mg'],
        ['id' => 2, 'unidad' => 'ml'],
        ['id' => 3, 'unidad' => 'tabletas']
    ];
}


?>