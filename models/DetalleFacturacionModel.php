<?php
require_once '/../config/database/conexion.php'; 

class DetalleFacturacionModel {
    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    // Método para insertar un detalle de factura
    public function insertarDetalleFactura($idFactura, $idProducto, $cantidad, $precioUnitario, $idEstado) {
        $query = "EXEC FIDE_DETALLE_FACTURACION_PKG.DETALLE_FACTURA_INSERTAR_SP
                  :P_ID_FACTURACION, :P_ID_PRODUCTO, :P_CANTIDAD, :P_PRECIO_UNITARIO, :P_ID_ESTADO";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':P_ID_FACTURACION', $idFactura);
        $stmt->bindParam(':P_ID_PRODUCTO', $idProducto);
        $stmt->bindParam(':P_CANTIDAD', $cantidad);
        $stmt->bindParam(':P_PRECIO_UNITARIO', $precioUnitario);
        $stmt->bindParam(':P_ID_ESTADO', $idEstado);

        return $stmt->execute();
    }

    // Método para actualizar un detalle de factura
    public function actualizarDetalleFactura($idDetalle, $idProducto, $cantidad, $precioUnitario, $idEstado) {
        $query = "EXEC FIDE_DETALLE_FACTURACION_PKG.DETALLE_FACTURA_ACTUALIZAR_SP
                  :P_ID_DETALLE, :P_ID_PRODUCTO, :P_CANTIDAD, :P_PRECIO_UNITARIO, :P_ID_ESTADO";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':P_ID_DETALLE', $idDetalle);
        $stmt->bindParam(':P_ID_PRODUCTO', $idProducto);
        $stmt->bindParam(':P_CANTIDAD', $cantidad);
        $stmt->bindParam(':P_PRECIO_UNITARIO', $precioUnitario);
        $stmt->bindParam(':P_ID_ESTADO', $idEstado);

        return $stmt->execute();
    }

    // Método para eliminar un detalle de factura
    public function eliminarDetalleFactura($idDetalle, $idEstadoInactivo) {
        $query = "EXEC FIDE_DETALLE_FACTURACION_PKG.DETALLE_FACTURA_ELIMINAR_SP
                  :P_ID_DETALLE, :P_ID_ESTADO_INACTIVO";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':P_ID_DETALLE', $idDetalle);
        $stmt->bindParam(':P_ID_ESTADO_INACTIVO', $idEstadoInactivo);

        return $stmt->execute();
    }

    // Método para consultar un detalle de factura
    public function consultarDetalleFactura($idDetalle) {
        $query = "EXEC FIDE_DETALLE_FACTURACION_PKG.DETALLE_FACTURA_CONSULTAR_SP :P_ID_DETALLE";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':P_ID_DETALLE', $idDetalle);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
