<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Obtener todos los cursos con los nombres de los docentes
$sql = "SELECT cursos.id, cursos.nombre AS curso_nombre, 
               docentes.nombre AS docente_nombre, docentes.apellido AS docente_apellido
        FROM cursos
        LEFT JOIN docentes ON cursos.docente_id = docentes.id";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cursos</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Lista de Cursos</h2>

    <!-- Mensajes de éxito o error -->
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-info"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>

    <a href="create.php" class="btn btn-success mb-3">Agregar Nuevo Curso</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Curso</th>
                <th>Docente Asignado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['curso_nombre']; ?></td>
                    <td><?php echo $row['docente_nombre'] . " " . $row['docente_apellido']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este curso?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="../../index.php" class="btn btn-secondary">Volver al Inicio</a>
</div>

</body>
</html>
