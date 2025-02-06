<?php
// Obtener los estudiantes (ajusta la consulta según tu estructura de base de datos)
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

$sql = "SELECT id, nombre, apellido, edad FROM estudiantes";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes</title>
    <!-- Enlace a Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h1 class="text-center mb-4">Lista de Estudiantes</h1>
        
        <!-- Tabla con los estudiantes -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Edad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar los estudiantes
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id"]. "</td>
                                <td>" . $row["nombre"]. "</td>
                                <td>" . $row["apellido"]. "</td>
                                <td>" . $row["edad"]. "</td>
                                <td><a href='ver_estudiante.php?id=" . $row["id"] . "' class='btn btn-info btn-sm'>Ver</a> 
                                    | <a href='editar_estudiante.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Editar</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No hay estudiantes registrados</td></tr>";
                }
                $conexion->close();
                ?>
            </tbody>
        </table>

        <br>

        <h2 class="text-center">Registrar Nuevo Estudiante</h2>
        <form action="create.php" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" id="edad" name="edad" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Estudiante</button>
        </form>
    </div>

    <!-- Enlace a los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
