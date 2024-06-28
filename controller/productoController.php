<?php

session_start();
require '../conexion.php';
require '../model/producto.php';

$model = new Producto();

//agregar un producto
if ($_POST['btnAgregar']) {
    $nombre = $_POST['nombreProducto'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $imagen = $_FILES['imagen']['name'];
    $imagenTemp = $_FILES['imagen']['tmp_name'];
    $rutaImagen = '../img/images_products/' . $imagen;
    $descripcion = $_POST['descripcion'];
    $idCategoria = $_POST['categoria'];

    $result = $model->saveProduct([$nombre, $precio, $descuento, $rutaImagen, $descripcion, $idCategoria], $con);

    if ($result > 0) {
        // move_uploaded_file($imagenTemp, $rutaImagen);
        $_SESSION['mensaje'] = 'saveProduct';
        header('Location: ../view/admin/productos.php');
    } else {
        echo '<script>alert("Error al guardar el producto"; window.location.href="../view/admin/productos.php")</script>';
    }
}


//editar un producto
if ($_POST['btnEditar']) {
    $idProducto = $_POST['idProducto'];
    $nombre = $_POST['nombreProducto'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $imagen = $_FILES['imagen']['name'];
    $imagenTemp = $_FILES['imagen']['tmp_name'];
    $rutaImagen = '../img/images_products/' . $imagen;
    $descripcion = $_POST['descripcion'];
    $idCategoria = $_POST['categoria'];

    $result = $model->updateProduct([$nombre, $precio, $descuento, $rutaImagen, $descripcion, $idCategoria, $idProducto], $con);

    if ($result > 0) {
        // move_uploaded_file($imagenTemp, $rutaImagen);
        $_SESSION['mensaje'] = 'updateProduct';
        header('Location: ../view/admin/productos.php');
    } else {
        echo '<script>alert("Error al editar el producto"; window.location.href="../view/admin/productos.php")</script>';
    }
}


//eliminar un producto
if ($_POST['btnEliminar']) {
    $idProducto = $_POST['idProducto'];
    $result = $model->deleteProduct([$idProducto], $con);
    if ($result) {
        $_SESSION['mensaje'] = 'deleteProduct';
        header('Location: ../view/admin/productos.php');
    } else {
        echo '<script>alert("Error al eliminar el producto"; window.location.href="../view/admin/productos.php")</script>';
    }
}