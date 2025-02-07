<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Obtener la lista de asistencias con los nombres de los estudiantes
$sql = "SELECT asistencias.id, estudiantes.nombre, estudiantes.apellido, asistencias.fecha, asistencias.estado 
        FROM asistencias 
        INNER JOIN estudiantes ON asistencias.estudiante_id = estudiantes.id 
        ORDER BY asistencias.fecha DESC";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Asistencias</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Lista de Asistencias</h2>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
    <?php } ?>

    <div class="d-flex justify-content-between mb-3">
        <a href="create.php" class="btn btn-success">Registrar Asistencia</a>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre'] . " " . $row['apellido']; ?></td>
                    <td><?php echo $row['fecha']; ?></td>
                    <td><?php echo $row['estado']; ?></td>
                    <td>
                        <a href="../estudiantes/show.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Ver</a>
                        <a href="../estudiantes/edit.php?<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <p class="mt-3 text-center"><a href="../admin/dashboard.php">Volver al Panel</a></p>
</div>

</body>
</html>
