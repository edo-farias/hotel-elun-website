<?php
// Archivo: /admin/login.php

// Iniciar la sesión. Esto debe ir ANTES de cualquier salida HTML.
session_start();

// Si el usuario ya tiene una sesión activa, redirigirlo al dashboard.
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Variable para almacenar mensajes de error
$error_message = '';

// Procesar el formulario cuando se envía por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Incluir la conexión a la base de datos
    require_once '../includes/db_connect.php';

    // 2. Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 3. Preparar la consulta para evitar inyección SQL (¡muy importante!)
    $sql = "SELECT id, username, password_hash FROM admin_users WHERE username = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Vincular el parámetro de username
        $stmt->bind_param("s", $username);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Guardar el resultado
            $stmt->store_result();

            // Verificar si se encontró el usuario (debería ser 1 fila)
            if ($stmt->num_rows == 1) {
                // Vincular las variables del resultado
                $stmt->bind_result($id, $username_db, $password_hash_db);
                if ($stmt->fetch()) {
                    // 4. Verificar la contraseña
                    if (password_verify($password, $password_hash_db)) {
                        // ¡Contraseña correcta! Iniciar la sesión.
                        session_regenerate_id(); // Regenerar ID de sesión por seguridad
                        $_SESSION['user_id'] = $id;
                        $_SESSION['username'] = $username_db;

                        // Redirigir al dashboard
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        // Contraseña incorrecta
                        $error_message = "El nombre de usuario o la contraseña son incorrectos.";
                    }
                }
            } else {
                // Usuario no encontrado
                $error_message = "El nombre de usuario o la contraseña son incorrectos.";
            }
        } else {
            $error_message = "Oops! Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
        }
        // Cerrar la declaración
        $stmt->close();
    }
    // Cerrar la conexión
    $conn->close();
}
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Panel de Administración</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-color: #f8f9fa;
    }
    .login-form {
      width: 100%;
      max-width: 400px;
      padding: 15px;
    }
  </style>
</head>
<body>
  <main class="login-form text-center">
    <form method="POST" action="login.php">
      <h1 class="h3 mb-3 fw-normal">Iniciar Sesión</h1>
      <p>Panel de Administración Hotel Elun</p>

      <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($error_message); ?>
        </div>
      <?php endif; ?>

      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="username" name="username" placeholder="Usuario" required>
        <label for="username">Nombre de Usuario</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
        <label for="password">Contraseña</label>
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
      <p class="mt-5 mb-3 text-muted">&copy; Hotel Elun <?php echo date("Y"); ?></p>
    </form>
  </main>
</body>
</html>