<?php
include_once __DIR__ . '/../includes/head.php';
include_once __DIR__ . '/../includes/navbar.php';
include_once __DIR__ . '/../models/Producto.php';
include_once __DIR__ . '/../models/Unidad_Dosis.php.php';
include_once __DIR__ . '/Recetas.php';
include_once __DIR__ . '/../models/Recetas.php';
include_once __DIR__ . '/../models/Unidad_Dosis.php.php';
include_once('Recetas.php');

include_once __DIR__ . '/../models/Unidad_Dosis.php.php';





$productos = obtenerProductos();


// Obtener estados, productos y unidades
$estados = obtenerEstados();
$productos = obtenerProductos();
$unidades = obtenerUnidadesDosis();
?>


<div class="main-content">
  <body class="receta-page">
    <div class="form-crear">
      <h2>Crear nueva receta</h2>

      <form method="POST" action="/FARMACIA/controllers/receta_Controller.php">
        <input type="hidden" name="accion" value="guardar_receta">

        <!-- ID Usuario -->
        <input type="number" name="id_usuario" placeholder="ID del usuario" required>

        <!-- Estado de la receta -->
        <select name="id_estado" required>
          <option value="">Seleccione estado</option>
          <?php while ($row = oci_fetch_assoc($estados)): ?>
            <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>"><?= $row['DESCRIPCION'] ?></option>
          <?php endwhile; ?>
        </select>

        <hr>

        <h3>Detalle de Medicamentos</h3>

        <div id="detalle-medicamentos">
          <div class="detalle-item">
            <select name="detalle[0][id_producto]" required>
              <option value="">Seleccione producto</option>
              <?php while ($row = oci_fetch_assoc($productos)): ?>
                <option value="<?= $row['PRODUCTO_ID_PRODUCTO_PK'] ?>"><?= $row['NOMBRE'] ?></option>
              <?php endwhile; ?>
            </select>

            <input type="number" name="detalle[0][cantidad]" placeholder="Cantidad" required>

            <select name="detalle[0][id_unidad]" required>
              <option value="">Unidad</option>
              <?php while ($row = oci_fetch_assoc($unidades)): ?>
                <option value="<?= $row['UNIDAD_DOSIS_ID_UNIDAD_PK'] ?>"><?= $row['NOMBRE'] ?></option>
              <?php endwhile; ?>
            </select>

            <input type="number" name="detalle[0][frecuencia_horas]" placeholder="Frecuencia (hrs)">
            <input type="number" name="detalle[0][duracion]" placeholder="Duración (días)">

            <select name="detalle[0][id_estado]" required>
              <option value="">Estado</option>
              <?php while ($row = oci_fetch_assoc($estados)): ?>
                <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>"><?= $row['DESCRIPCION'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>

        <button type="button" onclick="agregarMedicamento()">+ Agregar medicamento</button>
        <br><br>
        <button type="submit">Guardar Receta</button>
      </form>
    </div>
  </body>
</div>

<script>
  let contador = 1;

  function agregarMedicamento() {
    const contenedor = document.getElementById("detalle-medicamentos");
    const nuevo = document.createElement("div");
    nuevo.className = "detalle-item";
    nuevo.innerHTML = contenedor.children[0].innerHTML.replace(/\[0\]/g, `[${contador}]`);
    contenedor.appendChild(nuevo);
    contador++;
  }
</script>

<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
