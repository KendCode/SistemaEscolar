<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Obtener estudiantes y cursos disponibles
$sqlEstudiantes = "SELECT id, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM estudiantes";
$resultEstudiantes = $conexion->query($sqlEstudiantes);

$sqlCursos = "SELECT id, nombre FROM cursos";
$resultCursos = $conexion->query($sqlCursos);

// Procesar el formulario de creación de nota
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $estudiante_id = intval($_POST['estudiante_id']);
    $curso_id = intval($_POST['curso_id']);
    $nota = floatval($_POST['nota']);

    if ($estudiante_id > 0 && $curso_id > 0 && $nota >= 0 && $nota <= 100) {
        $sqlInsert = "INSERT INTO notas (estudiante_id, curso_id, nota) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sqlInsert);
        $stmt->bind_param("iid", $estudiante_id, $curso_id, $nota);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Nota registrada correctamente.";
            header("Location: index.php");
            exit();
        } else {
            $error = "Error al registrar la nota.";
        }
    } else {
        $error = "Todos los campos son obligatorios y la nota debe estar entre 0 y 100.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nota</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Registrar Nota</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="create.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="estudiante_id" class="form-label">Estudiante</label>
            <select name="estudiante_id" id="estudiante_id" class="form-control" required>
                <option value="">Seleccione un estudiante</option>
                <?php while ($estudiante = $resultEstudiantes->fetch_assoc()) : ?>
                    <option value="<?php echo $estudiante['id']; ?>"><?php echo $estudiante['nombre_completo']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="curso_id" class="form-label">Curso</label>
            <select name="curso_id" id="curso_id" class="form-control" required>
                <option value="">Seleccione un curso</option>
                <?php while ($curso = $resultCursos->fetch_assoc()) : ?>
                    <option value="<?php echo $curso['id']; ?>"><?php echo $curso['nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nota" class="form-label">Nota</label>
            <input type="number" name="nota" id="nota" class="form-control" min="0" max="100" step="0.1" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<!-- <a href="create.php" class="btn btn-success">Añadir Nota</a> -->
</body>
</html>
