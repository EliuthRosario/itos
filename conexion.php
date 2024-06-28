<?php 

$con = mysqli_connect("localhost", "root", "", "tienda_itos");

if(!$con){
    echo "<h5>Error en la conexion con la base de datos</h5>";
}

