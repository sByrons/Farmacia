<?php
include_once __DIR__ . '/../models/detalle_receta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'id_receta'   => $_POST['id_receta'],
        'id_producto' => $_POST['id_producto'],
        'cantidad'    => $_POST['cantidad'],
        'id_unidad'   => $_POST['id_unidad'],
        'frecuencia'  => $_POST['frecuencia'],
        'duracion'    => $_POST['duracion'],
        'id_estado'   => $_POST['id_estado']
    ];

    $resultado = insertarDetalleReceta($datos);

    if ($resultado === true) {
        header('Location: ../views/detalle_receta/crear_detalle_receta.php?exito=1');
    } else {
        header('Location: ../views/detalle_receta/crear_detalle_receta.php?error=' . urlencode($resultado));
    }
    exit;
}
?>
