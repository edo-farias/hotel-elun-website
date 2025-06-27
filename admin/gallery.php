<?php
// Archivo: /admin/gallery.php
$page_title = 'Gestionar Galería';
require_once 'partials/header.php';
$page_title = 'Gestionar Galería';
require_once 'partials/header.php';

// --- AÑADE ESTE BLOQUE ---
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
    unset($_SESSION['message']); // Limpiar el mensaje para que no se muestre de nuevo
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Gestionar Galería de Imágenes</h2>
</div>

<div class="card mb-4">
  <div class="card-header">
    Subir Nueva Imagen
  </div>
  <div class="card mb-4">
  <div class="card-header">
    Subir Nueva Imagen
  </div>
  <div class="card-body">
    <form action="gallery_upload.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="gallery_image" class="form-label">Seleccionar imagen (JPG, PNG, GIF - Máx 5MB)</label>
        <input class="form-control" type="file" id="gallery_image" name="gallery_image" required>
      </div>
      <div class="mb-3">
        <label for="caption" class="form-label">Leyenda (opcional)</label>
        <input type="text" class="form-control" id="caption" name="caption" placeholder="Ej: Vista desde el balcón">
      </div>
      <button type="submit" class="btn btn-primary">Subir Imagen</button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    Imágenes Actuales
  </div>
  <div class="card-body">
    <p>Próximamente: Galería de imágenes...</p>
  </div>
</div>


<?php
require_once 'partials/footer.php';
?>