<?php
session_start(); // Obligatorio para trabajar con $_SESSION
include 'conexion.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM empleados WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['empleado_nombre'] = $row['nombre'];
            $_SESSION['empleado_id'] = $row['id'];

            header("Location: index.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Empleado no encontrado.";
    }
}
?>

<?php include('navbar.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Iniciar sesión (Empleados)</h2>

        <?php if (!empty($mensaje)) : ?>
            <div class="alert alert-danger"><?= $mensaje ?></div>
        <?php endif; ?>
<form action="login.php" method="POST" class="p-4 rounded shadow" 
      style="background-image: url('936036e656d3c38982b56ff75b3a4f9b.png'); background-size: cover; background-position: center; color: white; backdrop-filter: brightness(0.8);">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Introduce tu nombre" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Introduce tu contraseña" required>
            </div>

            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>

    <script src="modo.js"></script>
</body>
</html>
