<?php

require("../../conexion.php");
require("../../model/cliente.php");
require '../../model/config.php';

$errors = [];

if(!empty($_POST)){
  //capturamos los valores enviados en el formulario por el metodo POST
  $tipoDocumento = $_POST['tipoDocumento'];
  $numeroDocumento = $_POST['numeroDocumento'];
  $nombres = $_POST['nombres'];
  $apellidos = $_POST['apellidos'];
  $direccion = $_POST['direccion'];
  $movil = $_POST['movil'];
  $email = $_POST['email'];
  $usuario = $_POST['usuario'];
  $password = $_POST['password'];
  $repassword = $_POST['repassword'];

  if(esNulo([$tipoDocumento, $numeroDocumento, $nombres, $apellidos, $movil, $email, $direccion, $usuario, $password, $repassword])){
    $errors[] = "Debe llenar todos los campos";
  }

  if(!esEmail($email)){
    $errors[] = "El email no es válido";
  }

  if(!validaPassword($password, $repassword)){
    $errors[] = "Las contraseñas no coinciden";
  }

  if(usuarioExiste($usuario, $con)){
    $errors[] = "El usuario $usuario ya existe";
  }

  if(emailExiste($email, $con)){
    $errors[] = "El correo electronico $email ya existe";
  }

  if(count($errors) == 0){
    //llamamos a la funcion para registrar al cliente 
    $idCustomer = registrarCliente([$tipoDocumento, $numeroDocumento, $nombres, $apellidos, $movil, $direccion, $email], $con);

    if($idCustomer > 0){
      require '../../model/mailer.php';
      $mailer = new Mailer();

      $token = generarToken();
      $passHash = password_hash($password, PASSWORD_DEFAULT);
      // llamamos a la funcion para registar el usuario
      $idUsuario = registrarUsuario([$usuario, $passHash, $token, $idCustomer], $con);

      if($idUsuario > 0){
        $url = SITE_URL . '/activarCuenta.php?idUsuario=' . $idUsuario .'&token=' . $token;
        $asunto = 'Activar cuenta - Tienda Itos';
        $cuerpo = "Hola $nombres: <br> para finalizar la activacion de la cuenta entra al siguiente link: <a href='$url'>Activar cuenta</a>";

        if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
          echo "<script>alert('Para terminar con el proceso de registro revise su correo electronico: $email'); window.location.href='registro.php'</script>";
          exit();
        }
      } else {
        $errors[] = "Error al registrar el usuario";
      }

    }else{
      $errors[] = "Error al registrar el cliente";
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
    <title>Crear cuenta</title>
</head>

<style>
  #icono{
    position: absolute;
    right: 102px;
    bottom: 5px;
    cursor: pointer;
    font-size: 20px;
  }
</style>
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
        <a href="./login.php" class="btn btn-primary text-sm-center" id="btn-user">
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

  <!--Formulario para crear una cuenta-->
  <div class="container mb-4">
    <h3 class="text-center mt-4">Crear cuenta</h3>
    <?php mostrarMensajes($errors);  ?>
    <form action="" class="row g-3 position-relative form-registro" method="post" autocomplete="off">
      <div class="col-sm-12 col-md-6">
        <label for="tipoDocumento"><span class="text-danger form-label">*</span> Tipo de documento</label>
        <select name="tipoDocumento" id="tipoDocumento" class="form-select" required>
          <option value="">Seleccione</option>
          <option value="cedulaCiudadania">Cédula de ciudadanía</option>
          <option value="cedulaExtranjeria">Cédula de extranjería</option>
          <option value="nit">NIT</option>
        </select>
      </div>
      <div class="col-sm-12 col-md-6">
        <label for="numeroDocumento"><span class="text-danger form-label">*</span>Numero de documento</label> 
        <input type="number" name="numeroDocumento" id="idCliente" class="form-control" required>
      </div>
      <div class="col-sm-12 col-md-6">
        <label for="nombres"><span class="text-danger form-label">*</span> Nombres</label> 
        <input type="text" name="nombres" id="nombres" class="form-control" required>
      </div>
      <div class="col-sm-12 col-md-6">
        <label for="apellidos"><span class="text-danger form-label">*</span> Apellidos</label> 
        <input type="text" name="apellidos" id="apellidos" class="form-control" required>
      </div>
      <div class="col-sm-12 col-md-6">
        <label for="direccion"><span class="text-danger form-label">*</span> Dirección</label> 
        <input type="text" name="direccion" id="direccion" class="form-control" required>
      </div>
      <div class="col-sm-12 col-md-6">
        <label for="movil"><span class="text-danger form-label">*</span> Móvil</label> 
        <input type="number" name="movil" id="movil" class="form-control" required>
      </div>
      <div class="col-sm-12 col-md-6">
        <label for="email"><span class="text-danger form-label">*</span> Email</label> 
        <input type="email" name="email" id="email" class="form-control" required>
        <span class="text-danger" id="validaEmail"></span>
      </div>
      <div class="col-sm-12 col-md-6">
        <label for="usuario"><span class="text-danger form-label">*</span> Usuario</label> 
        <input type="text" name="usuario" id="usuario" class="form-control" required>
        <span class="text-danger" id="validaUsuario"></span>
      </div>
      <div class="col-sm-12 col-md-6 position-relative">
        <label for="password"><span class="text-danger form-label">*</span> Contraseña</label> 
        <div class="d-flex position-relative">
          <input type="password" name="password" id="password" class="form-control me-2" required>
          <i class="bi bi-eye" id="icono"></i>
          <button type="button" class="btn btn-secondary" id="btn-generar">Generar</button>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 position-relative">
        <label for="repassword"><span class="text-danger form-label">*</span> Confirmar contraseña </label> 
        <input type="password" name="repassword" id="repassword" class="form-control" required>
        <span class="text-danger" id="validaPassword"></span>
      </div>
      <i><b>Nota: </b>Los campos con asterisco son obligatorios</i>
      <div class="col-12">
        <input type="submit" value="Guardar" class="btn btn-success d-flex m-auto">
        </div>
    </form>
  </div>

  <!--Botón para ir hacia arriba-->
  <div class="btn-top" id="btn-top">
    <i class="bi bi-chevron-up"></i>
  </div>
  
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/registro.js"></script>
  <script src="../../assets/js/funciones.js"></script>

  <script>
    let btnGenerar = document.getElementById('btn-generar');
    let btnView = document.querySelector('.bi-eye');
    let icono = document.getElementById('icono');
    let password = document.getElementById('password');
    let repassword = document.getElementById('repassword');
    let pas = true;

    btnView.addEventListener('click', () => {
      if (pas) {
        password.type = 'text';
        repassword.type = 'text';
        icono.classList.remove('bi-eye');
        icono.classList.add('bi-eye-slash');
        pas = false;
      } else {
        password.type = 'password';
        repassword.type = 'password';
        icono.classList.remove('bi-eye-slash');
        icono.classList.add('bi-eye');
        pas = true;
      }
    })

    btnGenerar.addEventListener('click', () => {
      getPassword();
    })

    //funcion para hacer una peticion y obtener la contraseña
    function getPassword() {
      let formData = new FormData();
      formData.append('action', 'generarPassword');
      let url = '../../assets/ajax/generarPassword.php';

      fetch(url, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        password.value = data;
        repassword.value = data;
      })
    }

  </script>
</body>
</html>