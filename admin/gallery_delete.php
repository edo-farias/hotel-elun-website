<?php
// Archivo: /admin/gallery_delete.php

session_start();
require_once '../includes/db_connect.php';

// Guardia de seguridad
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['image_id'])) {
    $image_id = $_POST['image_id'];

    // 1. Obtener la ruta del archivo para poder borrarlo del servidor
    $sql_select = "SELECT image_path FROM gallery_images WHERE id = ?";
    if ($stmt_select = $conn->prepare($sql_select)) {
        $stmt_select->bind_param("i", $image_id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        
        if ($image = $result->fetch_assoc()) {
            $file_path = '../' . $image['image_path'];

            // 2. Borrar el registro de la base de datos
            $sql_delete = "DELETE FROM gallery_images WHERE id = ?";
            if ($stmt_delete = $conn->prepare($sql_delete)) {
                $stmt_delete->bind_param("i", $image_id);
                if ($stmt_delete->execute()) {
                    // 3. Si el registro se borró de la BD, borrar el archivo físico
                    if (file_exists($file_path)) {
                        unlink($file_path); // unlink() borra el archivo
                    }
                    $_SESSION['message'] = "Imagen eliminada con éxito.";
                } else {
                    $_SESSION['message'] = "Error al eliminar la imagen de la base de datos.";
                }
                $stmt_delete->close();
            }
        } else {
            $_SESSION['message'] = "Error: No se encontró la imagen a eliminar.";
        }
        $stmt_select->close();
    }
} else {
    // Redirigir si se accede al script incorrectamente
    $_SESSION['message'] = "Acceso no válido.";
}

$conn->close();
header("Location: gallery.php");
exit();
?>