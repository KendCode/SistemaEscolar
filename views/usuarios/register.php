<?php
session_start();
include '../../models/conexion/conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol']; // admin, docente o estudiante

    // Verificar si el usuario ya existe
    $sql = "SELECT id FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "El usuario ya está registrado.";
    } else {
        // Hashear la contraseña
        $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

        // Insertar en la base de datos
        $sql = "INSERT INTO usuarios (usuario, contrasena, rol) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $usuario, $contrasena_hash, $rol);

        if ($stmt->execute()) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] = $rol;

            if ($rol == 'admin') {
                header("Location: ../../admin/dashboard.php");
            } else {
                header("Location: ../../index.php");
            }
            exit();
        } else {
            $error = "Error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Registro de Usuario</h2>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form action="" method="POST">
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select class="form-control" id="rol" name="rol" required>
                        <option value="estudiante">Estudiante</option>
                        <option value="docente">Docente</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Registrar</button>
            </form>
            <p class="mt-3 text-center"><a href="login.php">¿Ya tienes cuenta? Inicia sesión</a></p>
        </div>
    </div>
</div>

</body>
</html>
