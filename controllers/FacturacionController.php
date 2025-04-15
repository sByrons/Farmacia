<?php
require_once '../models/FacturacionModel.php';
require_once '../models/DetalleFacturacionModel.php';

class FacturacionController {
    private $facturacionModel;
    private $detalleFacturacionModel;

    public function __construct() {
        $this->facturacionModel = new FacturacionModel();
        $this->detalleFacturacionModel = new DetalleFacturacionModel();
    }

    // Acción para insertar una nueva factura
    public function insertarFactura() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener datos del formulario
            $idTipo = $_POST['id_tipo'];
            $total = $_POST['total'];
            $iva = $_POST['iva'];
            $descuento = $_POST['descuento'];
            $idUsuario = $_POST['id_usuario'];
            $idProveedor = $_POST['id_proveedor'];
            $idEstado = $_POST['id_estado'];

            // Insertar la factura
            $this->facturacionModel->insertarFactura($idTipo, $total, $iva, $descuento, $idUsuario, $idProveedor, $idEstado);
            $_SESSION['mensaje'] = "Factura creada exitosamente.";
            header('Location: /facturacion/listar');
        }
    }

    // Acción para actualizar una factura
    public function actualizarFactura() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener datos del formulario
            $idFactura = $_POST['id_factura'];
            $idTipo = $_POST['id_tipo'];
            $total = $_POST['total'];
            $iva = $_POST['iva'];
            $descuento = $_POST['descuento'];
            $idUsuario = $_POST['id_usuario'];
            $idProveedor = $_POST['id_proveedor'];
            $idEstado = $_POST['id_estado'];

            // Actualizar la factura
            $this->facturacionModel->actualizarFactura($idFactura, $idTipo, $total, $iva, $descuento, $idUsuario, $idProveedor, $idEstado);
            $_SESSION['mensaje'] = "Factura actualizada exitosamente.";
            header('Location: /facturacion/listar');
        }
    }

    // Acción para eliminar una factura (cambiar estado a inactivo)
    public function eliminarFactura() {
        $idFactura = $_GET['id'];
        $idEstadoInactivo = 2; // Suponiendo que 2 es el estado inactivo

        // Eliminar la factura
        $this->facturacionModel->eliminarFactura($idFactura, $idEstadoInactivo);
        $_SESSION['mensaje'] = "Factura eliminada exitosamente.";
        header('Location: /facturacion/listar');
    }

    // Acción para consultar una factura
    public function consultarFactura() {
        $idFactura = $_GET['id'];
        $factura = $this->facturacionModel->consultarFactura($idFactura);
        require_once '../views/facturacion/consultar.php';
    }
}
?>
