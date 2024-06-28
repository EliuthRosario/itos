<?php

require '../../conexion.php';
session_start();

if (isset($_POST['btnIngresar'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = $con->prepare("SELECT idAdmin, nombres, apellidos, password FROM administrador WHERE usuario = ?");
  $sql->execute([$username]);
  $result = $sql->get_result();
  if ($result->num_rows > 0) {
      if ($row = $result->fetch_assoc()) {
          $coincide = password_verify($password, $row['password']);
          if ($coincide) {
            $_SESSION['idAdmin'] = $row['idAdmin'];
            $_SESSION['nombres'] = $row['nombres'];
            $_SESSION['apellidos'] = $row['apellidos'];
            $_SESSION['usuario'] = $username;
            header('Location: ./productos.php');
            exit;
          } 
      } else {
        return 'El usuario no existe';
      }
  } else {
      return 'El usuario o contraseña son incorrectos';
  }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <title>Login</title>
</head>
<body>
  <div class="container">
    <div class="row d-flex justify-content-center align-items-center mt-4">
      <div class="col-10 col-sm-6 col-md-4">
        <h4 class="text-center">Inicio de sesión</h4>
        <form action="" method="post">
          <div class="mb-2">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="user2024" required>
          </div>
          <div class="mb-2">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="******" required>
          </div>
          <div class="d-flex justify-content-center">
            <input type="submit" name="btnIngresar" value="Ingresar" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>
  
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>