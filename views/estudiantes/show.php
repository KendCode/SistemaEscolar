<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Verificar si se recibe un ID válido por GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: ID de estudiante no proporcionado.");
}

$estudiante_id = $_GET['id'];

// Obtener información del estudiante
$sql = "SELECT e.id, e.nombre, e.apellido, e.edad, c.nombre AS curso 
        FROM estudiantes e 
        LEFT JOIN cursos c ON e.curso_id = c.id
        WHERE e.id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $estudiante_id);
$stmt->execute();
$result = $stmt->get_result();
$estudiante = $result->fetch_assoc();

if (!$estudiante) {
    die("Error: Estudiante no encontrado.");
}

// Obtener notas del estudiante
$sqlNotas = "SELECT n.nota, c.nombre AS curso FROM notas n 
             JOIN cursos c ON n.curso_id = c.id
             WHERE n.estudiante_id = ?";
$stmtNotas = $conexion->prepare($sqlNotas);
$stmtNotas->bind_param("i", $estudiante_id);
$stmtNotas->execute();
$resultNotas = $stmtNotas->get_result();

// Obtener asistencias del estudiante
$sqlAsistencias = "SELECT fecha, estado FROM asistencias WHERE estudiante_id = ?";
$stmtAsistencias = $conexion->prepare($sqlAsistencias);
$stmtAsistencias->bind_param("i", $estudiante_id);
$stmtAsistencias->execute();
$resultAsistencias = $stmtAsistencias->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Estudiante</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">📄 Detalles del Estudiante</h2>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo $estudiante['nombre'] . " " . $estudiante['apellido']; ?></h5>
            <p><strong>Edad:</strong> <?php echo $estudiante['edad']; ?></p>
            <p><strong>Curso:</strong> <?php echo $estudiante['curso']; ?></p>
        </div>
    </div>

    <h4 class="mt-4">📚 Notas</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($nota = $resultNotas->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $nota['curso']; ?></td>
                    <td><?php echo $nota['nota']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h4 class="mt-4">📅 Asistencias</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($asistencia = $resultAsistencias->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $asistencia['fecha']; ?></td>
                    <td><?php echo $asistencia['estado']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-primary mt-3">Volver</a>
</div>
</body>
</html>
