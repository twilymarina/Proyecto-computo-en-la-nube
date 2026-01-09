<?php
session_start();
if (!isset($_SESSION['empleado_nombre'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id = (int)$_POST['id_producto'];

    $stmt = $conn->prepare("UPDATE productos SET activo = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: productos_inactivos.php?msg=reactivado");
        exit();
    } else {
        echo "Error al reactivar el producto.";
    }
}
?>
