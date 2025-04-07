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
        
        <input type="text" name="usuario" placeholder="Nombre de usuario" value="<?= $usuario['USUARIO'] ?>" id="campo_usuario">
        <input type="password" name="contrasena" placeholder="Contraseña" value="<?= $usuario['CONTRASENA'] ?>" id="campo_contrasena">
        <input type="email" name="email" placeholder="Correo electrónico" value="<?= $usuario['EMAIL'] ?>">

        <select name="id_puesto" id="campo_puesto">
            <option value="">Seleccione un puesto</option>
            <?php while ($row = oci_fetch_assoc($puestos)): ?>
                <option value="<?= $row['PUESTOS_ID_PUESTO_PK'] ?>" <?= ($row['PUESTOS_ID_PUESTO_PK'] == $usuario['ID_PUESTO']) ? 'selected' : '' ?>>
                    <?= $row['NOMBRE_PUESTO'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select name="id_tipo" id="campo_tipo" required onchange="mostrarOcultarCampos()">
            <option value="">Seleccione tipo de usuario</option>
            <?php while ($row = oci_fetch_assoc($tipos)): ?>
                <option value="<?= $row['TIPO_USUARIO_ID_TIPO_PK'] ?>" <?= ($row['TIPO_USUARIO_ID_TIPO_PK'] == $usuario['ID_TIPO']) ? 'selected' : '' ?>>
                    <?= $row['NOMBRE'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select name="id_estado" required>
            <option value="">Seleccione estado</option>
            <?php while ($row = oci_fetch_assoc($estados)): ?>
                <option value="<?= $row['ESTADO_ID_ESTADO_PK'] ?>" <?= ($row['ESTADO_ID_ESTADO_PK'] == $usuario['ID_ESTADO']) ? 'selected' : '' ?>>
                    <?= $row['DESCRIPCION'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Actualizar Usuario</button>
    </form>
</div>
</div>
<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
