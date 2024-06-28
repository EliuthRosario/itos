<?php

require_once '../../conexion.php';
require_once '../../model/config.php';
require_once '../../model/mensajes.php';

$idTransaccion = isset($_GET['id']) ? $_GET['id'] : '0';
$errors = '';
$mensaje = '0';

if (isset($_SESSION['mensaje'])) {
  $mensaje = mensajes($_SESSION['mensaje']);
  unset($_SESSION['mensaje']);
}

if ($idTransaccion == '0') {
  $errors .= 'Error al procesar la peticion';
} else {
  $sql = $con->prepare("SELECT count(idFactura) FROM factura WHERE idTransaccion=? AND estado=?");
  $sql->execute([$idTransaccion, 'COMPLETED']);
  $result = $sql->get_result();
  if ($result->fetch_column() > 0) {
    $sql = $con->prepare("SELECT idFactura, fecha, total FROM factura WHERE idTransaccion=? AND estado=? LIMIT 1");
    $sql->execute([$idTransaccion, 'COMPLETED']);
    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    $idFactura = $row['idFactura'];
    $fecha = $row['fecha'];
    $total = $row['total'];

    $sqlDetalles = $con->prepare("SELECT d.nombre, d.precio, d.cantidad, subtotal, p.nombreProducto FROM detalles_factura d INNER JOIN productos p ON d.idProducto = p.idProducto WHERE d.idFactura = ?");
    $sqlDetalles->execute([$idFactura]);
    $result = $sqlDetalles->get_result();
  } else {
    $errors = 'Error al comprobar la compra';
  }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <title>Confirmacion de pago</title>
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

  <div class="container mt-4 detalles-compra">
    <h3 class="text-center mt-4">Detalles de su compra</h3>
    <?php if (strlen($errors)){ ?>
    <div class="row">
      <div class="col">
        <h3 class="text-danger"><?= $errors; ?></h3>
      </div>
    </div>
    <?php } else { ?>
    <div class="row">
      <div class="col">
        <b>Factura de compra Nº: <?= $idFactura; ?></b> <br/>
        <b>Fecha de la compra: <?= $fecha; ?></b> <br/>
        <b>Total de la compra: <?= MONEDA .number_format($total, '2', '.', ','); ?></b> <br/>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['nombreProducto']; ?></td>
                <td><?= MONEDA . number_format($row['precio'], 2, '.', ','); ?></td>
                <td><?= $row['cantidad']; ?></td>
                <td><?= MONEDA . number_format($row['subtotal'], 2, '.', ','); ?></td>
              </tr>
              <?php endwhile;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-end reporte-pdf">
      <a href="../../fpdf/detallesCompra.php?idFactura=<?= $idFactura; ?>" class="btn btn-danger" target="_blank">
        <i class="bi bi-file-pdf-fill"></i>
      </a>
    </div>
    <?php } ?>
  </div>
  
  <script src="../../assets/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/funciones.js"></script>
  
  <script>
    var mensaje = <?= $mensaje ?>;
  </script>
</body>
</html>