<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 2) {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Detalle de Receta</title>
    <link rel="stylesheet" href="/Farmacia/assets/css/estilos.css">
</head>
<body class="usuarios-page">
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="/Farmacia/controllers/adminController.php">
                <img src="https://img.icons8.com/matisse/100/pharmacy-shop.png" alt="Farmacia" width="40" height="40">
                <span>Farmacia</span>
            </a>
            <ul class="navbar-links">
                <li><a href="/Farmacia/controllers/usuarioController.php">Usuarios</a></li>
                <li><a href="#">Productos</a></li>
                <li><a href="#">Facturación</a></li>
                <li><a href="#">Recetas</a></li>
                <li><a href="/Farmacia/logout.php">Cerrar sesión</a></li>
            </ul>
        </div>
    </nav>

    <!-- Formulario -->
    <div class="form-crear">
        <h2>Registrar Detalle de Receta</h2>

        <?php if (isset($_GET['exito'])): ?>
            <div class="mensaje-exito">✔️ ¡Detalle registrado correctamente!</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="mensaje-error">❌ <?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <form action="/Farmacia/controllers/detalleRecetaController.php" method="POST">
            <input type="number" name="id_receta" placeholder="ID Receta" required>
            <input type="number" name="id_producto" placeholder="ID Producto" required>
            <input type="number" name="cantidad" placeholder="Cantidad" required>
            <input type="number" name="id_unidad" placeholder="ID Unidad de Dosis" required>
            <input type="number" name="frecuencia" placeholder="Frecuencia (horas)" required>
            <input type="number" name="duracion" placeholder="Duración (días)" required>
            <input type="number" name="id_estado" placeholder="ID Estado" required>

            <button type="submit">Guardar Detalle</button>
        </form>
    </div>

    <footer class="footer">
        <p>© <?= date("Y") ?> Farmacia. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
