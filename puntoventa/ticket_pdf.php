<?php
require('fpdf/fpdf.php');
include 'conexion.php';

if (!isset($_GET['id_venta'])) {
    die('Error: ID de venta no especificado.');
}

$id_venta = intval($_GET['id_venta']);

// Obtener datos de la venta
$venta_sql = "SELECT v.*, c.nombre AS cliente, e.nombre AS empleado 
              FROM ventas v
              JOIN clientes c ON v.id_cliente = c.id
              JOIN empleados e ON v.id_empleado = e.id
              WHERE v.id = $id_venta";
$venta_result = $conn->query($venta_sql);
$venta = $venta_result->fetch_assoc();

if (!$venta) {
    die("Venta no encontrada.");
}

// Obtener productos vendidos
$detalles_sql = "SELECT dv.*, p.nombre 
                 FROM detalle_venta dv
                 JOIN productos p ON dv.id_producto = p.id
                 WHERE dv.id_venta = $id_venta";
$detalles_result = $conn->query($detalles_sql);

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Encabezado
$pdf->Cell(0, 10, 'Ticket de Venta', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Cliente: ' . $venta['cliente'], 0, 1);
$pdf->Cell(0, 10, 'Empleado: ' . $venta['empleado'], 0, 1);
$pdf->Cell(0, 10, 'Fecha: ' . $venta['fecha'], 0, 1);
$pdf->Ln(5);

// Tabla de productos
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Cantidad', 1);
$pdf->Cell(40, 10, 'Precio Unit.', 1);
$pdf->Cell(40, 10, 'Subtotal', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
$total = 0;
while ($fila = $detalles_result->fetch_assoc()) {
    $subtotal = $fila['cantidad'] * $fila['precio_unitario'];
    $total += $subtotal;
    $pdf->Cell(80, 10, $fila['nombre'], 1);
    $pdf->Cell(30, 10, $fila['cantidad'], 1);
    $pdf->Cell(40, 10, '$' . number_format($fila['precio_unitario'], 2), 1);
    $pdf->Cell(40, 10, '$' . number_format($subtotal, 2), 1);
    $pdf->Ln();
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Total: $' . number_format($total, 2), 0, 1, 'R');

// Mostrar el PDF en el navegador
$pdf->Output('I', 'ticket_venta.pdf');
?>
