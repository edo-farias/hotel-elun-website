<?php
// Archivo: /admin/news_add.php
$page_title = 'Añadir Nueva Noticia';
require_once 'partials/header.php'; // Incluimos el header del panel
?>

<h2>Añadir Nueva Noticia</h2>
<hr>

<form action="news_process.php" method="POST">
  <div class="mb-3">
    <label for="title" class="form-label">Título de la Noticia</label>
    <input type="text" class="form-control" id="title" name="title" required>
  </div>
  
  <div class="mb-3">
    <label for="content" class="form-label">Contenido</label>
    <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
  </div>
  
  <button type="submit" class="btn btn-primary">Guardar Noticia</button>
  <a href="news.php" class="btn btn-secondary">Cancelar</a>
</form>


<?php
require_once 'partials/footer.php'; // Incluimos el footer del panel
?>