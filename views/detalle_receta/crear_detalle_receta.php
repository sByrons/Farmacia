<?php
session_start();
include_once __DIR__ . '/../../controllers/detalleRecetaController.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'id_receta'   => $_POST['id_receta'],
        'id_producto' => $_POST['id_producto'],
        'cantidad'    => $_POST['cantidad'],
        'id_unidad'   => $_POST['id_unidad'],
        'frecuencia'  => $_POST['frecuencia'],
        'duracion'    => $_POST['duracion'],
        'id_estado'   => $_POST['id_estado'],
    ];

    $resultado = insertarDetalleReceta($datos);
    if ($resultado === true) {
        $mensaje = '<div class="mensaje-exito">✔ Detalle de receta guardado exitosamente.</div>';
    } else {
        $mensaje = '<div class="mensaje-error">' . $resultado . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Detalle Receta</title>
    <link rel="stylesheet" href="/Farmacia/assets/css/estilos.css">
</head>
<body class="usuarios-page">
<?php include_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="form-crear">
    <h2>Agregar Detalle a una Receta</h2>

    <?= $mensaje ?>

    <form method="POST" action="">
        <input type="number" name="id_receta" placeholder="ID de la receta" required>
        <input type="number" name="id_producto" placeholder="ID del producto" required>
        <input type="number" name="cantidad" placeholder="Cantidad" required>
        <input type="number" name="id_unidad" placeholder="ID de unidad de dosis" required>
        <input type="number" name="frecuencia" placeholder="Frecuencia (horas)" required>
        <input type="number" name="duracion" placeholder="Duración (días)" required>
        <input type="number" name="id_estado" placeholder="ID de estado" required>

        <button type="submit">Guardar Detalle</button>
    </form>
</div>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>
