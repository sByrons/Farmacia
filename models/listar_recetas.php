<?php
session_start();
include_once __DIR__ . '/../models/receta.php';

$estadoId = $_GET['estado'] ?? 1;
$recetas = listarRecetas($estadoId);
?>

<div class="container">
    <h2>Recetas Médicas</h2>
    <a href="crear_receta.php">+ Nueva Receta</a>
    <form method="GET" class="filtro-estado">
        <label>Filtrar por estado:</label>
        <select name="estado" onchange="this.form.submit()">
            <option value="1" <?= $estadoId == 1 ? 'selected' : '' ?>>Activa</option>
            <option value="2" <?= $estadoId == 2 ? 'selected' : '' ?>>Inactiva</option>
        </select>
    </form>
    <table class="usuarios">
        <tr><th>ID</th><th>Paciente</th><th>Fecha</th><th>Estado</th><th>Acciones</th></tr>
        <?php foreach ($recetas as $receta): ?>
            <tr>
                <td><?= $receta['ID_RECETA'] ?></td>
                <td><?= $receta['ID_USUARIO'] ?></td>
                <td><?= $receta['FECHA'] ?></td>
                <td class="<?= strtolower($receta['ESTADO']) ?>"><?= $receta['ESTADO'] ?></td>
                <td>
                    <a href="editar_receta.php?id=<?= $receta['ID_RECETA'] ?>">✏️</a>
                    <a href="recetaController.php?accion=eliminar&id=<?= $receta['ID_RECETA'] ?>" onclick="return confirm('¿Eliminar receta?');">🗑️</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
