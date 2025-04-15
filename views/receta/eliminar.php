<?php 
function eliminarReceta($idReceta) {
    try {
        include_once __DIR__ . '/../config/conexion.php'; // Asegúrate de tener este archivo

        // Iniciar conexión
        $conn = conectar(); // Tu función para conectar a Oracle

        // Iniciar transacción
        oci_execute(oci_parse($conn, "BEGIN NULL; END;")); // asegura que se pueda hacer rollback

        // 1. Eliminar detalles de la receta
        $sqlDetalle = "DELETE FROM FIDE_DETALLE_RECETA_TB WHERE ID_RECETA = :id";
        $stmtDetalle = oci_parse($conn, $sqlDetalle);
        oci_bind_by_name($stmtDetalle, ':id', $idReceta);
        oci_execute($stmtDetalle, OCI_NO_AUTO_COMMIT);

        // 2. Eliminar la receta
        $sqlReceta = "DELETE FROM FIDE_RECETA_TB WHERE RECETA_ID_RECETA_PK = :id";
        $stmtReceta = oci_parse($conn, $sqlReceta);
        oci_bind_by_name($stmtReceta, ':id', $idReceta);
        oci_execute($stmtReceta, OCI_NO_AUTO_COMMIT);

        // Confirmar la transacción
        oci_commit($conn);

        oci_free_statement($stmtDetalle);
        oci_free_statement($stmtReceta);
        oci_close($conn);

        return true;

    } catch (Exception $e) {
        if (isset($conn)) {
            oci_rollback($conn);
        }
        return "Error al eliminar la receta: " . $e->getMessage();
    }
}
