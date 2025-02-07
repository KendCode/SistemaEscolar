<?php
session_start();
include '../../config/database.php'; // Conexión a la base de datos

// Consulta para obtener las notas con información de estudiantes y cursos
$sql = "SELECT notas.id, estudiantes.nombre AS estudiante, estudiantes.apellido, cursos.nombre AS curso, notas.nota
        FROM notas
        INNER JOIN estudiantes ON notas.estudiante_id = estudiantes.id
        INNER JOIN cursos ON notas.curso_id = cursos.id";
$result = $conn->query($sql);

// Manejo de mensajes de éxito o error
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
unset($_SESSION['mensaje']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Notas</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Notas</h2>

    <?php if (!empty($mensaje)) : ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between mb-3">
        <a href="create.php" class="btn btn-primary">Añadir Nueva Nota</a>
        <a href="../dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Nota</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['estudiante'] . " " . $row['apellido']; ?></td>
                    <td><?php echo $row['curso']; ?></td>
                    <td><?php echo $row['nota']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta nota?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
