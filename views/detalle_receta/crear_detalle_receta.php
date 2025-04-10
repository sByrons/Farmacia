<?php include_once __DIR__ . '/../includes/head.php'; ?>

<body class="usuarios-page">
    <div class="form-crear">
        <h2>Registrar Detalle de Receta</h2>

        <?php if (isset($_GET['exito'])): ?>
            <div class="mensaje-exito">✔️ ¡Detalle de receta registrado correctamente!</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="mensaje-error">❌ <?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <form action="../../controllers/detalleRecetaController.php" method="POST">
            <input type="number" name="id_receta" placeholder="ID Receta" required>
            <input type="number" name="id_producto" placeholder="ID Producto" required>
            <input type="number" name="cantidad" placeholder="Cantidad" required>
            <input type="number" name="id_unidad" placeholder="ID Unidad" required>
            <input type="number" name="frecuencia" placeholder="Frecuencia (horas)" required>
            <input type="number" name="duracion" placeholder="Duración (días)" required>
            <input type="number" name="id_estado" placeholder="ID Estado" required>

            <button type="submit">Guardar Detalle</button>
        </form>
    </div>

    <?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
