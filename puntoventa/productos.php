<?php include('navbar.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <?php
        include 'conexion.php';

        // Modificar la consulta para que solo traiga productos activos
        $query = "SELECT id, nombre, descripcion, precio, stock FROM productos WHERE activo = 1";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<h2>Lista de Productos</h2>";
            echo "<table class='table table-bordered'>";
            echo "<thead class='table-dark'>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </tr>
                  </thead>";
            echo "<tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                echo "<td>" . htmlspecialchars($row['precio']) . "</td>";
                echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No hay productos registrados.</p>";
        }

        $conn->close();
        ?>
    </div>

    <script src="modo.js"></script>
</body>
</html>
