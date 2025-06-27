<?php
// Archivo: /admin/news.php
$page_title = 'Gestionar Noticias';
require_once 'partials/header.php';
require_once '../includes/db_connect.php'; // Conexión a la BD

// Comprobar si hay un mensaje en la sesión (de éxito o error)
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
    unset($_SESSION['message']); // Limpiar el mensaje
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Gestionar Noticias y Avisos</h2>
  <a href="news_add.php" class="btn btn-primary">Añadir Nueva Noticia</a>
</div>

<div class="card">
  <div class="card-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Título</th>
          <th scope="col">Fecha de Publicación</th>
          <th scope="col" class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT id, title, created_at FROM news_articles ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($article = $result->fetch_assoc()) {
        ?>
          <tr>
            <td><?php echo htmlspecialchars($article['title']); ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($article['created_at'])); ?></td>
            <td class="text-end">
              <a href="news_edit.php?id=<?php echo $article['id']; ?>" class="btn btn-secondary btn-sm">Editar</a>
              
              <form action="news_delete.php" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta noticia?');">
                <input type="hidden" name="article_id" value="<?php echo $article['id']; ?>">
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php
            } // Fin del while
        } else {
            echo '<tr><td colspan="3" class="text-center">No hay noticias publicadas.</td></tr>';
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php
require_once 'partials/footer.php';
?>