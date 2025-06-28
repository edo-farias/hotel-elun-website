<?php
// Archivo: /admin/dashboard.php
$page_title = 'Dashboard'; // Título específico para esta página
require_once 'partials/header.php'; // Incluimos el header
?>

<h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
<p>Este es tu panel de administración. Desde aquí podrás gestionar el contenido del sitio web.</p>
<hr>
<h2>Menú de Administración:</h2>
<ul>
  <li><a href="gallery.php">Gestionar Galería de Imágenes</a></li>
  <li><a href="news.php">Publicar Noticias o Avisos</a></li>
  <li>Administrar Promoción Emergente</li>
  <li>Gestionar Tipos de Habitaciones</li>
</ul>

<?php
require_once 'partials/footer.php'; // Incluimos el footer
?>