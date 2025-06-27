<?php
// Archivo: /admin/news_delete.php
session_start();
require_once '../includes/db_connect.php';

// Guardia de seguridad del panel
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['article_id'])) {
    $article_id = $_POST['article_id'];

    // Preparar la consulta SQL para eliminar la noticia
    $sql = "DELETE FROM news_articles WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $article_id); // "i" significa que el parámetro es un entero

        if ($stmt->execute()) {
            $_SESSION['message'] = "Noticia eliminada con éxito.";
        } else {
            $_SESSION['message'] = "Error al eliminar la noticia.";
        }
        $stmt->close();
    }
} else {
    $_SESSION['message'] = "Acceso no válido.";
}

$conn->close();
header("Location: news.php"); // Redirigir siempre a la lista de noticias
exit();
?>