<?php
session_start();
include '../../config/database.php'; // Conexión a la base de datos

// Obtener la lista de cursos para asignar al estudiante
$sql = "SELECT id, nombre FROM cursos";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $edad = intval($_POST['edad']);
    $curso_id = intval($_POST['curso_id']);

    if (!empty($nombre) && !empty($apellido) && $edad > 0 && $curso_id > 0) {
        $sql = "INSERT INTO estudiantes (nombre, apellido, edad, curso_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $nombre, $apellido, $edad, $curso_id);
        
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Estudiante registrado exitosamente.";
            header("Location: index.php");
            exit();
        } else {
            $error = "Error al registrar el estudiante.";
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
    <title>Registrar Estudiante</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Registrar Estudiante</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="create.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="edad" class="form-label">Edad</label>
            <input type="number" name="edad" id="edad" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="curso_id" class="form-label">Curso</label>
            <select name="curso_id" id="curso_id" class="form-control" required>
                <option value="">Seleccione un curso</option>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<!-- <a href="create.php" class="btn btn-success">Nuevo Estudiante</a> -->

</body>
</html>
