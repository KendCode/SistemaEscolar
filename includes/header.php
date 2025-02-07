<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">🏫 Gestión Escolar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="estudiantes/index.php">📚 Estudiantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="docentes/index.php">👨‍🏫 Docentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cursos/index.php">📖 Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="notas/index.php">📝 Notas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="asistencias/index.php">📅 Asistencias</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item">
                        <span class="nav-link text-light">👤 <?php echo $_SESSION['usuario']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white" href="../views/usuarios/login.php">Salir</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white" href="login.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
