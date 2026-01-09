<?php include('navbar.php'); ?>

<?php
include 'conexion.php';
$mensaje = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT nombre, descripcion, precio, stock FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nombre, $descripcion, $precio, $stock);
    $stmt->fetch();
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    if (!empty($nombre) && !empty($descripcion) && is_numeric($precio) && is_numeric($stock)) {
        $stmt = $conn->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=? WHERE id=?");
        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $id);

        if ($stmt->execute()) {
            $mensaje = "✅ Producto actualizado correctamente.";
        } else {
            $mensaje = "❌ Error al actualizar el producto.";
        }
        $stmt->close();
    } else {
        $mensaje = "⚠️ Todos los campos son obligatorios y deben ser válidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <h2>Editar Producto</h2>

    <?php if (!empty($mensaje)) echo "<div class='alert alert-info'>$mensaje</div>"; ?>

    <form action="editar_producto.php" method="POST" class="p-4 rounded shadow"
        style="background-image: url('936036e656d3c38982b56ff75b3a4f9b.png'); background-size: cover; background-position: center; color: white; backdrop-filter: brightness(0.8);">
        
        <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del producto</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($nombre ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?= htmlspecialchars($descripcion ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="<?= htmlspecialchars($precio ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="<?= htmlspecialchars($stock ?? '') ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar producto</button>
    </form>
</div>

<script src="modo.js"></script>

</body>
</html>
