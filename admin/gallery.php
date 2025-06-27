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
    <?php
    // Incluir la conexión a la base de datos
    require_once '../includes/db_connect.php';

    // Preparar la consulta para obtener todas las imágenes, las más nuevas primero
    $sql = "SELECT id, image_path, caption FROM gallery_images ORDER BY uploaded_at DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<div class="row">';
        // Recorrer cada fila de resultados
        while ($image = $result->fetch_assoc()) {
    ?>
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="card h-100">
            <img src="../<?php echo htmlspecialchars($image['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($image['caption']); ?>" style="object-fit: cover; height: 200px;">
            <div class="card-body d-flex flex-column">
              <p class="card-text flex-grow-1"><?php echo htmlspecialchars($image['caption']); ?></p>
              
              <form action="gallery_delete.php" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta imagen?');" class="mt-auto">
                <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>">
                <button type="submit" class="btn btn-danger btn-sm w-100">Eliminar</button>
              </form>
              
            </div>
          </div>
        </div>
    <?php
        } // Fin del while
        echo '</div>'; // Fin del .row
    } else {
        echo '<p class="text-center">No hay imágenes en la galería. ¡Sube la primera!</p>';
    }
    $conn->close();
    ?>
  </div>
</div>
</div>


<?php
require_once 'partials/footer.php';
?>