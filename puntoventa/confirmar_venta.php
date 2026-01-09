<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'navbar.php';
include 'conexion.php';

if (!isset($_SESSION['venta'])) {
    echo "<div class='alert alert-warning text-center mt-5'>No hay venta en proceso.</div>";
    exit();
}

$venta = $_SESSION['venta'];
$productos = $venta['productos'];
$cantidades = $venta['cantidades'];
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Venta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <h2>Confirmar Venta</h2>

    <form method="POST" action="finalizar_venta.php" class="p-4 rounded shadow"
          style="background-image: url('936036e656d3c38982b56ff75b3a4f9b.png'); background-size: cover; background-position: center; color: white; backdrop-filter: brightness(0.8);">

        <table class="table table-bordered table-striped bg-light text-dark">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($productos as $index => $id_producto) {
                    $cantidad = $cantidades[$index];
                    $stmt = $conn->prepare("SELECT nombre, precio FROM productos WHERE id = ?");
                    $stmt->bind_param("i", $id_producto);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $producto = $result->fetch_assoc();

                    if ($producto) {
                        $subtotal = $producto['precio'] * $cantidad;
                        $total += $subtotal;

                        echo "<tr>
                                <td>{$producto['nombre']}</td>
                                <td>\${$producto['precio']}</td>
                                <td>{$cantidad}</td>
                                <td>\$" . number_format($subtotal, 2) . "</td>
                              </tr>";
                    } else {
                        echo "<tr><td colspan='4'>Producto con ID $id_producto no encontrado.</td></tr>";
                    }
                }
                ?>
                <tr class="table-secondary">
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td><strong>$<?= number_format($total, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div class="mb-3">
            <label class="form-label">Método de pago:</label>
            <select name="metodo_pago" class="form-select" required>
                <option value="EFECTIVO">Efectivo</option>
                <option value="TARJETA">Tarjeta</option>
                <option value="TRANSFERENCIA">Transferencia</option>
            </select>
        </div>

        <div class="text-center mt-3">
            <input type="submit" value="Finalizar Venta" class="btn btn-success">
        </div>
    </form>
</div>

<script src="modo.js"></script>
</body>
</html>
