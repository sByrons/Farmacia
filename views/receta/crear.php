Crear.php
<?php 
include_once realpath(__DIR__ . '/../../includes/head.php'); 
include_once realpath(__DIR__ . '/../../includes/navbar.php'); 

include_once realpath(__DIR__ . '/../../models/Producto.php');
include_once realpath(__DIR__ . '/../../models/UnidadDosis.php');
include_once realpath(__DIR__ . '/../../models/Estado.php');

// Simulando usuario autenticado
$id_usuario = 1; // En la práctica lo obtienes desde $_SESSION o autenticación

$productos = obtenerProductos();
$unidades = obtenerUnidadesDosis();
$estados = obtenerEstados();
?>

<div class="main-content">
  <body class="receta-page">
    <div class="form-crear">
      <h2>Crear nueva receta</h2>
    

      <form method="POST" action="/Farmacia/controllers/receta_Controller.php">
        <input type="hidden" name="accion" value="guardar">
        <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">

        <!-- FECHA DE LA RECETA -->
        <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" required>

        <!-- ESTADO DE LA RECETA -->
        <select name="id_estado_receta" required>
          <option value="">Selecciona el estado de la receta</option>
          <?php while ($row = oci_fetch_assoc($estados)): ?>
            <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>">
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
            <option value="<?= $row['PRODUCTO_ID_PRODUCTO_PK'] ?>">
              <?= $row['NOMBRE'] ?>
            </option>
          <?php endwhile; ?>
        </select>

        <input type="number" name="cantidad" placeholder="Cantidad" required>

        <!-- UNIDAD DE DOSIS -->
        <select name="id_unidad" required>
          <option value="">Unidad de dosis</option>
          <?php while ($row = oci_fetch_assoc($unidades)): ?>
            <option value="<?= $row['UNIDAD_DOSIS_ID_UNIDAD_PK'] ?>">
              <?= $row['NOMBRE'] ?>
            </option>
          <?php endwhile; ?>
        </select>

        <input type="number" name="frecuencia" placeholder="Frecuencia (horas)">
        <input type="number" name="duracion" placeholder="Duración (días)">

        <!-- ESTADO DEL DETALLE -->
        <select name="id_estado_detalle" required>
          <option value="">Estado del detalle</option>
          <?php oci_execute($estados); // Reutilizamos el cursor ?>
          <?php while ($row = oci_fetch_assoc($estados)): ?>
            <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>">
              <?= $row['DESCRIPCION'] ?>
            </option>
          <?php endwhile; ?>
        </select>

        <button type="submit">Guardar Receta</button>
      </form>
    </div>
  </body>
  <script src="/Farmacia/assets/js/script.js"></script>
</div>

<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
