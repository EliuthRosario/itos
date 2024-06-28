<?php 

require '../../conexion.php';
require '../../model/config.php';

if (empty($_SESSION['idUsuario'])) {
  header('Location: ../../index.php');
  exit;
}

$idCliente = $_SESSION['idCliente'];
$sql = $con->prepare("SELECT idFactura, fecha, total FROM factura WHERE idCliente = ? ORDER BY fecha DESC");
$sql->execute([$idCliente]);
$result = $sql->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <title>Historial de compras</title>
</head>
<body>

  <!--barra de navegación-->
  <header class="header">
    <a href="#" class="logo">
      <i class="bi bi-basket-fill"></i> Itos
    </a>
    <nav class="nav-bar">
      <a href="../../index.php" class="link">Inicio</a>
      <a href="../../index.php#about" class="link">Sobre nosotros</a>
      <a href="../../index.php#services" class="link">Servicios</a>
      <a href="./productos.php" class="link">Productos</a>
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
          <li><a class="dropdown-item" href="./perfil.php">Mi cuenta</a></li>
          <li><a class="dropdown-item" href="./compras.php">Mis compras</a></li>
          <li><a class="dropdown-item text-danger" href="../../cerrarSesion.php">Cerrar sesión</a></li>
        </ul> 
      <?php } else { ?>
        <a href="./view/cliente/login.php" class="btn btn-primary text-sm-center" id="btn-user">
          <i class="bi bi-person"></i>
        </a>  
      <?php } ?>  
      <a href="./carrito.php" class="btn btn-danger" id="btn-car">
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

  <!--start menu-mobile-->
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
          <a href="../../index.php" class="option"><i class="bi bi-house"></i> Inicio</a>
          <a href="../../index.php#about" class="option"><i class="bi bi-info-circle"></i> Sobre nosotros</a>
          <a href="./productos.php" class="option">
            <i class="bi bi-cart"></i> Productos
          </a>
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

  <?php include '../components/contacto.php'; ?>

  <!-- historial de compras -->
  <div class="container mt-4 ">
    <h3 class="text-center mt-4">Mis compras</h3>
    <hr>
    <div class="d-flex g-2 justify-content-center flex-wrap">
      <?php 
      if ($result->num_rows > 0) {
        while ($compra = $result->fetch_assoc()) { ?>
        <div class="card m-2 border-secondary">
          <div class="card-header">
            Fecha: <?= $compra['fecha']; ?>
          </div>
          <div class="card-body">
            <h5 class="card-title">Factura Nº: <?= $compra['idFactura']; ?></h5>
            <p class="card-text">Total: <?= MONEDA . number_format($compra['total'],  2, '.', ','); ?></p>
            <div class="d-flex justify-content-center">
              <a href="./detallesCompra.php?idFactura=<?= $compra['idFactura']; ?>" class="btn btn-primary">Ver compra</a>
            </div>
          </div>
        </div>
      <?php 
        } 
      } else {
        echo '<span class="text-center">No has hecho ninguna compra</span>';
      }
      ?>  
    </div>
  </div>

  <!--Botón para ir hacia arriba-->
  <div class="btn-top" id="btn-top">
    <i class="bi bi-chevron-up"></i>
  </div>
  
  <script src="../../assets/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/funciones.js"></script>

</body>
</html>