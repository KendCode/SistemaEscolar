<?php
require_once '../models/conexion/conexion.php';

class EstudianteController {
    private $conexion;

    public function __construct() {
        $this->conexion = Database::conectar();
    }

    // 📌 Obtener todos los estudiantes
    public function index() {
        $sql = "SELECT e.id, e.nombre, e.apellido, e.edad, c.nombre as curso
                FROM estudiantes e
                JOIN cursos c ON e.curso_id = c.id";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 📌 Obtener un estudiante por ID
    public function show($id) {
        $sql = "SELECT * FROM estudiantes WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 📌 Crear un nuevo estudiante
    public function store($nombre, $apellido, $edad, $curso_id) {
        $sql = "INSERT INTO estudiantes (nombre, apellido, edad, curso_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssii", $nombre, $apellido, $edad, $curso_id);
        return $stmt->execute();
    }

    // 📌 Editar un estudiante existente
    public function update($id, $nombre, $apellido, $edad, $curso_id) {
        $sql = "UPDATE estudiantes SET nombre = ?, apellido = ?, edad = ?, curso_id = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssiii", $nombre, $apellido, $edad, $curso_id, $id);
        return $stmt->execute();
    }

    // 📌 Eliminar un estudiante
    public function destroy($id) {
        $sql = "DELETE FROM estudiantes WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
