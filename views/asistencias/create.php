<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Obtener la lista de estudiantes
$sql = "SELECT id, nombre, apellido FROM estudiantes";
$result = $conexion->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $estudiante_id = $_POST['estudiante_id'];
    $fecha = $_POST['fecha'];
    $estado = $_POST['estado']; // 'Presente', 'Ausente' o 'Tarde'

    // Insertar la asistencia en la base de datos
    $sql = "INSERT INTO asistencias (estudiante_id, fecha, estado) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iss", $estudiante_id, $fecha, $estado);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Asistencia registrada correctamente.";
        header("Location: index.php");
        exit();
    } else {
        $error = "Error al registrar la asistencia.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Asistencia</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Registrar Asistencia</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="POST">
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                
                <div class="mb-3">
                    <label for="estudiante_id" class="form-label">Estudiante</label>
                    <select class="form-control" id="estudiante_id" name="estudiante_id" required>
                        <option value="">Seleccionar estudiante</option>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo $row['nombre'] . " " . $row['apellido']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="Presente">Presente</option>
                        <option value="Ausente">Ausente</option>
                        <option value="Tarde">Tarde</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Registrar</button>
            </form>
            <p class="mt-3 text-center"><a href="index.php">Volver a Asistencias</a></p>
        </div>
    </div>
</div>

</body>
</html>
