<?php
// Archivo: /admin/dashboard.php
session_start();

// "Guardia de seguridad": Si el usuario no ha iniciado sesión, lo echa a la página de login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Administración</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Panel Hotel Elun</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container mt-5">
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Este es tu panel de administración. Desde aquí podrás gestionar el contenido del sitio web.</p>
    <hr>
    <h2>Próximos Pasos:</h2>
    <ul>
      <li>Gestionar Galería de Imágenes</li>
      <li>Publicar Noticias o Avisos</li>
      <li>Administrar Promoción Emergente</li>
      <li>Gestionar Tipos de Habitaciones</li>
    </ul>
  </main>
</body>
</html>