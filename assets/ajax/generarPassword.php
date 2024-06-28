<?php 

require '../../model/cliente.php';

$datos = [];

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == 'generarPassword') {
        $guid = generateGUID();
        $password = generatePassword($guid);
        $datos[] = $password;
    }
}

echo json_encode($datos);