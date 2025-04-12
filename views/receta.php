<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../includes/head.php';
include_once __DIR__ . '/../includes/navbar.php';

include_once __DIR__ . '/../models/Producto.php';
include_once __DIR__ . '/../models/Unidad_Dosis.php';
include_once __DIR__ . '/../models/Recetas.php';

$estados = obtenerEstados();
$productos = obtenerProductos();
$unidades = obtenerUnidadesDosis();

function obtenerRecetas() {
  $conn = oci_connect('USUARIO', 'CLAVE', 'localhost/XE');
  $sql = "SELECT r.RECETA_ID_RECETA_PK, r.ID_USUARIO, r.FECHA, e.DESCRIPCION AS ESTADO
          FROM FIDE_RECETA_TB r
          JOIN FIDE_ESTADO_TB e ON r.ID_ESTADO = e.ESTADO_ID_ESTADO_PK
          ORDER BY r.FECHA DESC";
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
  return $stmt;
}

// Mostrar recetas existentes
$recetas = obtenerRecetas();
?>

<h2>Recetas Registradas</h2>

<table border="1" cellpadding="8" cellspacing="0">
  <thead>
    <tr>
      <th>ID</th>
      <th>Usuario</th>
      <th>Fecha</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($r = oci_fetch_assoc($recetas)): ?>
      <tr>
        <td><?= $r['RECETA_ID_RECETA_PK'] ?></td>
        <td><?= $r['ID_USUARIO'] ?></td>
        <td><?= $r['FECHA'] ?></td>
        <td><?= $r['ESTADO'] ?></td>
        <td>
          <a href="/Farmacia/controllers/receta_Controller.php?accion=editar&id=<?= $r['RECETA_ID_RECETA_PK'] ?>">✏️ Editar</a>
          <a href="/Farmacia/controllers/receta_Controller.php?accion=eliminar&id=<?= $r['RECETA_ID_RECETA_PK'] ?>" onclick="return confirm('¿Eliminar esta receta?');">🗑️ Eliminar</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>


?>

<div class="main-content">
  <body class="receta-page">
    <div class="form-crear">
      <h2>Crear Nueva Receta</h2>

      <form method="POST" action="/Farmacia/controllers/receta_Controller.php">
        <input type="hidden" name="accion" value="guardar_receta">

        <!-- ID Usuario -->
        <label>ID del Usuario</label>
        <input type="number" name="id_usuario" placeholder="ID del paciente" required>

        <!-- Estado Receta -->
        <label>Estado de la receta</label>
        <select name="id_estado" required>
          <option value="">Seleccione estado</option>
          <?php while ($row = oci_fetch_assoc($estados)): ?>
            <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>"><?= $row['DESCRIPCION'] ?></option>
          <?php endwhile; ?>
        </select>

        <hr>
        <h3>Medicamentos</h3>
        <div id="detalle-receta">

          <div class="medicamento-item">
            <select name="detalle[0][id_producto]" required>
              <option value="">Producto</option>
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

            <input type="number" name="detalle[0][frecuencia_horas]" placeholder="Frecuencia (horas)">
            <input type="number" name="detalle[0][duracion]" placeholder="Duración (días)">

            <select name="detalle[0][id_estado]" required>
              <option value="">Estado</option>
              <?php
              // Vuelve a ejecutar la consulta de estados porque ya se recorrió antes
              $estados = obtenerEstados();
              while ($row = oci_fetch_assoc($estados)): ?>
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
    const contenedor = document.getElementById("detalle-receta");
    const clon = contenedor.children[0].cloneNode(true);

    clon.querySelectorAll("input, select").forEach(el => {
      el.name = el.name.replace(/\[\d+\]/, `[${contador}]`);
      if (el.tagName === 'INPUT') el.value = '';
      if (el.tagName === 'SELECT') el.selectedIndex = 0;
    });

    contenedor.appendChild(clon);
    contador++;
  }
</script>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
