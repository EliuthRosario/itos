<?php 

function mensajes($mensaje) {
    $msg = '';
    if ($mensaje == 'compraExitosa') {
        $msg = 'Swal.fire("Correcto", "Compra exitosa", "success")';
    } elseif ($mensaje == 'sessionClosed') {
        $msg = 'Swal.fire("Informacion", "Cerraste la sesión", "info")';
    } elseif ($mensaje == 'saveProduct') {
        $msg = 'Swal.fire("Correcto", "Producto agregado", "success")';
    } elseif ($mensaje == 'updateProduct') {
        $msg = 'Swal.fire("Correcto", "Producto actualizado", "success")';
    } elseif ($mensaje == 'deleteProduct') {
        $msg = 'Swal.fire("Correcto", "Producto eliminado", "info")';
    }
    return $msg;
}

?>