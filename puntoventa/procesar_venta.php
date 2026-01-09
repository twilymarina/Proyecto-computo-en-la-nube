<?php
session_start();
if (!isset($_SESSION['empleado_id']) || !isset($_SESSION['venta_temporal'])) {
    header("Location: registrar_ventas.php");
    exit();
}

include 'conexion.php';

$venta = $_SESSION['venta_temporal'];
$id_cliente = $venta['id_cliente'];
$productos = $venta['productos'];
$cantidades = $venta['cantidades'];

// Obtener nombre del cliente
$cliente = $conn->prepare("SELECT nombre FROM clientes WHERE id = ?");
$cliente->bind_param("i", $id_cliente);
$cliente->execute();
$res = $cliente->get_result();
$nombre_cliente = $res->fetch_assoc()['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Procesar Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('navbar.php'); ?>
<div class="container mt-4">
    <h2>Confirmar Venta</h2>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($nombre_cliente) ?></p>

    <form action="finalizar_venta.php" method="POST">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            foreach ($productos as $id_producto => $valor) {
                $stmt = $conn->prepare("SELECT nombre, precio FROM productos WHERE id = ?");
                $stmt->bind_param("i", $id_producto);
                $stmt->execute();
                $res = $stmt->get_result()->fetch_assoc();

                $nombre = $res['nombre'];
                $precio = $res['precio'];
                $cantidad = $cantidades[$id_producto];
                $subtotal = $precio * $cantidad;
                $total += $subtotal;

                echo "<tr>
                        <td>" . htmlspecialchars($nombre) . "</td>
                        <td>$$precio</td>
                        <td>$cantidad</td>
                        <td>$" . number_format($subtotal, 2) . "</td>
                    </tr>";
            }
            ?>
            </tbody>
        </table>

        <div class="mb-3">
            <label for="metodo_pago" class="form-label">Método de Pago:</label>
            <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Transferencia">Transferencia</option>
            </select>
        </div>

        <h4>Total: $<?= number_format($total, 2) ?></h4>

        <button type="submit" class="btn btn-success">Confirmar y Generar Ticket</button>
    </form>
</div>
</body>
</html>
