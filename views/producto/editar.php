<!-- editar.php -->
<?php
// Incluir la clase Producto
require_once __DIR__ . '/../models/Producto.php';

$productId = $_GET['id'] ?? null;

if (!$productId) {
    echo "Producto no encontrado.";
    exit;
}

// Consultar el producto existente
$product = Producto::consultarProducto($productId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $estado_id = $_POST['estado_id'];
    
    // Llamar al procedimiento de actualización
    Producto::actualizarProducto($productId, $nombre, $descripcion, $precio, $estado_id);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>

    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $product['nombre']; ?>" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion"><?php echo $product['descripcion']; ?></textarea><br>

        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" value="<?php echo $product['precio']; ?>" required><br>

        <label for="estado_id">Estado:</label>
        <select name="estado_id" id="estado_id" required>
            <option value="1" <?php echo $product['estado_id'] == 1 ? 'selected' : ''; ?>>Activo</option>
            <option value="2" <?php echo $product['estado_id'] == 2 ? 'selected' : ''; ?>>Inactivo</option>
        </select><br>

        <button type="submit">Actualizar Producto</button>
    </form>
</body>
</html>
