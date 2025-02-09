<?php
session_start();
//include 'models/base de datos/bd_escolar.sql'; // Archivo de conexión a la base de datos
include 'models/conexion/conexion.php'; // Archivo de conexión



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
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>


