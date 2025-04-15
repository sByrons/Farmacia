<?php include_once realpath(__DIR__ . '/../../includes/head.php'); ?>
<?php include_once realpath(__DIR__ . '/../../includes/navbar.php'); ?>

<div class="main-content">
  <body class="usuarios-page">
    <div class="form-crear">
      <h2>Crear nuevo usuario</h2>

      <form method="POST" action="/Farmacia/controllers/usuarioController.php">
        <input type="hidden" name="accion" value="guardar">

        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="text" name="cedula" placeholder="Cédula" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>

        <select name="id_tipo" id="id_tipo" required onchange="verificarTipoUsuario()">
          <option value="">Tipo de usuario</option>
          <?php while ($row = oci_fetch_assoc($tipos)): ?>
            <option value="<?= $row['TIPO_USUARIO_ID_TIPO_PK'] ?>">
              <?= $row['NOMBRE'] ?>
            </option>
          <?php endwhile; ?>
        </select>

        <div id="camposLogin" style="display: none;">
          <input type="text" name="usuario" id="usuario" placeholder="Nombre de usuario">
          <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña">

          <select name="id_puesto" id="id_puesto">
            <option value="">Puesto</option>
            <?php while ($row = oci_fetch_assoc($puestos)): ?>
              <option value="<?= $row['PUESTOS_ID_PUESTO_PK'] ?>">
                <?= $row['NOMBRE_PUESTO'] ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <select id="provincia" name="provincia" required>
          <option value="">Provincia</option>
          <?php while ($row = oci_fetch_assoc($provincias)): ?>
            <option value="<?= $row['PROVINCIA_ID_PROVINCIA_PK'] ?>"><?= $row['NOMBRE'] ?></option>
          <?php endwhile; ?>
        </select>

        <select id="canton" name="canton" required>
          <option value="">Cantón</option>
        </select>

        <select id="distrito" name="distrito" required>
          <option value="">Distrito</option>
        </select>

        <input type="text" name="direccion_exacta" placeholder="Dirección exacta" required>

        <select name="id_tipo_telefono" required>
    <option value="">Tipo de teléfono</option>
    <?php while ($row = oci_fetch_assoc($tiposTelefono)): ?>
        <option value="<?= $row['TIPO_TELEFONO_ID_TIPO_PK'] ?>">
            <?= $row['DESCRIPCION'] ?>
        </option>
    <?php endwhile; ?>
</select>

<input type="text" name="telefono" placeholder="Número de teléfono" required>


        
        <select name="id_estado" required>
          <option value="">Estado</option>
          <?php while ($row = oci_fetch_assoc($estados)): ?>
            <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>">
              <?= $row['DESCRIPCION'] ?>
            </option>
          <?php endwhile; ?>
        </select>

        <button type="submit">Guardar Usuario</button>
      </form>
    </div>
    <script src="/Farmacia/assets/js/script.js"></script>
</div>
<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>




