<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Verificar si se recibe un ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensaje'] = "ID de nota inválido.";
    header("Location: index.php");
    exit();
}

$nota_id = intval($_GET['id']);

// Obtener la información de la nota
$sqlNota = "SELECT * FROM notas WHERE id = ?";
$stmtNota = $conexion->prepare($sqlNota);
$stmtNota->bind_param("i", $nota_id);
$stmtNota->execute();
$resultNota = $stmtNota->get_result();

if ($resultNota->num_rows === 0) {
    $_SESSION['mensaje'] = "Nota no encontrada.";
    header("Location: index.php");
    exit();
}

$nota = $resultNota->fetch_assoc();

// Obtener listas de estudiantes y cursos
$sqlEstudiantes = "SELECT id, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM estudiantes";
$resultEstudiantes = $conexion->query($sqlEstudiantes);

$sqlCursos = "SELECT id, nombre FROM cursos";
$resultCursos = $conexion->query($sqlCursos);

// Procesar la edición de la nota
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $estudiante_id = intval($_POST['estudiante_id']);
    $curso_id = intval($_POST['curso_id']);
    $nueva_nota = floatval($_POST['nota']);

    if ($estudiante_id > 0 && $curso_id > 0 && $nueva_nota >= 0 && $nueva_nota <= 100) {
        $sqlUpdate = "UPDATE notas SET estudiante_id = ?, curso_id = ?, nota = ? WHERE id = ?";
        $stmtUpdate = $conexion->prepare($sqlUpdate);
        $stmtUpdate->bind_param("iidi", $estudiante_id, $curso_id, $nueva_nota, $nota_id);

        if ($stmtUpdate->execute()) {
            $_SESSION['mensaje'] = "Nota actualizada correctamente.";
            header("Location: index.php");
            exit();
        } else {
            $error = "Error al actualizar la nota.";
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
    <title>Editar Nota</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Editar Nota</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="edit.php?id=<?php echo $nota_id; ?>" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="estudiante_id" class="form-label">Estudiante</label>
            <select name="estudiante_id" id="estudiante_id" class="form-control" required>
                <option value="">Seleccione un estudiante</option>
                <?php while ($estudiante = $resultEstudiantes->fetch_assoc()) : ?>
                    <option value="<?php echo $estudiante['id']; ?>" 
                        <?php echo ($nota['estudiante_id'] == $estudiante['id']) ? 'selected' : ''; ?>>
                        <?php echo $estudiante['nombre_completo']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="curso_id" class="form-label">Curso</label>
            <select name="curso_id" id="curso_id" class="form-control" required>
                <option value="">Seleccione un curso</option>
                <?php while ($curso = $resultCursos->fetch_assoc()) : ?>
                    <option value="<?php echo $curso['id']; ?>" 
                        <?php echo ($nota['curso_id'] == $curso['id']) ? 'selected' : ''; ?>>
                        <?php echo $curso['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nota" class="form-label">Nota</label>
            <input type="number" name="nota" id="nota" class="form-control" min="0" max="100" step="0.1" value="<?php echo $nota['nota']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<!-- <a href="edit.php?id=<?php echo $nota['id']; ?>" class="btn btn-warning">Editar</a> -->

</body>
</html>
