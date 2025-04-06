<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" href="/Farmacia/assets/css/estilos.css">

</head>
<body class="usuarios-page">

<div class="container">
    <h2>Usuarios del Sistema</h2>
    <div style="text-align: right; margin-bottom: 10px;">
    <a href="../../views/usuarios/crear.php" style="background-color: #005580; color: white; padding: 10px 15px; border-radius: 6px; text-decoration: none;">+ Nuevo Usuario</a>
    </div>
    <form method="GET" action="../../controllers/usuarioController.php" class="filtro-estado">
        <label for="estado">Filtrar por estado:</label>
        <select name="estado" id="estado" onchange="this.form.submit()">
            <option value="1" <?php if ($estadoId == 1) echo 'selected'; ?>>Activo</option>
            <option value="2" <?php if ($estadoId == 2) echo 'selected'; ?>>Inactivo</option>
        </select>
    </form>

    <table class="usuarios">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Puesto</th>
            <th>Tipo de usuario</th>
            <th>Estado</th>
            <th>Acciones</th>

        </tr>

        <?php while ($row = oci_fetch_assoc($usuarios)): ?>
            <tr>
                <td><?php echo $row['USUARIOS_ID_USUARIO_PK']; ?></td>
                <td><?php echo $row['NOMBRE']; ?></td>
                <td><?php echo $row['APELLIDO']; ?></td>
                <td><?php echo $row['USUARIO']; ?></td>
                <td><?php echo $row['EMAIL']; ?></td>
                <td><?php echo $row['NOMBRE_PUESTO']; ?></td>
                <td><?php echo $row['TIPO_USUARIO']; ?></td>
                <td class="<?php echo strtolower($row['ESTADO']); ?>"><?php echo $row['ESTADO']; ?></td>
                <td><a href="../../views/usuarios/editar.php?id=<?php echo $row['USUARIOS_ID_USUARIO_PK']; ?>">✏️</a>
                    <?php if (strtolower($row['ESTADO']) == 'activo'): ?>
                    <a href="../../controllers/usuarioController.php?accion=desactivar&id=<?php echo $row['USUARIOS_ID_USUARIO_PK']; ?>" onclick="return confirm('¿Seguro que deseas desactivar este usuario?');">🛑</a>
                     <?php else: ?>
                    <a href="../../controllers/usuarioController.php?accion=activar&id=<?php echo $row['USUARIOS_ID_USUARIO_PK']; ?>" onclick="return confirm('¿Activar este usuario?');">✅</a>
                    <?php endif; ?>
                </td>

            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>

