<?php 
include_once realpath(__DIR__ . '/../../includes/head.php'); 
include_once realpath(__DIR__ . '/../../includes/navbar.php'); 

// Incluir el modelo de producto para obtener los estados
include_once realpath(__DIR__ . '/../../models/Producto.php');

// Obtener los estados
$estados = obtenerEstados();
?>

<div class="main-content">
  <body class="producto-page">
    <div class="form-crear">
      <h2>Crear nuevo producto</h2>

      <!-- Formulario para crear un nuevo producto -->
      <form method="POST" action="/Farmacia/controllers/ProductoController.php">
        <input type="hidden" name="accion" value="guardar">

        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <input type="number" name="precio" placeholder="Precio" required>

        <!-- Selección del estado del producto -->
        <select name="estado_id" required>
          <option value="">Selecciona el estado</option>
          <?php while ($row = oci_fetch_assoc($estados)): ?>
            <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>">
              <?= $row['DESCRIPCION'] ?>
            </option>
          <?php endwhile; ?>
        </select>

        <button type="submit">Guardar Producto</button>
      </form>
    </div>
  </body>
  <script src="/Farmacia/assets/js/script.js"></script>
</div>

<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
