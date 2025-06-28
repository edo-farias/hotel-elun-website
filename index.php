<?php
// Conectamos a la base de datos UNA SOLA VEZ al principio de todo.
// La variable $conn estará disponible para todo el resto del archivo.
require_once 'includes/db_connect.php';
// Consultar la configuración del pop-up
$sql_popup = "SELECT * FROM popup_settings WHERE id = 1";
$result_popup = $conn->query($sql_popup);
$popup_data = $result_popup->fetch_assoc();
?>
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
        <div class="pb-5 mb-5"><a href="https://us2.cloudbeds.com/reservation/GiUR4A" target="_blank" class="btn btn-primary btn-lg">
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
        <section id="noticias" class="py-5">
            <div class="container">
                <h2 class="text-center mb-5">Últimas Noticias y Avisos</h2>
                <div class="row">
                    <?php
                    // Consultamos las últimas 3 noticias publicadas
                    // Usamos LIMIT 3 para no saturar la página principal.
                    $sql_news = "SELECT title, content, created_at FROM news_articles WHERE is_published = 1 ORDER BY created_at DESC LIMIT 3";
                    $result_news = $conn->query($sql_news);

                    if ($result_news && $result_news->num_rows > 0) {
                        while ($news_item = $result_news->fetch_assoc()) {
                    ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($news_item['title']); ?></h5>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                Publicado el: <?php echo date('d \d\e F \d\e Y', strtotime($news_item['created_at'])); ?>
                                            </small>
                                        </p>
                                        <p class="card-text">
                                            <?php
                                            // Acortamos el contenido para mostrar solo un extracto
                                            $content_preview = strip_tags($news_item['content']);
                                            if (strlen($content_preview) > 150) {
                                                echo substr($content_preview, 0, 150) . "...";
                                            } else {
                                                echo $content_preview;
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                    <?php
                        } // Fin del while
                    } else {
                        echo '<div class="col"><p class="text-center">No hay noticias recientes para mostrar.</p></div>';
                    }
                    ?>
                </div>
            </div>
        </section>
        <hr>
        <section id="galeria" class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-5">Nuestra Galería</h2>
                <?php
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
                        <?php } ?>
                    </div>
                <?php
                } else {
                    echo '<p class="text-center">Próximamente tendremos más imágenes para mostrar.</p>';
                }
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
        window.addEventListener('load', function() {
            if (document.querySelector('.gallery')) {
                baguetteBox.run('.gallery');
            }
        });
    </script>
    <?php if ($popup_data) : ?>
        <div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="promoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="promoModalLabel"><?php echo htmlspecialchars($popup_data['title']); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php echo nl2br(htmlspecialchars($popup_data['content'])); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <a href="<?php echo htmlspecialchars($popup_data['button_link']); ?>" class="btn btn-primary" target="_blank">
                            <?php echo htmlspecialchars($popup_data['button_text']); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <script>
        <?php
        // Este código PHP solo se imprimirá en la página si el pop-up está activo en la BD
        if ($popup_data && $popup_data['is_active']) :
        ?>
            // Esperamos a que la página esté completamente cargada
            window.addEventListener('load', function() {
                // Revisamos si el pop-up ya se ha mostrado en esta sesión del navegador
                if (!sessionStorage.getItem('promoModalShown')) {
                    const promoModal = new bootstrap.Modal(document.getElementById('promoModal'));
                    promoModal.show(); // Mostramos el pop-up

                    // Guardamos un registro para no volver a mostrarlo en esta sesión
                    sessionStorage.setItem('promoModalShown', 'true');
                }
            });
        <?php endif; ?>
    </script>
    <?php
    $conn->close();
    ?>
</body>

</html>