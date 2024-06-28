<?php

require("../conexion.php");
require("./config.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $idProducto = isset($_POST['idProducto']) ? $_POST['idProducto'] : 0;

    if ($action == 'agregar') {
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = agregar($idProducto, $cantidad);
        if ($respuesta > 0) {
            $datos['ok'] = true;
        } else {
            $datos['ok'] = false;
        }
        $datos['sub'] = MONEDA . number_format($respuesta, 2, '.', ',');
    } else if ($action == 'eliminar') {
        $datos['ok'] = eliminar($idProducto);
    } else {
        $datos['ok'] = false;
    }
} else {
    $datos['ok'] = false;
}

echo json_encode($datos);

//funcion para agregar al carrito
function agregar($idProducto, $cantidad){
    require("../conexion.php");
    $res = 0;
    if($idProducto > 0 && $cantidad > 0 && is_numeric($cantidad)){
        if(isset($_SESSION['carrito']['productos'][$idProducto])){
            $_SESSION['carrito']['productos'][$idProducto] = $cantidad;

            $query = "SELECT * FROM productos WHERE idproducto = '$idProducto' LIMIT 1";
            $queryRun = mysqli_query($con, $query);
            $producto = mysqli_fetch_assoc($queryRun);
            $precio = $producto['precio'];
            $descuento = $producto['descuento'];
            $precioFinal = $precio - (($precio * $descuento) / 100);
            $res = $cantidad * $precioFinal;

            return $res;    
        }
    }else{
        return $res;
    }
}

//funcion para eliminar productos del carrito
function eliminar($idProducto){
    if($idProducto > 0){
        if(isset($_SESSION['carrito']['productos'][$idProducto])){
            //eliminamos con la funcion unset del carrito
            unset($_SESSION['carrito']['productos'][$idProducto]);
            return true;
        }else{
            return false;
        }
    }
}


?>