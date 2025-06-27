<?php
// Archivo: /includes/db_connect.php
// Script para conectarse a la base de datos del hotel.

// ------------------- CONFIGURACIÓN DE LA CONEXIÓN ------------------- //
// REEMPLAZA LA PARTE FINAL DE ESTAS VARIABLES CON LOS DATOS DE TU HOSTING
// ------------------------------------------------------------------- //

$servername = "localhost";

// Ejemplo: Si creaste la base de datos 'datos', el nombre completo sería 'hotelelun_datos'
$dbname = "hotelelun_web"; // <-- Reemplaza 'web' por el nombre que le diste a tu BD

// Ejemplo: Si creaste el usuario 'admin_user', el nombre completo sería 'hotelelun_admin_user'
$username_db = "hotelelun_admin"; // <-- Reemplaza 'admin' por el nombre que le diste a tu usuario de BD

// La contraseña que asignaste a ese usuario de la base de datos
$password_db = "q&'7iu(&na#{z,Y"; // <-- Reemplaza por tu contraseña real


// --- NO MODIFICAR DEBAJO DE ESTA LÍNEA --- //

// Crear la conexión usando la extensión MySQLi
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Establecer el juego de caracteres a UTF-8
if (!$conn->set_charset("utf8mb4")) {
    // printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", $conn->error);
}

// Verificar si la conexión tuvo errores
if ($conn->connect_error) {
    die("Error de Conexión a la Base de Datos: " . $conn->connect_error);
}

?>