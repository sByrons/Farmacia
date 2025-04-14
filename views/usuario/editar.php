<?php include_once realpath(__DIR__ . '/../../includes/head.php'); ?>
<?php include_once realpath(__DIR__ . '/../../includes/navbar.php'); ?>

<div class="main-content">
<body class="usuarios-page">

<div class="form-crear">
    <h2>Editar usuario</h2>

    <form method="POST" action="/Farmacia/controllers/usuarioController.php">
        <input type="hidden" name="accion" value="actualizar">
        <input type="hidden" name="id_usuario" value="<?= $usuario['USUARIOS_ID_USUARIO_PK'] ?>">

        <input type="text" name="nombre" placeholder="Nombre" value="<?= $usuario['NOMBRE'] ?>" required>
        <input type="text" name="apellido" placeholder="Apellido" value="<?= $usuario['APELLIDO'] ?>" required>
        <input type="text" name="cedula" placeholder="Cédula" value="<?= $usuario['CEDULA'] ?>" required>
        <input type="email" name="email" placeholder="Correo electrónico" value="<?= $usuario['EMAIL'] ?>" required>

        <select name="id_tipo" id="campo_tipo" required onchange="verificarTipoUsuario()">
            <option value="">Seleccione tipo de usuario</option>
            <?php while ($row = oci_fetch_assoc($tipos)): ?>
                <option value="<?= $row['TIPO_USUARIO_ID_TIPO_PK'] ?>" <?= ($row['TIPO_USUARIO_ID_TIPO_PK'] == $usuario['ID_TIPO']) ? 'selected' : '' ?>>
                    <?= $row['NOMBRE'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <?php
          $mostrarLogin = ($usuario['ID_TIPO'] == 1 || $usuario['ID_TIPO'] == 2);
          $styleLogin = $mostrarLogin ? '' : 'display:none;';
        ?>
        <div id="camposLogin" style="<?= $styleLogin ?>">
            <input type="text" name="usuario" id="usuario" placeholder="Nombre de usuario" value="<?= $usuario['USUARIO'] ?>">
            <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" value="<?= $usuario['CONTRASENA'] ?>">

            <select name="id_puesto" id="id_puesto">
                <option value="">Seleccione un puesto</option>
                <?php while ($row = oci_fetch_assoc($puestos)): ?>
                    <option value="<?= $row['PUESTOS_ID_PUESTO_PK'] ?>" <?= ($row['PUESTOS_ID_PUESTO_PK'] == $usuario['ID_PUESTO']) ? 'selected' : '' ?>>
                        <?= $row['NOMBRE_PUESTO'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <select name="id_estado" required>
            <option value="">Seleccione estado</option>
            <?php while ($row = oci_fetch_assoc($estados)): ?>
                <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>" <?= ($row['ESTADO_ID_ESTADO_PK'] == $usuario['ID_ESTADO']) ? 'selected' : '' ?>>
                    <?= $row['DESCRIPCION'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- Dirección -->
        <select id="provincia" name="provincia" required>
            <option value="">Provincia</option>
            <?php while ($row = oci_fetch_assoc($provincias)): ?>
                <option value="<?= $row['PROVINCIA_ID_PROVINCIA_PK'] ?>" <?= ($row['PROVINCIA_ID_PROVINCIA_PK'] == $usuario['ID_PROVINCIA']) ? 'selected' : '' ?>>
                    <?= $row['NOMBRE'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select id="canton" name="canton" required data-selected="<?= $usuario['ID_CANTON'] ?>">
            <option value="">Seleccione cantón</option>
        </select>

        <select id="distrito" name="distrito" required data-selected="<?= $usuario['ID_DISTRITO'] ?>">
            <option value="">Seleccione distrito</option>
        </select>

        <input type="text" name="direccion_exacta" placeholder="Dirección exacta" value="<?= $usuario['DIRECCION_EXACTA'] ?>" required>

        <!-- Teléfono -->
        <select name="id_tipo_telefono" required>
            <option value="">Tipo de teléfono</option>
            <?php while ($row = oci_fetch_assoc($tiposTelefono)): ?>
                <option value="<?= $row['TIPO_TELEFONO_ID_TIPO_PK'] ?>" <?= ($row['TIPO_TELEFONO_ID_TIPO_PK'] == $usuario['ID_TIPO_TELEFONO']) ? 'selected' : '' ?>>
                    <?= $row['DESCRIPCION'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="text" name="telefono" placeholder="Número de teléfono" value="<?= $usuario['TELEFONO'] ?>" required>

        <button type="submit">Actualizar Usuario</button>
    </form>
</div>
</div>

<script src="/Farmacia/assets/js/script.js"></script>
<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>



