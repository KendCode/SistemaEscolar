<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Obtener la lista de docentes para el selector
$sql = "SELECT id, nombre, apellido FROM docentes";
$result = $conexion->query($sql);

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $docente_id = $_POST['docente_id'];

    if (!empty($nombre) && !empty($docente_id)) {
        $sql = "INSERT INTO cursos (nombre, docente_id) VALUES ('$nombre', '$docente_id')";
        if ($conexion->query($sql) === TRUE) {
            $_SESSION['mensaje'] = "Curso registrado con éxito.";
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
    <title>Registrar Curso</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Registrar Curso</h2>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Curso</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="docente_id" class="form-label">Docente Asignado</label>
            <select name="docente_id" class="form-control" required>
                <option value="">Seleccione un Docente</option>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['nombre'] . " " . $row['apellido']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Curso</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

</body>
</html>
