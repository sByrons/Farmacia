<?php
include_once __DIR__ . '/../models/usuario.php';


if (isset($_GET['accion'])) {
    header('Content-Type: application/json');

    if ($_GET['accion'] === 'cantones' && isset($_GET['provincia'])) {
        $cantones = obtenerCantonesPorProvincia($_GET['provincia']);
    
        $resultado = [];
        while ($row = oci_fetch_assoc($cantones)) {
            array_walk_recursive($row, function (&$item) {
                $item = utf8_encode($item);
            });
            $resultado[] = $row;
        }
    
        echo json_encode($resultado);
        exit;
    }

    if ($_GET['accion'] === 'distritos' && isset($_GET['canton'])) {
        $distritos = obtenerDistritosPorCanton($_GET['canton']);
        $resultado = [];
        while ($row = oci_fetch_assoc($distritos)) {
            array_walk_recursive($row, function (&$item) {
                $item = utf8_encode($item);
            });
            $resultado[] = $row;
        }
        echo json_encode($resultado);
        exit;
    }
}
