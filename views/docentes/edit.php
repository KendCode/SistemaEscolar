<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Obtener el ID del docente desde la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensaje'] = "ID de docente inválido.";
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM docentes WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$docente = $result->fetch_assoc();

// Si el docente no existe, redirigir
if (!$docente) {
    $_SESSION['mensaje'] = "Docente no encontrado.";
    header("Location: index.php");
    exit();
}

// Procesar formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $materia = trim($_POST["materia"]);

    if (!empty($nombre) && !empty($apellido) && !empty($materia)) {
        $sql = "UPDATE docentes SET nombre = ?, apellido = ?, materia = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $apellido, $materia, $id);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Docente actualizado correctamente.";
            header("Location: index.php");
            exit();
        } else {
            $error = "Error al actualizar el docente.";
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
    <title>Editar Docente</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Editar Docente</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="edit.php?id=<?php echo $id; ?>" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($docente['nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?php echo htmlspecialchars($docente['apellido']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="materia" class="form-label">Materia</label>
            <input type="text" name="materia" class="form-control" value="<?php echo htmlspecialchars($docente['materia']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

</body>
</html>
