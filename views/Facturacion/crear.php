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

// Variables para la factura
$totalFactura = 0;
$iva = 0;
$descuento = 0;
?>

<div class="main-content">
  <body class="factura-page">
    <div class="form-factura">
      <h2>Crear nueva factura</h2>
    
      <form method="POST" action="/controllers/FacturacionController.php" id="factura-form">
        <input type="hidden" name="accion" value="guardar">
        <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">

        <!-- FECHA DE LA FACTURA -->
        <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" required>

        <!-- ESTADO DE LA FACTURA -->
        <select name="id_estado_factura" required>
          <option value="">Selecciona el estado de la factura</option>
          <?php while ($row = oci_fetch_assoc($estados)): ?>
            <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>">
              <?= $row['DESCRIPCION'] ?>
            </option>
          <?php endwhile; ?>
        </select>

        <hr>
        <h3>Detalles de la factura</h3>

        <!-- PRODUCTO -->
        <div id="producto-section">
          <div class="detalle-item">
            <select name="id_producto[]" required class="producto-select">
              <option value="">Selecciona un producto</option>
              <?php while ($row = oci_fetch_assoc($productos)): ?>
                <option value="<?= $row['PRODUCTO_ID_PRODUCTO_PK'] ?>" data-precio="<?= $row['PRECIO_UNITARIO'] ?>">
                  <?= $row['NOMBRE'] ?>
                </option>
              <?php endwhile; ?>
            </select>

            <input type="number" name="cantidad[]" placeholder="Cantidad" required class="cantidad-input" oninput="calcularTotal()">
            <input type="number" name="precio[]" placeholder="Precio Unitario" required class="precio-input" readonly>

            <!-- Unidad de Dosis -->
            <select name="id_unidad[]" required class="unidad-select">
              <option value="">Unidad de dosis</option>
              <?php while ($row = oci_fetch_assoc($unidades)): ?>
                <option value="<?= $row['UNIDAD_DOSIS_ID_UNIDAD_PK'] ?>">
                  <?= $row['NOMBRE'] ?>
                </option>
              <?php endwhile; ?>
            </select>

            <button type="button" class="remove-item-btn" onclick="removeItem(this)">Eliminar</button>
          </div>
        </div>

        <button type="button" onclick="addProduct()">Agregar Producto</button>

        <hr>

        <h3>Resumen de la factura</h3>
        <p>Total: <span id="total-importe">0.00</span></p>
        <p>IVA (13%): <span id="total-iva">0.00</span></p>
        <p>Descuento: <span id="total-descuento">0.00</span></p>
        <p><strong>Total a pagar: <span id="total-pagar">0.00</span></strong></p>

        <button type="submit" id="guardar-factura-btn">Guardar Factura</button>
      </form>
    </div>
  </body>

  <script>
    function calcularTotal() {
      let total = 0;
      let iva = 0;
      let descuento = 0;
      
      // Calcula el total por cada producto
      document.querySelectorAll('.detalle-item').forEach(function(item) {
        let cantidad = item.querySelector('.cantidad-input').value;
        let precio = item.querySelector('.precio-input').value;
        
        // Calculando el subtotal para este producto
        let subtotal = cantidad * precio;
        total += subtotal;
      });

      // Calculando IVA y Descuento (en este caso un ejemplo simple)
      iva = total * 0.13;  // 13% IVA
      descuento = total * 0.05;  // 5% Descuento de ejemplo

      // Mostrar el total calculado
      document.getElementById('total-importe').textContent = total.toFixed(2);
      document.getElementById('total-iva').textContent = iva.toFixed(2);
      document.getElementById('total-descuento').textContent = descuento.toFixed(2);
      document.getElementById('total-pagar').textContent = (total + iva - descuento).toFixed(2);
    }

    function addProduct() {
      const productoSection = document.getElementById('producto-section');
      const newItem = document.createElement('div');
      newItem.classList.add('detalle-item');
      newItem.innerHTML = `
        <select name="id_producto[]" required class="producto-select">
          <option value="">Selecciona un producto</option>
          <?php while ($row = oci_fetch_assoc($productos)): ?>
            <option value="<?= $row['PRODUCTO_ID_PRODUCTO_PK'] ?>" data-precio="<?= $row['PRECIO_UNITARIO'] ?>">
              <?= $row['NOMBRE'] ?>
            </option>
          <?php endwhile; ?>
        </select>

        <input type="number" name="cantidad[]" placeholder="Cantidad" required class="cantidad-input" oninput="calcularTotal()">
        <input type="number" name="precio[]" placeholder="Precio Unitario" required class="precio-input" readonly>

        <select name="id_unidad[]" required class="unidad-select">
          <option value="">Unidad de dosis</option>
          <?php while ($row = oci_fetch_assoc($unidades)): ?>
            <option value="<?= $row['UNIDAD_DOSIS_ID_UNIDAD_PK'] ?>">
              <?= $row['NOMBRE'] ?>
            </option>
          <?php endwhile; ?>
        </select>

        <button type="button" class="remove-item-btn" onclick="removeItem(this)">Eliminar</button>
      `;
      productoSection.appendChild(newItem);
    }

    function removeItem(button) {
      button.closest('.detalle-item').remove();
      calcularTotal(); // Recalcular el total cuando se elimina un item
    }

    document.querySelectorAll('.producto-select').forEach(function(select) {
      select.addEventListener('change', function() {
        let precio = this.selectedOptions[0].getAttribute('data-precio');
        this.closest('.detalle-item').querySelector('.precio-input').value = precio;
        calcularTotal();
      });
    });

    calcularTotal(); // Inicializar el cálculo al cargar
  </script>
</div>

<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
