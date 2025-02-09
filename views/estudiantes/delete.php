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

// Verificar si el estudiante existe
$sql = "SELECT id FROM estudiantes WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Estudiante no encontrado.";
    header("Location: index.php");
    exit();
}

// Eliminar el estudiante
$sqlDelete = "DELETE FROM estudiantes WHERE id = ?";
$stmtDelete = $conexion->prepare($sqlDelete);
$stmtDelete->bind_param("i", $id);

if ($stmtDelete->execute()) {
    $_SESSION['mensaje'] = "Estudiante eliminado correctamente.";
} else {
    $_SESSION['error'] = "Error al eliminar el estudiante.";
}

header("Location: index.php");
exit();
?>