<?php

require '../../conexion.php';
require '../../model/config.php';

$idFactura = isset($_GET['idFactura']) ? $_GET['idFactura'] : null;

if (empty($_SESSION['idUsuario'])) {
  header('Location: ../../index.php');
  exit(0); 
}

if ($idFactura == null) {
  header('Location: ../../index.php');
  exit(0); 
}

$sqlFactura = $con->prepare("SELECT f.idFactura, f.fecha, f.total FROM factura f WHERE f.idFactura=? LIMIT 1");
$sqlFactura->execute([$idFactura]);
$result = $sqlFactura->get_result();
$factura = $result->fetch_assoc();

$sqlDetalles = $con->prepare("SELECT d.nombre, d.precio, d.cantidad, d.subtotal FROM detalles_factura d WHERE d.idFactura=?");
$sqlDetalles->execute([$idFactura]);
$res = $sqlDetalles->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <title>Detalles de compra</title>
</head>
<body>
  <!--barra de navegación-->
  <header class="header">
    <a href="../../index.php" class="logo">
      <i class="bi bi-basket-fill"></i> Itos
    </a>
    <nav class="nav-bar">
      <a href="../../index.php" class="link">Inicio</a>
      <a href="../../index.php#about" class="link">Sobre nosotros</a>
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

  <!-- detalles de la compra -->
  <div class="container mt-4 ">
    <h3 class="text-center">Detalles de la compra</h3>
    <div class="row mt-4">
      <div class="col-12 col-md-4">
        <div class="card mb-3">
          <div class="card-header">
            <strong>Detalles de la compra</strong>
          </div>
          <div class="card-body">
            <p><strong>IdFactura: </strong><?= $factura['idFactura']; ?></p>
            <p><strong>Fecha: </strong><?= $factura['fecha']; ?></p>
            <p><strong>Total: </strong><?= MONEDA . number_format($factura['total'], 2, '.', ','); ?></p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-8">
        <div class="table-responsive">
          <table class="table">
            <thead class=" table-light">
              <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($detalle = $res->fetch_assoc()) { ?>
              <tr>
                <td><?= $detalle['nombre']; ?></td>
                <td><?= MONEDA . number_format($detalle['precio'], 2, '.', ','); ?></td>
                <td><?= $detalle['cantidad']; ?></td>
                <td><?= MONEDA . number_format($detalle['subtotal'], 2, '.', ','); ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td colspan="4">
                  <p class="h3 text-end"><strong>Total:</strong> <?= MONEDA . number_format($factura['total'], 2, '.', ','); ?></p>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="d-flex justify-content-end">
            <a href="../../fpdf/detallesCompra.php?idFactura=<?= $idFactura; ?>" class="btn btn-danger" target="_blank">
                <i class="bi bi-file-pdf"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--Boton para ir hacia arriba-->
  <div class="btn-top" id="btn-top">
    <i class="bi bi-chevron-up"></i>
  </div>
  
  <script src="../../assets/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/funciones.js"></script>

</body>
</html>