<?php 

require "../../conexion.php" ;
require "../../model/cliente.php";

$datos = [];

if(isset($_POST['action'])){
    $action = $_POST['action'];

    if($action == 'existeUsuario'){
        $datos['ok'] = usuarioExiste($_POST['usuario'], $con);
    }elseif($action == 'existeEmail'){
        $datos['ok'] = emailExiste($_POST['email'], $con);
    }
}

echo json_encode($datos);

?>