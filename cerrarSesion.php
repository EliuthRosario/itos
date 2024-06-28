<?php 

session_start();
unset($_SESSION['idUsuario']);
unset($_SESSION['usuario']);
unset($_SESSION['idCliente']);
$_SESSION['mensaje'] = 'sessionClosed';

header('Location: index.php');