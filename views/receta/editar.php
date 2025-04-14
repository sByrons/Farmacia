<?php include_once realpath(__DIR__ . '/../../includes/head.php'); ?>
<?php include_once realpath(__DIR__ . '/../../includes/navbar.php'); ?>

<div class="main-content">
<body class="recetas-page">

<div class="form-crear">
  
    <h2>Editar Receta</h2>

    <form method="POST" action="/Farmacia/controllers/receta_Controller.php">
        <input type="hidden" name="accion" value="actualizar">
        <input type="hidden" name="id_receta" value="<?= $receta['RECETA_ID_RECETA_PK'] ?>">

        <!-- FECHA DE LA RECETA -->
        <input type="date" name="fecha" value="<?= $receta['FECHA'] ?>" required>

        <!-- ESTADO DE LA RECETA -->
        <select name="id_estado_receta" required>
            <option value="">Selecciona el estado de la receta</option>
            <?php while ($row = oci_fetch_assoc($estados)): ?>
                <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>" <?= ($row['ESTADO_ID_ESTADO_PK'] == $receta['ID_ESTADO']) ? 'selected' : '' ?>>
                    <?= $row['DESCRIPCION'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <hr>
        <h3>Detalle de la receta</h3>

        <!-- PRODUCTO -->
        <select name="id_producto" required>
            <option value="">Selecciona un producto</option>
            <?php while ($row = oci_fetch_assoc($productos)): ?>
                <option value="<?= $row['PRODUCTO_ID_PRODUCTO_PK'] ?>" <?= ($row['PRODUCTO_ID_PRODUCTO_PK'] == $detalle_receta['ID_PRODUCTO']) ? 'selected' : '' ?>>
                    <?= $row['NOMBRE'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="number" name="cantidad" placeholder="Cantidad" value="<?= $detalle_receta['CANTIDAD'] ?>" required>

        <!-- UNIDAD DE DOSIS -->
        <select name="id_unidad" required>
            <option value="">Unidad de dosis</option>
            <?php while ($row = oci_fetch_assoc($unidades)): ?>
                <option value="<?= $row['UNIDAD_DOSIS_ID_UNIDAD_PK'] ?>" <?= ($row['UNIDAD_DOSIS_ID_UNIDAD_PK'] == $detalle_receta['ID_UNIDAD']) ? 'selected' : '' ?>>
                    <?= $row['NOMBRE'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="number" name="frecuencia" placeholder="Frecuencia (horas)" value="<?= $detalle_receta['FRECUENCIA_HORAS'] ?>">
        <input type="number" name="duracion" placeholder="Duración (días)" value="<?= $detalle_receta['DURACION'] ?>">

        <!-- ESTADO DEL DETALLE -->
        <select name="id_estado_detalle" required>
            <option value="">Estado del detalle</option>
            <?php while ($row = oci_fetch_assoc($estados)): ?>
                <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>" <?= ($row['ESTADO_ID_ESTADO_PK'] == $detalle_receta['ID_ESTADO']) ? 'selected' : '' ?>>
                    <?= $row['DESCRIPCION'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Actualizar Receta</button>
    </form>
</div>
</div>

<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>

