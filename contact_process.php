<?php
// Archivo: contact_process.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- RECOGER Y LIMPIAR LOS DATOS DEL FORMULARIO ---
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // --- VALIDACIÓN BÁSICA ---
    // Verificar que los campos no estén vacíos y que el email sea válido
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Si algo falla, redirigir o mostrar un error.
        // Por simplicidad, mostraremos un mensaje aquí.
        http_response_code(400); // Bad Request
        echo "Por favor, completa todos los campos del formulario e ingresa un correo válido.";
        exit;
    }

    // --- CONFIGURACIÓN DEL CORREO ---
    // A quién se le envía el correo. ¡Cámbialo por tu correo real!
    $recipient = "reservas@hotelelun.cl";

    // Asunto del correo que recibirás
    $email_subject = "Nuevo Mensaje de Contacto desde la Web: $subject";

    // Contenido del correo que recibirás
    $email_content = "Has recibido un nuevo mensaje desde el formulario de contacto de tu sitio web.\n\n";
    $email_content .= "Nombre: $name\n";
    $email_content .= "Correo: $email\n\n";
    $email_content .= "Mensaje:\n$message\n";

    // Cabeceras del correo. Son importantes para que el correo no vaya a spam.
    // La cabecera "From" hace que el correo parezca venir del email de la persona que llenó el formulario.
    // La cabecera "Reply-To" asegura que si le das a "Responder", le responderás a esa persona.
    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // --- ENVIAR EL CORREO ---
    // La función mail() de PHP intenta enviar el correo.
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Éxito
        http_response_code(200); // OK
        echo "¡Gracias! Tu mensaje ha sido enviado con éxito. Te contactaremos pronto.";
    } else {
        // Falla (esto es lo que probablemente pasará en XAMPP)
        http_response_code(500); // Internal Server Error
        echo "Oops! Algo salió mal y no pudimos enviar tu mensaje. Por favor, intenta de nuevo más tarde.";
    }

} else {
    // No es una solicitud POST, así que no hacemos nada.
    http_response_code(403); // Forbidden
    echo "Hubo un problema con tu envío, por favor intenta de nuevo.";
}
?>