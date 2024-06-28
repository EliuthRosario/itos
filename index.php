<?php 

require "conexion.php";
require "./model/config.php";
require "./model/mensajes.php";

$mensaje = '0';
if (isset($_SESSION['mensaje'])) {
  $mensaje = mensajes($_SESSION['mensaje']);
  unset($_SESSION['mensaje']);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <link rel="stylesheet" href="assets/css/styles.css">
  <title>Inicio</title>
</head>
<body>

  <!-- start barra de navegación -->
  <header class="header">
    <a href="#" class="logo">
      <i class="bi bi-basket-fill"></i> Itos
    </a>
    <nav class="nav-bar">
      <a href="index.php" class="link">Inicio</a>
      <a href="#about" class="link">Sobre nosotros</a>
      <a href="#services" class="link">Servicios</a>
      <a href="view/cliente/productos.php" class="link">Productos</a>
      <a href="#" class="link" data-bs-toggle="modal" data-bs-target="#modalContacto">Contacto</a>
    </nav>

    <div class="icons">
    <?php if (isset($_SESSION['idUsuario'])) { ?>
        <a href="#" class="me-1" id="btn-user" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <small class="text-dark">
            <?= $_SESSION['nombres'] .' '. $_SESSION['apellidos']; ?>
            <i class="bi bi-chevron-down"></i>
          </small>
        </a>
        <ul class="dropdown-menu" aria-labelledby="btn-user">
          <li><a class="dropdown-item" href="./view/cliente/perfil.php">Mi cuenta</a></li>
          <li><a class="dropdown-item" href="./view/cliente/compras.php">Mis compras</a></li>
          <li><a class="dropdown-item text-danger" href="./cerrarSesion.php">Cerrar sesión</a></li>
        </ul> 
      <?php } else { ?>
        <a href="./view/cliente/login.php" class="btn btn-primary text-sm-center" id="btn-user">
          <i class="bi bi-person"></i>
        </a>  
      <?php } ?>  
      <a href="view/cliente/carrito.php" class="btn btn-danger" id="btn-car">
        <i class="bi bi-cart"></i>
        <span class="num-cart mt-0" id="num-cart">
          <?php echo $numCart; ?>
        </span>
      </a> 
      <a href="#" class="btn btn-secondary" id="btn-menu">
        <i class="bi bi-list"></i>
      </a>
    </div>
  </header>
  <!-- end barra de navegacion -->

  <!-- start menu-mobile -->
  <div class="menu-mobile" id="menu-mobile">
    <div class="menu-mobile-content">
      <div class="menu-mobile-header">
        <div class="mobile-logo">
          <i class="bi bi-basket-fill"></i> Itos
        </div>
        <span class="mobile-close text-white" id="btn-close"><i class="bi bi-x"></i></span>
      </div>
      <div class="menu-mobile-body">
        <nav class="menu-options">
          <a href="./index.php" class="option"><i class="bi bi-house"></i> Inicio</a>
          <a href="#about" class="option"><i class="bi bi-info-circle"></i> Sobre nosotros</a>
          <a href="./view/cliente/productos.php" class="option"><i class="bi bi-cart"></i> Productos</a>
          <a href="#" class="option" data-bs-toggle="modal" data-bs-target="#modalContacto">
            <i class="bi bi-telephone"></i> Contacto
          </a>
        </nav>
      </div>
      <div class="menu-mobile-footer">
        <a href="https:/api.whatsapp.com/send?phone=3116173098" target="_blank"><i class="bi bi-whatsapp"></i></a>
        <a href="https://www.facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
        <a href="https://www.instagram.com/erosariohernandez/" target="_blank"><i class="bi bi-instagram"></i></a>
        <a href="https://twitter.com" target="_blank"><i class="bi bi-twitter"></i></a>
      </div>
    </div>
  </div>
  <!-- end menu-mobile -->

  <?php include './view/components/contacto.php'; ?>

  <!-- start corousel -->
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">

      <div class="carousel-item active d-item">
        <img src="img/Agro1.jpg" class="d-block w-100 d-img" alt="...">
        <div class="carousel-caption top-0 mt-4">
          <p class="mt-5 fs-3 ">
            En tienda itos compra al mejor precio todo los relacionado con productos agrícolas
          </p>
        </div>
      </div>

      <div class="carousel-item  d-item">
        <img src="img/Agro2.jpg" class="d-block w-100 d-img" alt="...">
        <div class="carousel-caption top-0 mt-4">
          <p class="mt-5 fs-3 ">
            En tienda itos compra al mejor precio todo los relacionado con productos agrícolas
          </p>
        </div>
      </div>

      <div class="carousel-item  d-item">
        <img src="img/Agro3.jpg" class="d-block w-100 d-img" alt="...">
        <div class="carousel-caption top-0 mt-4">
          <p class="mt-5 fs-3 ">
            En tienda itos compra al mejor precio todo los relacionado con productos agrícolas
          </p>
        </div>
      </div>

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <!-- end carousel -->
  
  <!-- start seccion sobre nosotros -->
  <section class="about" id="about">
    <h4 class="about-title text-center mb-4 mt-4">Sobre Nosotros</h4>
    <div class="about-content">
      <div class="about-image">
        <img src="img/maiz.jpg" alt="">
      </div>
      <div class="about-text">
        <h5 class="text-center">Tienda Itos</h5>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad ducimus omnis, 
          tenetur eius suscipit non deleniti nihil ab, 
          quod quam sed eaque voluptatum enim at! Vero quibusdam sit dolorum hic?
          quod quam sed eaque voluptatum enim at! Vero quibusdam sit dolorum hic?
          quod quam sed eaque voluptatum enim at! Vero quibusdam 
        </p>
      </div>
    </div>
  </section>
  <!-- end seccion sobre nosotros -->

  <!-- start seccion servicios -->
  <section class="services" id="services">
    <h3 class="services-header text-center">Nuestros Servicios</h3>
    <div class="services-content">
      <div class="service-item">
        <div class="service-img">
          <img src="./img/img-envio.jpg" alt="envio" class=" mw-100">
        </div>
        <div class="service-footer d-flex align-items-center flex-column">
          <h4 class="service-title">Envíos gratis</h4>
          <div class="service-text">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut tempore numquam quo neque. Magnam itaque et nulla.
          </div>
        </div>
      </div>
      <div class="service-item">
        <div class="service-img">
          <img src="./img/img-pago.jpg" alt="pago" class="mw-100">
        </div>
        <div class="service-footer d-flex align-items-center flex-column">
          <h4 class="service-title">Pagos en linea</h4>
          <div class="service-text">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut tempore numquam quo neque. Magnam itaque et nulla.
          </div>
        </div>
      </div>
      <div class="service-item">
        <div class="service-img">
          <img src="./img/img-calidad.jpg" alt="calidad" class="mw-100">
        </div>
        <div class="service-footer d-flex align-items-center flex-column">
          <h4 class="service-title">Calidad de productos</h4>
          <div class="service-text">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut tempore numquam quo neque. Magnam itaque et nulla.
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end seccion servicios -->

  <!-- start Botón para ir arriba -->
  <div class="btn-top" id="btn-top">
    <i class="bi bi-chevron-up"></i>
  </div>
  <!-- end Botón para ir arriba -->

  <!-- start botón Whatsaap -->
  <div class="btn-whatsapp">
    <a href="https:/api.whatsapp.com/send?phone=3116173098" target="_blank"><i class="bi bi-whatsapp"></i></a>
  </div>
  <!-- end botón Whatsaap -->

  <!-- start mapa -->
  <div class="seccion-mapa mb-4">
    <h3 class="mapa-title text-center">Ubicación</h3>
    <div id="map"></div>
  </div>
  <!-- end mapa -->

  <?php include './view/components/footer.php'; ?>
  
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="./assets/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="https://smtpjs.com/v3/smtp.js"></script>
  <script src="./assets/js/funciones.js"></script>

  <script>
    //mapa
    var map = L.map('map').setView([8.898299, -75.367971], 13);
    var marker = L.marker([8.898299, -75.367971]).addTo(map);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    let mensaje = <?= $mensaje; ?>;

  </script>

</body>
</html>