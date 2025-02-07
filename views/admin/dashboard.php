<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../usuarios/login.php");
    exit();
}

// Contar el número de registros en cada tabla
$sqlEstudiantes = "SELECT COUNT(*) AS total FROM estudiantes";
$sqlDocentes = "SELECT COUNT(*) AS total FROM docentes";
$sqlCursos = "SELECT COUNT(*) AS total FROM cursos";
$sqlNotas = "SELECT COUNT(*) AS total FROM notas";

$resultEstudiantes = $conexion->query($sqlEstudiantes)->fetch_assoc();
$resultDocentes = $conexion->query($sqlDocentes)->fetch_assoc();
$resultCursos = $conexion->query($sqlCursos)->fetch_assoc();
$resultNotas = $conexion->query($sqlNotas)->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Gestión Escolar</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">📊 Panel de Administración</h2>

    <div class="row mt-4">
        <!-- Tarjeta de Estudiantes -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Estudiantes</h5>
                    <p class="card-text">Total: <?php echo $resultEstudiantes['total']; ?></p>
                    <a href="../estudiantes/index.php" class="btn btn-light btn-sm">Ver Estudiantes</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Docentes -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Docentes</h5>
                    <p class="card-text">Total: <?php echo $resultDocentes['total']; ?></p>
                    <a href="../docentes/index.php" class="btn btn-light btn-sm">Ver Docentes</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Cursos -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Cursos</h5>
                    <p class="card-text">Total: <?php echo $resultCursos['total']; ?></p>
                    <a href="../cursos/index.php" class="btn btn-light btn-sm">Ver Cursos</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Notas -->
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Notas</h5>
                    <p class="card-text">Total: <?php echo $resultNotas['total']; ?></p>
                    <a href="../notas/index.php" class="btn btn-light btn-sm">Ver Notas</a>
                </div>
            </div>
        </div>
    </div>
    <a href="../asistencias/index.php" class="btn btn-primary">📅 Ver Asistencias</a>

    <a href="../auth/logout.php" class="btn btn-secondary mt-3">Cerrar Sesión</a>
</div>

</body>
</html>
