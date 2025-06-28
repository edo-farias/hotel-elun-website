<?php
// Archivo: /admin/popup.php
$page_title = 'Gestionar Pop-up Promocional';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

// --- LÓGICA PARA PROCESAR EL FORMULARIO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $is_active = isset($_POST['is_active']) ? 1 : 0; // Si el switch está 'on', es 1, si no, 0.
    $title = $_POST['title'];
    $content = $_POST['content'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];

    // Preparar la consulta UPDATE
    $sql_update = "UPDATE popup_settings SET is_active = ?, title = ?, content = ?, button_text = ?, button_link = ? WHERE id = 1";
    
    if ($stmt = $conn->prepare($sql_update)) {
        // "issssi" -> integer, string, string, string, string
        $stmt->bind_param("issss", $is_active, $title, $content, $button_text, $button_link);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Configuración del Pop-up actualizada con éxito.";
        } else {
            $_SESSION['message'] = "Error al actualizar la configuración.";
        }
        $stmt->close();
    }
    // Redirigir a la misma página para evitar reenvío de formulario y mostrar el mensaje
    header("Location: popup.php");
    exit();
}

// --- LÓGICA PARA OBTENER LOS DATOS ACTUALES ---
$sql_select = "SELECT * FROM popup_settings WHERE id = 1";
$result = $conn->query($sql_select);
$popup = $result->fetch_assoc();
$conn->close();

// Mostrar mensaje de éxito si existe
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
    unset($_SESSION['message']);
}
?>

<h2>Gestionar Pop-up Promocional</h2>
<p>Desde aquí puedes activar, desactivar y modificar el contenido de la ventana emergente que verán tus visitantes.</p>
<hr>

<div class="card">
  <div class="card-body">
    <form action="popup.php" method="POST">
      <div class="form-check form-switch mb-4">
        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" <?php echo ($popup['is_active'] == 1) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="is_active"><strong>Activar Pop-up Promocional</strong></label>
      </div>

      <div class="mb-3">
        <label for="title" class="form-label">Título del Pop-up</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($popup['title']); ?>">
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">Contenido / Mensaje</label>
        <textarea class="form-control" name="content" id="content" rows="5"><?php echo htmlspecialchars($popup['content']); ?></textarea>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="button_text" class="form-label">Texto del Botón</label>
          <input type="text" class="form-control" id="button_text" name="button_text" value="<?php echo htmlspecialchars($popup['button_text']); ?>">
        </div>
        <div class="col-md-6 mb-3">
          <label for="button_link" class="form-label">Enlace del Botón (URL)</label>
          <input type="url" class="form-control" id="button_link" name="button_link" value="<?php echo htmlspecialchars($popup['button_link']); ?>">
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
  </div>
</div>

<?php
require_once 'partials/footer.php';
?>