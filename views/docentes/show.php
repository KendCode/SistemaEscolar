<?php
session_start();
include '../../config/database.php'; // Conexión a la base de datos

// Verificar si se envió un ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensaje'] = "ID de docente no válido.";
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Obtener los datos del docente
$sql = "SELECT * FROM docentes WHERE id = ?";
$stmt = $conn->prepare($sql);
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Docente</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Detalles del Docente</h2>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><?php echo htmlspecialchars($docente['nombre'] . ' ' . $docente['apellido']); ?></h4>
            <p><strong>Materia:</strong> <?php echo htmlspecialchars($docente['materia']); ?></p>
        </div>
    </div>
    <a href="index.php" class="btn btn-secondary mt-3">Volver</a>
</div>

</body>
</html>
