<?php include_once realpath(__DIR__ . '/../../includes/head.php'); ?>
<?php include_once realpath(__DIR__ . '/../../includes/navbar.php'); ?>

<div class="main-content">
<body class="productos-page">

<div class="form-crear">
    <h2>Editar Producto</h2>

    <form method="POST" action="/Farmacia/controllers/productoController.php">
        <input type="hidden" name="accion" value="actualizar">
        <input type="hidden" name="id_producto" value="<?= $producto['PRODUCTO_ID_PRODUCTO_PK'] ?>">

        <input type="text" name="nombre" placeholder="Nombre del producto" value="<?= $producto['NOMBRE'] ?>" required>
        <input type="text" name="descripcion" placeholder="Descripción" value="<?= $producto['DESCRIPCION'] ?>" required>
        
        <input type="number" name="precio" placeholder="Precio unitario" value="<?= $producto['PRECIO'] ?>" step="0.01" required>
        
        <select name="id_estado" id="campo_estado" required>
            <option value="">Seleccione estado</option>
            <?php while ($row = oci_fetch_assoc($estados)): ?>
                <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>" <?= ($row['ESTADO_ID_ESTADO_PK'] == $producto['ESTADO_ID_ESTADO_PK']) ? 'selected' : '' ?>>
                    <?= $row['DESCRIPCION'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Actualizar Producto</button>
    </form>
</div>
</div>

<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
