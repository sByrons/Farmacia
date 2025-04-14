<?php 
include_once realpath(__DIR__ . '/../../includes/head.php'); 
include_once realpath(__DIR__ . '/../../includes/navbar.php'); 
?>

<style>
    /* Estilos similares al código anterior */
</style>

<div class="main-content">
<body class="recetas-page">
<a href="/Farmacia/controllers/receta_Controller.php?accion=crear">Nueva Receta</a>

<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="mensaje-exito">
        <?= $_SESSION['mensaje']; ?>
    </div>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="mensaje-error">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="container">
    <h2>Recetas del Sistema</h2>
    <div style="text-align: right; margin-bottom: 10px;">
        <a href="/Farmacia/controllers/receta_Controller.php?accion=crear">+ Nueva Receta</a>
    </div>

    <form method="GET" action="/Farmacia/controllers/receta_Controller.php" class="filtro-estado">
        <label for="estado">Filtrar por estado:</label>
        <select name="estado" id="estado" onchange="this.form.submit()">
            <option value="1" <?php if (isset($estadoId) && $estadoId == 1) echo 'selected'; ?>>Activo</option>
            <option value="2" <?php if (isset($estadoId) && $estadoId == 2) echo 'selected'; ?>>Inactivo</option>
        </select>
    </form>

    <table class="recetas">
        <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php if (isset($recetas) && !empty($recetas)): ?>
            <?php foreach ($recetas as $row): ?>
                <tr>
                    <td><?php echo date("d/m/Y", strtotime($row['FECHA'])); ?></td>
                    <td><?php echo $row['USUARIO']; ?></td>
                    <td class="<?php echo strtolower($row['ESTADO']); ?>"><?php echo $row['ESTADO']; ?></td>
                    <td>
                        <a href="/Farmacia/controllers/Rreceta_Controller.php?accion=editar&id=<?php echo $row['RECETA_ID_RECETA_PK']; ?>">✏️</a>
                        <?php if (strtolower($row['ESTADO']) == 'activo'): ?>
                            <a href="/Farmacia/controllers/receta_Controller.php?accion=desactivar&id=<?php echo $row['RECETA_ID_RECETA_PK']; ?>" onclick="return confirm('¿Seguro que deseas desactivar esta receta?');">🛑</a>
                        <?php else: ?>
                            <a href="/Farmacia/controllers/receta_Controller.php?accion=activar&id=<?php echo $row['RECETA_ID_RECETA_PK']; ?>" onclick="return confirm('¿Activar esta receta?');">✅</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No se encontraron recetas.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
</div>

<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
</body>
</div>

