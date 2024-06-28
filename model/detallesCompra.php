<?php 

require '../conexion.php';
require './config.php';

$json = file_get_contents('php://input'); //capturamos los datos que se estan enviando
$datos = json_decode($json, true); //procesamos la informacion

if (is_array($datos)) {
    $idCliente = $_SESSION['idCliente'];
    $sqlCliente = $con->prepare("SELECT email FROM clientes WHERE idCliente = ?");
    $sqlCliente->execute([$idCliente]);
    $result = $sqlCliente->get_result();
    $cliente = $result->fetch_assoc();

    $idTransaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fechaCompra = date('Y-m-d H-i-s', strtotime($fecha));
    $email = $cliente['email'];
    //$email = $datos['detalles']['payer']['email_address'];
    //$idCliente = $datos['detalles']['payer']['payer_id'];

    $sql = $con->prepare("INSERT INTO factura(idTransaccion, fecha, estado, total, email, idCliente) VALUES(?,?,?,?,?,?)");
    $sql->execute([$idTransaccion, $fechaCompra, $status, $total, $email, $idCliente]);
    $id = $con->insert_id;

    if ($id > 0) {
        require './correoElectronico.php';
        $obj = new correoElectronico();

        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

        if ($productos != null) {
            foreach($productos as $clave => $cantidad) {
                $query = "SELECT idProducto, nombreProducto, descripcion, precio, descuento FROM productos WHERE idProducto = '$clave' ";
                $queryRun = mysqli_query($con, $query);
                $prod = mysqli_fetch_assoc($queryRun);

                $nombre = $prod['nombreProducto'];
                $precio = $prod['precio'];
                $descuento = $prod['descuento'];
                $precioFinal = $precio - (($precio * $descuento) / 100);
                $subtotal = $cantidad * $precioFinal;

                $sqlDetalles = $con->prepare("INSERT INTO detalles_factura (idFactura, idProducto, nombre, precio, cantidad, subtotal) VALUES (?,?,?,?,?,?)");
                $sqlDetalles->execute([$id, $clave, $nombre, $precioFinal, $cantidad, $subtotal]);
            }
            $cuerpo = '<h4>Gracias por su compra</h4>';
            $cuerpo .= '<p>El id de la compra es <b>' . $idTransaccion . '</b>';
            $asunto = 'Detalles de la compra';
            $obj->enviarEmail($email, $asunto, $cuerpo);
            
            $_SESSION['mensaje'] = 'compraExitosa';

        }
        // echo json_encode(array("id" => $id));
        unset($_SESSION['carrito']); 
    }
}