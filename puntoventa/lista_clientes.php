<?php
include 'conexion.php';

$query = "SELECT * FROM clientes";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>Lista de Clientes</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Email</th>
            </tr>";


    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['nombre'] . "</td>
                <td>" . $row['contacto'] . "</td>
                <td>" . $row['email'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron clientes.";
}
?>
