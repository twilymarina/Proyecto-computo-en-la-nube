<?php
include('navbar.php');
include('conexion.php');

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $rol = trim($_POST['rol']);
    $password = $_POST['password'];

    if (empty($nombre) || empty($rol) || empty($password)) {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO empleados (nombre, rol, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $nombre, $rol, $passwordHashed);

        if ($stmt->execute()) {
            $mensaje = "Empleado registrado exitosamente. <a href='login.php'>Iniciar sesión</a>";
        } else {
            $mensaje = "Error al registrar empleado. " . mysqli_error($conn);
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Registro de Empleados</h2>

        <?php if (!empty($mensaje)) : ?>
            <div class="alert alert-info"><?= $mensaje ?></div>
        <?php endif; ?>
        <form action="registro.php" method="POST" class="p-4 rounded shadow" 
      style="background-image: url('936036e656d3c38982b56ff75b3a4f9b.png'); background-size: cover; background-position: center; color: white; backdrop-filter: brightness(0.8);">
        <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Introduce tu Nombre" required>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <input type="text" name="rol" id="rol" class="form-control" placeholder="Introduce tu cargo" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Introduce tu contraseña" required>
            </div>
            <button type="submit" class="btn btn-success">Registrar Empleado</button>
        </form>
    </div>

    <script src="modo.js"></script>
</body>
</html>
