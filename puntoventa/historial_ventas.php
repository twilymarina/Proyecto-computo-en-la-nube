<?php include('navbar.php'); ?>
<?php include('conexion.php'); ?>

<?php
// Verifica si la conexión fue exitosa
if (!$conn) {
    die("<div class='alert alert-danger'>Error de conexión a la base de datos.</div>");
}

// Ejecuta la consulta
$sql = "
    SELECT ventas.id, clientes.nombre AS cliente, empleados.nombre AS empleado, ventas.fecha, 
           SUM(detalle_venta.cantidad) AS cantidad_productos, 
           SUM(detalle_venta.cantidad * detalle_venta.precio_unitario) AS total_venta
    FROM ventas
    JOIN clientes ON ventas.id_cliente = clientes.id
    JOIN empleados ON ventas.id_empleado = empleados.id
    JOIN detalle_venta ON ventas.id = detalle_venta.id_venta
    GROUP BY ventas.id, clientes.nombre, empleados.nombre, ventas.fecha
";

$res = $conn->query($sql);

// Verifica si la consulta fue exitosa
if (!$res) {
    die("<div class='alert alert-danger'>Error en la consulta: " . $conn->error . "</div>");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas Registradas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-4">
    <h2>Ventas Registradas</h2>
    <?php if ($res->num_rows > 0): ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID Venta</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Empleado</th>
                <th>Cantidad de Productos</th>
                <th>Total</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $res->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['cliente']}</td>";
                echo "<td>{$row['fecha']}</td>";
                echo "<td>{$row['empleado']}</td>";
                echo "<td>{$row['cantidad_productos']}</td>";
                echo "<td>$" . number_format($row['total_venta'], 2) . "</td>";
                echo "<td><a href='detalle_venta.php?id_venta={$row['id']}' class='btn btn-info btn-sm'>Ver</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="alert alert-warning">No hay ventas registradas.</div>
    <?php endif; ?>
</div>

<script src="modo.js"></script>
</body>
</html>
