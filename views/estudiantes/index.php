<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Obtener la lista de estudiantes
$sql_estudiantes = "SELECT e.id, e.nombre, e.apellido, e.edad, c.nombre AS curso 
                   FROM estudiantes e 
                   LEFT JOIN cursos c ON e.curso_id = c.id";
$result_estudiantes = $conexion->query($sql_estudiantes);

// Obtener la lista de cursos para el formulario
$sql_cursos = "SELECT id, nombre FROM cursos";
$result_cursos = $conexion->query($sql_cursos);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $edad = intval($_POST['edad']);
    $curso_id = intval($_POST['curso_id']);
    
    if (!empty($nombre) && !empty($apellido) && $edad > 0 && $curso_id > 0) {
        $sql = "INSERT INTO estudiantes (nombre, apellido, edad, curso_id) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
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
    <title>Lista y Registro de Estudiantes</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Lista de Estudiantes</h2>

    <?php if (isset($_SESSION['mensaje'])) : ?>
        <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
    <?php elseif (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Tabla de estudiantes -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Edad</th>
                <th>Curso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($estudiante = $result_estudiantes->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $estudiante['id']; ?></td>
                    <td><?php echo htmlspecialchars($estudiante['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($estudiante['apellido']); ?></td>
                    <td><?php echo $estudiante['edad']; ?></td>
                    <td><?php echo htmlspecialchars($estudiante['curso']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $estudiante['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="delete.php?id=<?php echo $estudiante['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este estudiante?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Formulario de registro de estudiante -->
    <h2 class="text-center mt-5">Registrar Estudiante</h2>
    <form action="index.php" method="POST" class="mt-4">
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
                <?php while ($row_curso = $result_cursos->fetch_assoc()) : ?>
                    <option value="<?php echo $row_curso['id']; ?>"><?php echo $row_curso['nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

