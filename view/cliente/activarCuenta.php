<?php

require '../../conexion.php';
require '../../model/config.php';
require '../../model/cliente.php';

$idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($idUsuario == '' || $token == '') {
    header('Location: ../../index.php');
    exit;
} 

$result = verificarToken($idUsuario, $token, $con);

if ($result) {
    echo "<script>alert('$result'); window.location.href='./login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Activar cuenta</title>
</head>
<body>
  
</body>
</html>