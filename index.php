<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Elun - Frutillar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css">
    <style>
        /* Pequeños ajustes de estilo directamente aquí para empezar */
        .hero-section {
            background-image: url('https://via.placeholder.com/1920x1080/6c757d/343a40?text=Vista+del+Lago+Llanquihue');
            /* Imagen de fondo temporal */
            background-size: cover;
            background-position: center;
            height: 100vh;
            /* Ocupa toda la altura de la pantalla */
            display: flex;
            align-items: flex-end;
            /* Alinea el botón abajo */
            justify-content: center;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Hotel Elun</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#descripcion">El Hotel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#habitaciones">Habitaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#ubicacion">Ubicación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header id="inicio" class="hero-section text-white text-center">
        <div class="pb-5 mb-5"> <a href="https://us2.cloudbeds.com/reservation/GiUR4A" target="_blank" class="btn btn-primary btn-lg">
                Reservar Ahora
            </a>
        </div>
    </header>

    <main class="container my-5">
        <section id="descripcion" class="py-5">
            <h2>Bienvenido a Hotel Elun</h2>
            <p>Aquí va una descripción breve y cálida sobre tu hotel...</p>
        </section>
        <hr>
        <section id="habitaciones" class="py-5">
            <h2>Nuestras Habitaciones</h2>
            <p>Aquí presentaremos los 4 tipos de habitaciones...</p>
        </section>
        <hr>
        <section id="galeria" class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-5">Nuestra Galería</h2>

                <?php
                // Incluimos la conexión a la base de datos una sola vez si no se ha hecho antes
                // (Si ya tienes una conexión abierta, puedes quitar esta línea)
                require_once 'includes/db_connect.php';

                // Consultamos las imágenes de la galería
                $sql_gallery = "SELECT image_path, caption FROM gallery_images ORDER BY uploaded_at DESC";
                $result_gallery = $conn->query($sql_gallery);

                if ($result_gallery && $result_gallery->num_rows > 0) {
                ?>
                    <div class="gallery row">
                        <?php while ($image = $result_gallery->fetch_assoc()) { ?>
                            <div class="col-md-4 col-lg-3 mb-4">
                                <a href="<?php echo htmlspecialchars($image['image_path']); ?>"
                                    class="card-link"
                                    data-caption="<?php echo htmlspecialchars($image['caption']); ?>">
                                    <img src="<?php echo htmlspecialchars($image['image_path']); ?>"
                                        class="img-fluid rounded shadow-sm"
                                        alt="<?php echo htmlspecialchars($image['caption']); ?>"
                                        style="width: 100%; height: 200px; object-fit: cover;">
                                </a>
                            </div>
                        <?php } // Fin del while 
                        ?>
                    </div> <?php
                        } else {
                            echo '<p class="text-center">Próximamente tendremos más imágenes para mostrar.</p>';
                        }
                        // No cerramos la conexión aquí por si otros módulos la necesitan después
                        // $conn->close();
                            ?>
            </div>
        </section>
        <hr>
        <section id="ubicacion" class="py-5">
            <h2>Ubicación</h2>
            <p>Aquí irá el mapa de Google Maps...</p>
        </section>
        <hr>
        <section id="contacto" class="py-5">
            <h2>Contacto</h2>
            <p>Aquí irá el formulario de contacto...</p>
        </section>
    </main>

    <footer class="bg-dark text-white text-center p-4">
        <p>Hotel Elun | Dirección: Av. Philippi 123, Frutillar, Chile | Teléfono: +56 9 1234 5678 | Email: reservas@hotelelun.cl</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js" async></script>
    <script>
        // Esperamos a que todo el contenido de la ventana (imágenes, scripts, etc.) se haya cargado
        window.addEventListener('load', function() {
            // Solo entonces, buscamos la galería y la activamos
            if (document.querySelector('.gallery')) {
                baguetteBox.run('.gallery');
            }
        });
    </script>
</body>

</html>