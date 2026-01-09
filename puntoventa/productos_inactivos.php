<?php
session_start();
if (!isset($_SESSION['empleado_nombre'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos Inactivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-4">
    <h2>Productos Inactivos</h2>
    <?php
    if (isset($_GET['msg']) && $_GET['msg'] === 'reactivado') {
    echo "<div class='alert alert-success'>✅ Producto reactivado correctamente.</div>";
}
?>

    <?php
    $sql = "SELECT id, nombre, descripcion, precio FROM productos WHERE activo = 0";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        echo "<table class='table table-bordered'>";
        echo "<thead class='table-dark'><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Acción</th></tr></thead><tbody>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['descripcion']}</td>";
            echo "<td>\${$row['precio']}</td>";
            echo "<td>
                <form action='reactivar_producto.php' method='POST' onsubmit='return confirm(\"¿Estás seguro que deseas reactivar este producto?\");'>
                    <input type='hidden' name='id_producto' value='{$row['id']}'>
                    <button type='submit' class='btn btn-success btn-sm'>Reactivar</button>
                </form>
            </td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info'>No hay productos inactivos.</div>";
    }

    $conn->close();
    ?>
</div>
<script src="modo.js"></script>
</body>
</html>
