<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Validar si se recibió el ID del estudiante
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID de estudiante no válido.";
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Obtener los datos del estudiante
$sql = "SELECT * FROM estudiantes WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$estudiante = $result->fetch_assoc();

// Obtener los cursos disponibles
$sqlCursos = "SELECT id, nombre FROM cursos";
$resultCursos = $conexion->query($sqlCursos);

if (!$estudiante) {
    $_SESSION['error'] = "Estudiante no encontrado.";
    header("Location: index.php");
    exit();
}

// Procesar el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $edad = intval($_POST['edad']);
    $curso_id = intval($_POST['curso_id']);

    if (!empty($nombre) && !empty($apellido) && $edad > 0 && $curso_id > 0) {
        $sqlUpdate = "UPDATE estudiantes SET nombre = ?, apellido = ?, edad = ?, curso_id = ? WHERE id = ?";
        $stmtUpdate = $conexion->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ssiii", $nombre, $apellido, $edad, $curso_id, $id);

        if ($stmtUpdate->execute()) {
            $_SESSION['mensaje'] = "Estudiante actualizado correctamente.";
            header("Location: index.php");
            exit();
        } else {
            $error = "Error al actualizar el estudiante.";
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Editar Estudiante</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="edit.php?id=<?php echo $id; ?>" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($estudiante['nombre']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" value="<?php echo htmlspecialchars($estudiante['apellido']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="edad" class="form-label">Edad</label>
            <input type="number" name="edad" id="edad" class="form-control" value="<?php echo $estudiante['edad']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="curso_id" class="form-label">Curso</label>
            <select name="curso_id" id="curso_id" class="form-control" required>
                <?php while ($curso = $resultCursos->fetch_assoc()) : ?>
                    <option value="<?php echo $curso['id']; ?>" <?php echo ($curso['id'] == $estudiante['curso_id']) ? 'selected' : ''; ?>>
                        <?php echo $curso['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<!-- <a href="edit.php?id=<?php // echo $row['id']; ?>" class="btn btn-warning">Editar</a> -->
</body>
</html>
