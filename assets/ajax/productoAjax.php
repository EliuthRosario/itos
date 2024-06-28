<?php 

require '../../conexion.php';

$producto = [];

if ($_POST['idProducto']) {
    $idProducto = $_POST["idProducto"];

    $query = "SELECT idProducto, nombreProducto, precio, descuento, imagen, descripcion, idCategoria FROM productos WHERE idProducto = '$idProducto'";
    $result = $con->query($query);
    $rows = $result->num_rows;

    if ($rows > 0) {
        $producto = $result->fetch_array();     
    }
}

echo json_encode($producto, JSON_UNESCAPED_UNICODE); 


?>