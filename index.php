<?php include_once realpath(__DIR__ . '/includes/head.php'); ?>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="controllers/loginController.php" method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>

        <?php if (isset($_GET['error'])): ?>
            <p class="error">Credenciales inválidas</p>
        <?php endif; ?>
    </div>
    <?php include_once realpath(__DIR__ . '/includes/footer.php'); ?>

