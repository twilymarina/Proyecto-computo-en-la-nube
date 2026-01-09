<?php include('navbar.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Panel Principal</h2>
        <form action="index.php" method="POST" class="p-4 rounded shadow" 
      style="background-image: url('936036e656d3c38982b56ff75b3a4f9b.png'); background-size: cover; background-position: center; color: white; backdrop-filter: brightness(0.8);">
        <div class="d-flex justify-content-center mt-3">
            <div class="d-grid gap-2 d-md-block">
            <a href="alta_productos.php" class="btn btn-primary m-1">Alta de Productos</a>
            <a href="inventario.php" class="btn btn-primary m-1">Inventario</a>
            <a href="alta_clientes.php" class="btn btn-primary m-1">Registrar Clientes</a>
            <a href="registrar_ventas.php" class="btn btn-primary m-1">Registrar Venta</a>
             <a href="historial_ventas.php" class="btn btn-primary m-1">Historial de Ventas</a>
             </div>
        </div>
    </div>

    <script src="modo.js"></script>
</body>
</html>
