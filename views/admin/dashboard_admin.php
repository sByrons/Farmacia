<?php include_once realpath(__DIR__ . '/../../includes/head.php'); ?>
<?php include_once realpath(__DIR__ . '/../../includes/navbar.php'); ?>

<div class="main-content">
<body class="usuarios-page">

<h1>Panel de Control - Administrador</h1>

<div class="dashboard-container">
  <div class="dashboard-card">
    <h3>Usuarios activos</h3>
    <p><?= $usuariosActivos ?></p>
    <a href="../controllers/usuarioController.php">Ver usuarios</a>
  </div>

  <div class="dashboard-card">
    <h3>Productos registrados</h3>
    <p><?= $productosTotales ?></p>
    <a href="#">Ver productos</a>
  </div>

  <div class="dashboard-card">
    <h3>Facturas del día</h3>
    <p><?= $facturasHoy ?></p>
    <a href="#">Ver facturación</a>
  </div>

  <div class="dashboard-card">
    <h3>Proveedores</h3>
    <p><?= $proveedores ?></p>
    <a href="#">Ver proveedores</a>
  </div>
</div>

</div>
<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
