<?php include_once realpath(__DIR__ . '/../../includes/head.php'); ?>
<?php include_once realpath(__DIR__ . '/../../includes/navbar.php'); ?>
<div class="main-content">
<body class="productos-page">
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
    <h2>Productos del Sistema</h2>
    <div style="text-align: right; margin-bottom: 10px;">
    <a href="/Farmacia/controllers/productoController.php?accion=crear" style="background-color: #005580; color: white; padding: 10px 15px; border-radius: 6px; text-decoration: none;">+ Nuevo Producto</a>
    </div>
    <form method="GET" action="/Farmacia/controllers/productoController.php" class="filtro-estado">
        <label for="estado">Filtrar por estado:</label>
        <select name="estado" id="estado" onchange="this.form.submit()">
            <option value="1" <?php if ($estadoId == 1) echo 'selected'; ?>>Activo</option>
            <option value="2" <?php if ($estadoId == 2) echo 'selected'; ?>>Inactivo</option>
        </select>
    </form>

    <table class="productos">
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php while ($row = oci_fetch_assoc($productos)): ?>
            <tr>
                <td><?php echo $row['NOMBRE']; ?></td>
                <td><?php echo $row['DESCRIPCION']; ?></td>
                <td><?php echo $row['PRECIO']; ?></td>
                <td class="<?php echo strtolower($row['ESTADO']); ?>"><?php echo $row['ESTADO']; ?></td>
                <td>
                    <a href="/Farmacia/controllers/productoController.php?accion=editar&id=<?php echo $row['PRODUCTO_ID_PRODUCTO_PK']; ?>">✏️</a>
                    <?php if (strtolower($row['ESTADO']) == 'activo'): ?>
                    <a href="/Farmacia/controllers/productoController.php?accion=desactivar&id=<?php echo $row['PRODUCTO_ID_PRODUCTO_PK']; ?>" onclick="return confirm('¿Seguro que deseas desactivar este producto?');">🛑</a>
                     <?php else: ?>
                    <a href="/Farmacia/controllers/productoController.php?accion=activar&id=<?php echo $row['PRODUCTO_ID_PRODUCTO_PK']; ?>" onclick="return confirm('¿Activar este producto?');">✅</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</div>
<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
</body>
</div>
