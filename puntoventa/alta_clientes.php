<?php
include('navbar.php');
include('conexion.php'); // Asegúrate de que esté incluido

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $email = $_POST['email'];

    if (!empty($nombre) && !empty($contacto) && !empty($email)) {
        $query = "INSERT INTO clientes (nombre, contacto, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $nombre, $contacto, $email);
        
        if ($stmt->execute()) {
            $id_nuevo = $stmt->insert_id;
            $mensaje = "Cliente registrado con éxito. ID asignado: <strong>$id_nuevo</strong>";
        } else {
            $mensaje = "Error al registrar el cliente. Intente nuevamente.";
        }
        $stmt->close();
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Registrar Cliente</h2>

        <?php if (!empty($mensaje)) : ?>
            <div class="alert alert-info"><?= $mensaje ?></div>
        <?php endif; ?>

        <form action="alta_clientes.php" method="POST" class="p-4 rounded shadow" 
      style="background-image: url('936036e656d3c38982b56ff75b3a4f9b.png'); background-size: cover; background-position: center; color: white; backdrop-filter: brightness(0.8);">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Introduce el nombre del cliente" required>
            </div>

            <div class="mb-3">
                <label for="contacto" class="form-label">Contacto:</label>
                <input type="text" name="contacto" id="contacto" class="form-control" placeholder="Introduce un numero telefonico" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Ingresa un correo electronico" required>
            </div>

            <button type="submit" class="btn btn-success">Registrar</button>
        </form>
    </div>

    <script src="modo.js"></script>
</body>
</html>
