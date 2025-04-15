<?php include_once realpath(__DIR__ . '/../../includes/head.php'); ?>
<?php include_once realpath(__DIR__ . '/../../includes/navbar.php'); ?>
<style>
    body.receta-page {
        background-color: #f0f8ff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 85, 128, 0.2);
        margin-top: 20px;
    }

    h2 {
        color: #005580;
        margin-bottom: 20px;
    }

    .filtro-estado {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filtro-estado label {
        font-weight: bold;
        color: #003d66;
    }

    .filtro-estado select {
        padding: 5px 10px;
        border: 1px solid #005580;
        border-radius: 5px;
        background-color: #e6f2ff;
        color: #003d66;
    }

    .recetas {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .recetas th, .recetas td {
        padding: 12px;
        border: 1px solid #cce0ff;
        text-align: center;
    }

    .recetas th {
        background-color: #0077b3;
        color: white;
    }

    .recetas tr:nth-child(even) {
        background-color: #f2f9ff;
    }

    .recetas tr:hover {
        background-color: #d0ecff;
    }

    .activo {
        color: green;
        font-weight: bold;
    }

    .inactivo {
        color: red;
        font-weight: bold;
    }

    .mensaje-exito, .mensaje-error {
        padding: 10px;
        margin: 15px 0;
        border-radius: 5px;
        font-weight: bold;
    }

    .mensaje-exito {
        background-color: #d4edda;
        color: #155724;
    }

    .mensaje-error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .main-content a {
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 5px;
        font-weight: bold;
    }

    .main-content a[href*="crear"] {
        background-color: #005580;
        color: white;
    }

    .main-content a[href*="editar"] {
        color: #006699;
    }

    .main-content a[href*="eliminar"] {
        margin-left: 5px;
        color: red;
    }
</style>

<div class="main-content">
<body class="receta-page">

<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="mensaje-exito">
        <?= $_SESSION['mensaje']; ?>
    </div>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="mensaje-error">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="container">
    <h2>Recetas del Sistema</h2>
    <div style="text-align: right; margin-bottom: 10px;">
        <a href="/Farmacia/controllers/receta_Controller.php?accion=crear">+ Nueva Receta</a>
    </div>

    <form method="GET" action="/Farmacia/controllers/receta_Controller.php" class="filtro-estado">
        <label for="estado">Filtrar por estado:</label>
        <select name="estado" id="estado" onchange="this.form.submit()">
            <option value="1" <?php if ($estadoId == 1) echo 'selected'; ?>>Activo</option>
            <option value="2" <?php if ($estadoId == 2) echo 'selected'; ?>>Inactivo</option>
        </select>
    </form>

    <table class="recetas">
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Paciente / Médico</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($recetas as $row): ?>
            <tr>
                <td><?= $row['RECETA_ID_RECETA_PK']; ?></td>
                <td><?= date('d/m/Y', strtotime($row['FECHA'])); ?></td>
                <td><?= $row['USUARIO']; ?></td>
                <td class="<?= strtolower($row['ESTADO']); ?>"><?= $row['ESTADO']; ?></td>
                <td>
                    <a href="/Farmacia/controllers/receta_Controller.php?accion=editar&id=<?= $row['RECETA_ID_RECETA_PK']; ?>">✏️</a>
                    <a href="/Farmacia/controllers/receta_Controller.php?accion=eliminar&id=<?= $row['RECETA_ID_RECETA_PK']; ?>" onclick="return confirm('¿Seguro que deseas eliminar esta receta?');">🗑️</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</div>

<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
