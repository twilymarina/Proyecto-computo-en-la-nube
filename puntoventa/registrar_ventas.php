<?php include('navbar.php'); ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'];
    $productos = $_POST['productos'];
    $cantidades = $_POST['cantidades'];

    $_SESSION['venta'] = [
        'id_cliente' => $id_cliente,
        'productos' => $productos,
        'cantidades' => $cantidades
    ];

    header("Location: confirmar_venta.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap + Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <h2>Registrar Venta</h2>

    <form method="POST" action="registrar_ventas.php" class="p-4 rounded shadow"
          style="background-image: url('936036e656d3c38982b56ff75b3a4f9b.png'); background-size: cover; background-position: center; color: white; backdrop-filter: brightness(0.8);">

        <div class="mb-3">
            <label for="id_cliente" class="form-label">ID del Cliente</label>
            <input type="number" name="id_cliente" id="id_cliente" class="form-control" required>
        </div>

        <h4 class="mt-4">Productos a vender</h4>
        <div id="productosContainer">
            <div class="row g-3 mb-3 producto">
                <div class="col-md-6">
                    <label class="form-label">ID Producto</label>
                    <input type="number" name="productos[]" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidades[]" class="form-control" required min="1">
                </div>
            </div>
        </div>

        <button type="button" onclick="agregarProducto()" class="btn btn-light text-dark mb-3">Agregar otro producto</button><br>

        <input type="submit" value="Continuar" class="btn btn-primary">
    </form>
</div>

<script>
function agregarProducto() {
    const container = document.getElementById("productosContainer");

    const row = document.createElement("div");
    row.classList.add("row", "g-3", "mb-3", "producto");

    row.innerHTML = `
        <div class="col-md-6">
            <label class="form-label">ID Producto</label>
            <input type="number" name="productos[]" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidades[]" class="form-control" required min="1">
        </div>
    `;

    container.appendChild(row);
}
</script>

<script src="modo.js"></script>

</body>
</html>
