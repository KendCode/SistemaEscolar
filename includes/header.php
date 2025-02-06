<!-- <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema Escolar</title>
  
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header class="header">
    <div class="logo">
      <img src="logo.png" alt="Logo del Sistema Escolar">
      <h1>Sistema Escolar</h1>
    </div>
    <nav class="nav">
      <ul>
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Estudiantes</a></li>
        <li><a href="#">Docentes</a></li>
        <li><a href="#">Horarios</a></li>
        <li><a href="#">Contacto</a></li>
      </ul>
    </nav>
    <div class="session-buttons">
      <a href="#" class="btn-login">Iniciar Sesión</a>
      <a href="#" class="btn-register">Registrarse</a>
    </div>
  </header>
</body>
</html> -->


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema Escolar</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
          <img src="img/imagen1 .png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
          Sistema Escolar
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Estudiantes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Docentes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Horarios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contacto</a>
            </li>
          </ul>
          <div class="d-flex">
            <a href="views/usuarios/login.php" class="btn btn-outline-light me-2">Iniciar Sesión</a>
            <a href="views/usuarios/register.php" class="btn btn-warning">Registrarse</a>
          </div>
        </div>
      </div>
    </nav>
  </header>

