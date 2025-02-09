<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

// Obtener el ID del docente desde la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensaje'] = "ID de docente inválido.";
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Verificar si el docente existe
$sql = "SELECT * FROM docentes WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$docente = $result->fetch_assoc();

if (!$docente) {
    $_SESSION['mensaje'] = "Docente no encontrado.";
    header("Location: index.php");
    exit();
}

// Eliminar el docente
$sql = "DELETE FROM docentes WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['mensaje'] = "Docente eliminado correctamente.";
} else {
    $_SESSION['mensaje'] = "Error al eliminar el docente.";
}

header("Location: index.php");
exit();
?>
