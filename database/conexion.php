<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'tienda_itos';

$con = new mysqli($host, $username, $password, $dbname);

if(!$con){
    echo "<h5>Error en la conexión con la base de datos</h5>";
}

?>