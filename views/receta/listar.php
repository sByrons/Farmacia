<?php 
include_once realpath(__DIR__ . '/../../includes/head.php'); 
include_once realpath(__DIR__ . '/../../includes/navbar.php'); 

// Obtenemos el estado seleccionado del filtro
$estadoId = $_GET['estado'] ?? 1;  // Default es 1 (Activo)

// Llamamos al modelo para obtener las recetas basadas en el estado
include_once __DIR__ . '/../../models/Recetas.php';
$recetas = obtenerRecetasPorEstado($estadoId);
?>

<style>
    body.recetas-page {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
    }

    .main-content {
        margin: 20px;
    }

    .container {
        max-width: 1000px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .filtro-estado {
        margin-bottom: 20px;
    }

    .filtro-estado label {
        font-size: 16px;
        margin-right: 10px;
    }

    .filtro-estado select {
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .recetas {
        width: 100%;
        border-collapse: collapse;
    }

    .recetas th, .recetas td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .recetas th {
        background-color: #f5f5f5;
    }

    .recetas td a {
        text-decoration: none;
        color: #007bff;
        margin-right: 10px;
    }

    .recetas td a:hover {
        text-decoration: underline;
    }

    .mensaje-exito, .mensaje-error {
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        font-size: 16px;
    }

    .mensaje-exito {
        background-color: #28a745;
        color: white;
    }

    .mensaje-error {
        background-color: #dc3545;
        color: white;
    }

    .recetas td.acciones a {
        font-size: 18px;
    }

    .recetas td.acciones a:hover {
        color: #0056b3;
    }

    .mensaje-exito {
        background-color: #28a745;
        color: white;
    }

    .mensaje-error {
        background-color: #dc3545;
        color: white;
    }
</style>

<div class="main-content">
    <body class="recetas-page">
        <a href="/Farmacia/controllers/receta_Controller.php?accion=crear">Nueva Receta</a>

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

            <form method="GET" action="" class="filtro-estado">
                <label for="estado">Filtrar por estado:</label>
                <select name="estado" id="estado" onchange="this.form.submit()">
                    <option value="1" <?php if ($estadoId == 1) echo 'selected'; ?>>Activo</option>
                    <option value="2" <?php if ($estadoId == 2) echo 'selected'; ?>>Inactivo</option>
                </select>
            </form>

            <table class="recetas">
                <tr>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>

                <?php if (!empty($recetas)): ?>
                    <?php foreach ($recetas as $row): ?>
                        <tr>
                            <td><?php echo date("d/m/Y", strtotime($row['FECHA'])); ?></td>
                            <td><?php echo $row['USUARIO']; ?></td>
                            <td class="<?php echo strtolower($row['ESTADO']); ?>"><?php echo $row['ESTADO']; ?></td>
                            <td class="acciones">
                                <a href="/Farmacia/controllers/receta_Controller.php?accion=editar&id=<?php echo $row['RECETA_ID_RECETA_PK']; ?>">✏</a>
                                <?php if (strtolower($row['ESTADO']) == 'activo'): ?>
                                    <a href="/Farmacia/controllers/receta_Controller.php?accion=desactivar&id=<?php echo $row['RECETA_ID_RECETA_PK']; ?>" onclick="return confirm('¿Seguro que deseas desactivar esta receta?');">🛑</a>
                                <?php else: ?>
                                    <a href="/Farmacia/controllers/receta_Controller.php?accion=activar&id=<?php echo $row['RECETA_ID_RECETA_PK']; ?>" onclick="return confirm('¿Activar esta receta?');">✅</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No se encontraron recetas.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </body>
</div>

<?php include_once realpath(__DIR__ . '/../../includes/footer.php'); ?>
