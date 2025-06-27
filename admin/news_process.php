<?php
// Archivo: /admin/news_process.php (ACTUALIZADO)

session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST['title'])) || empty(trim($_POST['content']))) {
        $_SESSION['message'] = "Error: El título y el contenido no pueden estar vacíos.";
        // Si hay un ID, devolvemos a la página de edición, si no, a la de añadir.
        $redirect_url = isset($_POST['article_id']) ? "news_edit.php?id=" . $_POST['article_id'] : "news_add.php";
        header("Location: " . $redirect_url);
        exit();
    }

    $title = $_POST['title'];
    $content = $_POST['content'];

    // --- LÓGICA DE DECISIÓN: ¿ES UNA ACTUALIZACIÓN O UNA INSERCIÓN? ---
    if (isset($_POST['article_id']) && !empty($_POST['article_id'])) {
        // --- ES UNA ACTUALIZACIÓN (UPDATE) ---
        $article_id = $_POST['article_id'];
        $sql = "UPDATE news_articles SET title = ?, content = ? WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            // "ssi" -> string, string, integer
            $stmt->bind_param("ssi", $title, $content, $article_id);

            if ($stmt->execute()) {
                $_SESSION['message'] = "¡Noticia actualizada con éxito!";
            } else {
                $_SESSION['message'] = "Error al actualizar la noticia.";
            }
            $stmt->close();
        }
    } else {
        // --- ES UNA INSERCIÓN (INSERT) ---
        $sql = "INSERT INTO news_articles (title, content) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $title, $content);

            if ($stmt->execute()) {
                $_SESSION['message'] = "¡Noticia añadida con éxito!";
            } else {
                $_SESSION['message'] = "Error al guardar la noticia.";
            }
            $stmt->close();
        }
    }
    
    $conn->close();
    header("Location: news.php");
    exit();

} else {
    header("Location: news.php");
    exit();
}
?>