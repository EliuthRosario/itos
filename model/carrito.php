<?php 

require("../conexion.php");
require("./config.php");

if(isset($_POST['idProducto']) && isset($_POST['cantidad'])) {
    $idProducto = $_POST['idProducto'];
    $cantidad = intval($_POST['cantidad']);

    if(!empty($idProducto) && $cantidad > 0) {
        if(isset($_SESSION['carrito']['productos'][$idProducto])) {
            $_SESSION['carrito']['productos'][$idProducto] += $cantidad;
        } else {
            $_SESSION['carrito']['productos'][$idProducto] = $cantidad; 
        }

        $datos['numero'] = count($_SESSION['carrito']['productos']);
        $datos['ok'] = true;

    } else {
        $datos['ok'] = false;
    }

} else {
    $datos['ok'] = false;
}

echo json_encode($datos);

?>
