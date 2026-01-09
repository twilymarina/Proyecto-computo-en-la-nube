<?php include('navbar.php'); ?>

<?php
include 'conexion.php';
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    if (!empty($nombre) && !empty($descripcion) && is_numeric($precio) && is_numeric($stock)) {
        $query = "INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $stock);  // s = string, d = double, i = integer

        if ($stmt->execute()) {
            $id_nuevo = $stmt->insert_id;
            $mensaje = "✅ Producto registrado con éxito. ID asignado: <strong>$id_nuevo</strong>";
        } else {
            $mensaje = "❌ Error al registrar el producto. Intente nuevamente.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <h2>Alta de productos</h2>

    <?php if (!empty($mensaje)) echo "<div class='alert alert-info'>$mensaje</div>"; ?>

    <form action="alta_productos.php" method="POST" class="p-4 rounded shadow" 
      style="background-image: url('936036e656d3c38982b56ff75b3a4f9b.png'); background-size: cover; background-position: center; color: white; backdrop-filter: brightness(0.8);">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del producto</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del producto" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del producto" required>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" id="precio" class="form-control" placeholder="Precio del producto" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" placeholder="Cantidad de producto disponible" required>
        </div>

        <input type="submit" value="Registrar producto" class="btn btn-primary">
    </form>
</div>

<script src="modo.js"></script>

</body>
</html>
