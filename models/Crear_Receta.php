<?php
session_start();
include_once __DIR__ . '/../models/receta.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'id_usuario' => $_POST['id_usuario'],
        'fecha' => $_POST['fecha'],
        'id_estado' => $_POST['id_estado'],
    ];

    $resultado = insertarReceta($datos);
    $mensaje = $resultado === true
        ? '<div class="mensaje-exito">✔ Receta guardada exitosamente.</div>'
        : '<div class="mensaje-error">' . $resultado . '</div>';
}
?>

<div class="form-crear">
    <h2>Agregar Receta Médica</h2>
    <?= $mensaje ?>
    <form method="POST" action="">
        <input type="number" name="id_usuario" placeholder="ID Paciente" required>
        <input type="date" name="fecha" required>
        <input type="number" name="id_estado" placeholder="ID Estado" required>
        <button type="submit">Guardar Receta</button>
    </form>
</div>
