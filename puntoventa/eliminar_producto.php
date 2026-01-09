<?php
include 'conexion.php';
?>
<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Desactivar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Actualizar el estado del producto a inactivo
    $stmt = $conn->prepare("UPDATE productos SET activo = 0 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo "<div class='alert alert-success text-center'>✅ El producto ha sido desactivado correctamente.</div>";
    echo "<div class='text-center'><a href='inventario.php' class='btn btn-primary'>Volver al inventario</a></div>";
} else {
    echo "<div class='alert alert-danger text-center'>❌ ID no especificado.</div>";
    echo "<div class='text-center'><a href='inventario.php' class='btn btn-primary'>Volver al inventario</a></div>";
}
?>

</div>
<script src="modo.js"></script>
</body>
</html>
