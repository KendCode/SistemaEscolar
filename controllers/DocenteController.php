<?php
require_once '../models/conexion/conexion.php';

class DocenteController {
    private $conexion;

    public function __construct() {
        $this->conexion = Database::conectar();
    }

    // 📌 Obtener todos los docentes
    public function index() {
        $sql = "SELECT * FROM docentes";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 📌 Obtener un docente por ID
    public function show($id) {
        $sql = "SELECT * FROM docentes WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 📌 Crear un nuevo docente
    public function store($nombre, $apellido, $email, $telefono, $especialidad) {
        $sql = "INSERT INTO docentes (nombre, apellido, email, telefono, especialidad) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssss", $nombre, $apellido, $email, $telefono, $especialidad);
        return $stmt->execute();
    }

    // 📌 Editar un docente existente
    public function update($id, $nombre, $apellido, $email, $telefono, $especialidad) {
        $sql = "UPDATE docentes SET nombre = ?, apellido = ?, email = ?, telefono = ?, especialidad = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssssi", $nombre, $apellido, $email, $telefono, $especialidad, $id);
        return $stmt->execute();
    }

    // 📌 Eliminar un docente
    public function destroy($id) {
        $sql = "DELETE FROM docentes WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
