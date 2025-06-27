<?php
// Archivo: /admin/gallery_upload.php

session_start();
require_once '../includes/db_connect.php'; // Conexión a la BD

// Guardia de seguridad
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Verificar que se haya subido un archivo sin errores
    if (isset($_FILES["gallery_image"]) && $_FILES["gallery_image"]["error"] == 0) {
        $caption = $_POST['caption'] ?? ''; // Obtener la leyenda
        
        $target_dir = "../uploads/gallery/"; // Directorio de destino
        // Asegurarnos de que el directorio de subida exista
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Crear un nombre de archivo único para evitar sobreescribir archivos
        $original_name = basename($_FILES["gallery_image"]["name"]);
        $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
        $unique_filename = uniqid() . '_' . time() . '.' . $file_extension;
        $target_file = $target_dir . $unique_filename;

        // --- Validaciones de seguridad ---
        // 1. Verificar si es una imagen real
        $check = getimagesize($_FILES["gallery_image"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['message'] = "Error: El archivo no es una imagen válida.";
            header("Location: gallery.php");
            exit();
        }

        // 2. Verificar el tamaño del archivo (ej: 5MB máximo)
        if ($_FILES["gallery_image"]["size"] > 5 * 1024 * 1024) {
            $_SESSION['message'] = "Error: El archivo es demasiado grande (máximo 5MB).";
            header("Location: gallery.php");
            exit();
        }

        // 3. Permitir solo ciertos formatos de archivo
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($file_extension), $allowed_types)) {
            $_SESSION['message'] = "Error: Solo se permiten archivos JPG, JPEG, PNG y GIF.";
            header("Location: gallery.php");
            exit();
        }
        
        // --- Fin de las Validaciones ---

        // Intentar mover el archivo subido a nuestro directorio
        if (move_uploaded_file($_FILES["gallery_image"]["tmp_name"], $target_file)) {
            // El archivo se movió con éxito, ahora guardamos la ruta en la BD
            
            // La ruta que guardamos es relativa a la raíz del proyecto
            $db_path = "uploads/gallery/" . $unique_filename; 

            $sql = "INSERT INTO gallery_images (image_path, caption) VALUES (?, ?)";
            
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ss", $db_path, $caption);
                if ($stmt->execute()) {
                    $_SESSION['message'] = "¡Imagen subida con éxito!";
                } else {
                    $_SESSION['message'] = "Error: No se pudo guardar la información en la base de datos.";
                }
                $stmt->close();
            }
        } else {
            $_SESSION['message'] = "Error: Hubo un problema al subir tu archivo.";
        }

    } else {
        $_SESSION['message'] = "Error: No se seleccionó ningún archivo o hubo un error en la subida.";
    }

    $conn->close();
    header("Location: gallery.php");
    exit();
}
?>