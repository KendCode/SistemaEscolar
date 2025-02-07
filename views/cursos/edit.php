<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Verificar si se recibe el ID del curso
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Obtener datos del curso
$sql = "SELECT * FROM cursos WHERE id = $id";
$result = $conexion->query($sql);

if ($result->num_rows == 0) {
    $_SESSION['mensaje'] = "Curso no encontrado.";
    header("Location: index.php");
    exit();
}

$curso = $result->fetch_assoc();

// Obtener la lista de docentes
$sql_docentes = "SELECT id, nombre, apellido FROM docentes";
$result_docentes = $conexion->query($sql_docentes);

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $docente_id = $_POST['docente_id'];

    if (!empty($nombre) && !empty($docente_id)) {
        $sql_update = "UPDATE cursos SET nombre = '$nombre', docente_id = '$docente_id' WHERE id = $id";
        if ($conexion->query($sql_update) === TRUE) {
            $_SESSION['mensaje'] = "Curso actualizado con éxito.";
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $conexion->error;
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Editar Curso</h2>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Curso</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $curso['nombre']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="docente_id" class="form-label">Docente Asignado</label>
            <select name="docente_id" class="form-control" required>
                <option value="">Seleccione un Docente</option>
                <?php while ($row = $result_docentes->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $curso['docente_id']) ? 'selected' : ''; ?>>
                        <?php echo $row['nombre'] . " " . $row['apellido']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Curso</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

</body>
</html>
