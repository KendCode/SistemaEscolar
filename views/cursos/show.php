<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Verificar si se proporciona un ID de curso válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensaje'] = "Curso no encontrado.";
    header("Location: index.php");
    exit();
}

$curso_id = $_GET['id'];

// Obtener detalles del curso y del docente asignado
$sql = "SELECT cursos.id, cursos.nombre AS curso_nombre, 
               docentes.nombre AS docente_nombre, docentes.apellido AS docente_apellido
        FROM cursos
        LEFT JOIN docentes ON cursos.docente_id = docentes.id
        WHERE cursos.id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();
$curso = $result->fetch_assoc();

if (!$curso) {
    $_SESSION['mensaje'] = "Curso no encontrado.";
    header("Location: index.php");
    exit();
}

// Obtener la lista de estudiantes inscritos en el curso
$sql_estudiantes = "SELECT estudiantes.id, estudiantes.nombre, estudiantes.apellido
                    FROM estudiantes
                    WHERE estudiantes.curso_id = ?";
$stmt_estudiantes = $conexion->prepare($sql_estudiantes);
$stmt_estudiantes->bind_param("i", $curso_id);
$stmt_estudiantes->execute();
$result_estudiantes = $stmt_estudiantes->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Curso</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Detalles del Curso</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Nombre del Curso: <?php echo htmlspecialchars($curso['curso_nombre']); ?></h5>
            <p class="card-text"><strong>Docente Asignado:</strong> <?php echo htmlspecialchars($curso['docente_nombre'] . " " . $curso['docente_apellido']); ?></p>
        </div>
    </div>

    <h3 class="mt-4">Estudiantes Inscritos</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_estudiantes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary">Volver a Cursos</a>
    <a href="show.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Ver Detalles</a>

</div>

</body>
</html>
