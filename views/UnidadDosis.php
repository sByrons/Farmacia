<?php
function obtenerUnidadesDosis() {
    $conn = oci_connect('USUARIO', 'CLAVE', 'localhost/XE');
    $sql = "SELECT UNIDAD_DOSIS_ID_UNIDAD_PK, NOMBRE FROM FIDE_UNIDAD_DOSIS_TB";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    return $stmt;
}
?>
