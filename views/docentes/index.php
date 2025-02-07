<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Obtener la lista de docentes
$sql = "SELECT * FROM docentes";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Docentes</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Lista de Docentes</h2>

    <?php if (isset($_SESSION['mensaje'])) : ?>
        <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>

    <a href="create.php" class="btn btn-primary mb-3">Agregar Docente</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Materia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($docente = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $docente['id']; ?></td>
                    <td><?php echo htmlspecialchars($docente['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($docente['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($docente['materia']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $docente['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="delete.php?id=<?php echo $docente['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este docente?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
