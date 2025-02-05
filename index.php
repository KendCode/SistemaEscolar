<?php
session_start();
include 'models/base de datos/bd_escolar.sql'; // Archivo de conexión a la base de datos
include 'models/conexion/conexion.php'; // Archivo de conexión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: views/usuarios/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Escolar</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Bienvenido al Sistema de Gestión Escolar</h1>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">Estudiantes</div>
                    <div class="card-body">
                        <p>Gestiona el registro de estudiantes</p>
                        <a href="views/estudiantes/index.php" class="btn btn-primary">Ver Estudiantes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">Docentes</div>
                    <div class="card-body">
                        <p>Administra la información de los docentes</p>
                        <a href="views/docentes/index.php" class="btn btn-primary">Ver Docentes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">Cursos</div>
                    <div class="card-body">
                        <p>Consulta los cursos y asignaciones</p>
                        <a href="views/cursos/index.php" class="btn btn-primary">Ver Cursos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
