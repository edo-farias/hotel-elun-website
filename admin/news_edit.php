<?php
// Archivo: /admin/news_edit.php
$page_title = 'Editar Noticia';
require_once 'partials/header.php';
require_once '../includes/db_connect.php';

// Verificar que se haya pasado un ID por la URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = "Error: ID de noticia no válido.";
    header("Location: news.php");
    exit();
}

$article_id = $_GET['id'];

// Obtener los datos actuales de la noticia para rellenar el formulario
$sql = "SELECT title, content FROM news_articles WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($article = $result->fetch_assoc()) {
        $title = $article['title'];
        $content = $article['content'];
    } else {
        $_SESSION['message'] = "Error: No se encontró la noticia.";
        header("Location: news.php");
        exit();
    }
    $stmt->close();
}
?>

<h2>Editar Noticia</h2>
<hr>

<form action="news_process.php" method="POST">
  <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">

  <div class="mb-3">
    <label for="title" class="form-label">Título de la Noticia</label>
    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
  </div>
  
  <div class="mb-3">
    <label for="content" class="form-label">Contenido</label>
    <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($content); ?></textarea>
  </div>
  
  <button type="submit" class="btn btn-primary">Actualizar Noticia</button>
  <a href="news.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php
$conn->close();
require_once 'partials/footer.php';
?>