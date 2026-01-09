<?php
session_start();
include 'conexion.php';

// Verificar que la venta y el método de pago existen
if (!isset($_SESSION['venta']) || !isset($_POST['metodo_pago'])) {
    echo "Error: Venta no iniciada o método de pago no especificado.";
    exit();
}

// Obtener datos de la sesión y del formulario
$venta = $_SESSION['venta'];
$id_cliente = $venta['id_cliente'];
$productos = $venta['productos'];
$cantidades = $venta['cantidades'];
$metodo_pago = $_POST['metodo_pago'];

// Asegurar que el ID del empleado esté en sesión
if (!isset($_SESSION['empleado_id'])) {
    echo "Error: Sesión de empleado no iniciada.";
    exit();
}

$id_empleado = $_SESSION['empleado_id'];

// Calcular el total de la venta
$total = 0;
foreach ($productos as $index => $id_producto) {
    $cantidad = $cantidades[$index];
    $stmt = $conn->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if (!$producto) {
        echo "Error: Producto con ID $id_producto no encontrado.";
        exit();
    }

    $subtotal = $producto['precio'] * $cantidad;
    $total += $subtotal;
}

// Insertar la venta
$stmt = $conn->prepare("INSERT INTO ventas (id_cliente, id_empleado, fecha, total, metodo_pago) VALUES (?, ?, NOW(), ?, ?)");
$stmt->bind_param("iids", $id_cliente, $id_empleado, $total, $metodo_pago);
$stmt->execute();
$id_venta = $stmt->insert_id;

// Insertar los detalles de la venta
foreach ($productos as $index => $id_producto) {
    $cantidad = $cantidades[$index];

    // Obtener el precio unitario actual del producto
    $stmt = $conn->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    $precio = $producto['precio'];

    // Insertar en detalle_venta
    $stmt = $conn->prepare("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $id_venta, $id_producto, $cantidad, $precio);
    $stmt->execute();

    // Actualizar el stock del producto
    $stmt = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
    $stmt->bind_param("ii", $cantidad, $id_producto);
    $stmt->execute();
}

// Limpiar los datos de la venta en la sesión
unset($_SESSION['venta']);

// Redirigir al ticket
header("Location: ticket_pdf.php?id_venta=$id_venta");
exit();

?>
