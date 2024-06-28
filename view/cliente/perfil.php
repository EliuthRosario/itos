<?php

require '../../conexion.php';
require '../../model/config.php';

if (empty($_SESSION['idCliente'])) {
  header('Location: ./login.php');
}

$idCliente = $_SESSION['idCliente'];
$query = $con->prepare("SELECT * FROM clientes WHERE idCliente=?");
$query->execute([$idCliente]);
$result = $query->get_result();

if ($result->num_rows > 0) {
  $cliente = $result->fetch_assoc();
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
  <title>Perfil</title>
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

  <!-- datos del perfil -->
  <div class="container mt-4">
    <div class="perfil">
      <div class="perfil-header">
        <h3 class="text-center">Mis datos</h3>
      </div>
      <div class="perfil-content">
        <form action="" method="post">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="mb-2">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" name="nombre" id="nombres" value="<?= $cliente['nombres']; ?>">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="mb-2">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?= $cliente['apellidos']; ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="mb-2">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direcccion" id="direccion" value="<?= $cliente['direccion']; ?>">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="mb-2">
                <label for="telefono" class="form-label">Móvil</label>
                <input type="number" class="form-control" name="telefono" id="telefono" value="<?= $cliente['telefono']; ?>">
              </div>
            </div>
          </div>
          <input type="submit" value="Editar" name="btnEditar" class="btn btn-primary">
        </form>
      </div>
    </div>
  </div>

  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/funciones.js"></script>
</body>
</html>