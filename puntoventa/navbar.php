<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Inicio</a>
        <div class="d-flex align-items-center">
            <div class="nav-links d-flex">
            <?php if (isset($_SESSION['empleado_nombre'])): ?>
                <span class="navbar-text text-light">¡Hola, <?= $_SESSION['empleado_nombre']; ?>!</span>
                    <a class="nav-link text-light" href="logout.php">Cerrar sesión</a>
                <?php else: ?>
                    <a class="nav-link text-light" href="login.php">Inicio de Sesión</a>
                    <a class="nav-link text-light" href="registro.php">Registrarse</a>
                <?php endif; ?>
                <a class="nav-link text-light" href="productos.php">Productos</a>
            </div>
            <button id="modoToggle" class="btn btn-outline-light ms-3">Modo🌙</button>
        </div>
    </div>
</nav>
