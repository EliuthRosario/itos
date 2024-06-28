<?php

require("../../conexion.php");
require("../../model/cliente.php");
require '../../model/config.php';

$errors = [];

$idUsuario = $_GET['idUsuario'] ?? $_POST['idUsuario'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if ($idUsuario == '' || $token == '') {
  header('Location: ../../index.php');
  exit;
}

if (!verificarTokenRequest($idUsuario, $token, $con)) {
  echo "No se pudo validar la informacion";
  exit;
}

if ($_POST) {
  $password = trim($_POST['password']);
  $repassword = trim($_POST['repassword']);

  if (esNulo([$password, $repassword])) {
    $errors[] = 'Debe llenar todos los campos';
  }

  if (!validaPassword($password, $repassword)) {
    $errors[] = 'Las contraseñas no coinciden';
  }

  if (count($errors) == 0) {
    $passHash = password_hash($password, PASSWORD_DEFAULT);
    if (actualizarPassword($idUsuario, $passHash, $con)) {
      echo "<script>alert('Contraseña actualizada correctamente'); window.location.href='./login.php';</script>";
      exit;
    } else {
      $errors[] = 'Error al modificar la contraseña. Intentalo de nuevo';
    }
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
    <title>Restaurar contraseña</title>
</head>
<body>
  <!--barra de navegación-->
  <header class="header">
    <a href="#" class="logo">
      <i class="bi bi-basket-fill"></i> Itos
    </a>
    <nav class="nav-bar">
      <a href="../../index.php" class="link active">Inicio</a>
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
        <a href="./login.php" class="btn btn-primary text-sm-center" id="btn-user">
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
          <a href="../../index.php" class="option"><i class="bi bi-house"></i> Inicio</a>
          <a href="../../index.php#about" class="option"><i class="bi bi-info-circle"></i> Sobre nosotros</a>
          <a href="./productos.php" class="option"><i class="bi bi-cart"></i> Productos</a>
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

  <!-- formulario para ingresar nueva contraseña -->
  <form action="" method="post" class="login" autocomplete="off">
    <h3 class="text-center mb-4">Cambio de contraseña</h3>
    <?php mostrarMensajes($errors);  ?>
    <input type="hidden" name="idUsuario" value="<?= $idUsuario; ?>">
    <input type="hidden" name="token" value="<?= $token; ?>">
    <div class="form-floating mb-4">
      <input type="password" class="form-control" name="password" id="password" required/>
      <label for="user">Nueva contraseña</label>
    </div>
    <div class="form-floating mb-4">
      <input type="password" class="form-control" name="repassword" id="repassword" required/>
      <label for="user">Confirmar contraseña</label>
      <span class="text-danger" id="validaPassword"></span>
    </div>
    <div class="d-flex justify-content-center">
      <input type="submit" class="btn btn-success" name="btnRestaurar" id="btnRestaurar" value="Guardar">
    </div>
  </form>
  
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/funciones.js"></script>

  <script>
    let txtPassword = document.getElementById('password');
    let txtRepassword = document.getElementById('repassword');
    txtRepassword.addEventListener('blur', () => {
      validarPassword(txtPassword.value, txtRepassword.value);
    });

    function validarPassword(password, repassword) {
      if (password != repassword) {
        document.getElementById('validaPassword').innerHTML = 'Las contraseñas no coinciden';
      } else {
        document.getElementById('validaPassword').innerHTML = '';
      }
    }
  </script>
  
</body>
</html>