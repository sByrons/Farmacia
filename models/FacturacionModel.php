<?php
require_once '/../config/database/conexion.php'; 

class FacturacionModel {
    private $db;

    public function __construct() {
        $this->db = Db::getInstance(); // Instancia de la clase Db
    }

    // Método para insertar una factura
    public function insertarFactura($idTipo, $total, $iva, $descuento, $idUsuario, $idProveedor, $idEstado) {
        $query = "EXEC FIDE_FACTURACION_PKG.FACTURACION_INSERTAR_SP
                  :P_ID_TIPO, :P_TOTAL, :P_IVA, :P_DESCUENTO, :P_ID_USUARIO, :P_ID_PROVEEDOR, :P_ID_ESTADO";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':P_ID_TIPO', $idTipo);
        $stmt->bindParam(':P_TOTAL', $total);
        $stmt->bindParam(':P_IVA', $iva);
        $stmt->bindParam(':P_DESCUENTO', $descuento);
        $stmt->bindParam(':P_ID_USUARIO', $idUsuario);
        $stmt->bindParam(':P_ID_PROVEEDOR', $idProveedor);
        $stmt->bindParam(':P_ID_ESTADO', $idEstado);

        return $stmt->execute();
    }

    // Método para actualizar una factura
    public function actualizarFactura($idFactura, $idTipo, $total, $iva, $descuento, $idUsuario, $idProveedor, $idEstado) {
        $query = "EXEC FIDE_FACTURACION_PKG.FACTURACION_ACTUALIZAR_SP
                  :P_ID_FACTURACION, :P_ID_TIPO, :P_TOTAL, :P_IVA, :P_DESCUENTO, :P_ID_USUARIO, :P_ID_PROVEEDOR, :P_ID_ESTADO";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':P_ID_FACTURACION', $idFactura);
        $stmt->bindParam(':P_ID_TIPO', $idTipo);
        $stmt->bindParam(':P_TOTAL', $total);
        $stmt->bindParam(':P_IVA', $iva);
        $stmt->bindParam(':P_DESCUENTO', $descuento);
        $stmt->bindParam(':P_ID_USUARIO', $idUsuario);
        $stmt->bindParam(':P_ID_PROVEEDOR', $idProveedor);
        $stmt->bindParam(':P_ID_ESTADO', $idEstado);

        return $stmt->execute();
    }

    // Método para eliminar una factura (cambiar estado a inactivo)
    public function eliminarFactura($idFactura, $idEstadoInactivo) {
        $query = "EXEC FIDE_FACTURACION_PKG.FACTURACION_ELIMINAR_SP
                  :P_ID_FACTURACION, :P_ID_ESTADO_INACTIVO";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':P_ID_FACTURACION', $idFactura);
        $stmt->bindParam(':P_ID_ESTADO_INACTIVO', $idEstadoInactivo);

        return $stmt->execute();
    }

    // Método para consultar una factura
    public function consultarFactura($idFactura) {
        $query = "EXEC FIDE_FACTURACION_PKG.FACTURACION_CONSULTAR_SP :P_ID_FACTURACION";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':P_ID_FACTURACION', $idFactura);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
