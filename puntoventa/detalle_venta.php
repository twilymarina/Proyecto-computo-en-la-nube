<?php
include 'conexion.php';
include 'navbar.php';

if (!isset($_GET['id_venta'])) {{
    echo "<div class='alert alert-danger m-4'>ID de venta no especificado.</div>";
    exit();
}}

$id_venta = $_GET['id_venta'];

// Obtener venta
$stmt = $conn->prepare("SELECT v.*, c.nombre AS cliente, e.nombre AS empleado 
                        FROM ventas v 
                        JOIN clientes c ON v.id_cliente = c.id 
                        JOIN empleados e ON v.id_empleado = e.id 
                        WHERE v.id = ?");
$stmt->bind_param("i", $id_venta);
$stmt->execute();
$venta = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Detalle de la Venta #<?= $venta['id'] ?></h2>
    <div class="card p-4 shadow-sm mb-4">
        <p><strong>Cliente:</strong> <?= $venta['cliente'] ?></p>
        <p><strong>Empleado:</strong> <?= $venta['empleado'] ?></p>
        <p><strong>Fecha:</strong> <?= $venta['fecha'] ?></p>
        <p><strong>Método de Pago:</strong> <?= $venta['metodo_pago'] ?></p>
        <p><strong>Total:</strong> $<?= number_format($venta['total'], 2) ?></p>
        <a href="ticket_pdf.php?id_venta=<?= $venta['id'] ?>" target="_blank" class="btn btn-success mt-2">
            Ver Ticket PDF
        </a>
    </div>

    <h4>Productos Vendidos</h4>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $conn->prepare("SELECT d.*, p.nombre 
                                    FROM detalle_venta d 
                                    JOIN productos p ON d.id_producto = p.id 
                                    WHERE d.id_venta = ?");
            $stmt->bind_param("i", $id_venta);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
            $subtotal = $row['precio_unitario'] * $row['cantidad'];
            echo "<tr>
            <td>{$row['nombre']}</td>
            <td>$" . number_format($row['precio_unitario'], 2) . "</td>
            <td>{$row['cantidad']}</td>
            <td>$" . number_format($subtotal, 2) . "</td>
          </tr>";
}

            ?>
        </tbody>
    </table>
</div>

<script src="modo.js"></script>
</body>
</html>