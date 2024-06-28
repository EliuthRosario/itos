<?php

class Producto {

    //funcion para obtener todos los productos
    public function getProducts ($con) {
        $data = array();
        $sql = $con->prepare("SELECT * FROM productos");
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data [] = $row;
            }
        }
        return $data;
    } 

    //funcion para obtener un producto
    public function getOneProduct ($id, $con) {
        $data = array();
        $sql = $con->prepare("SELECT * FROM productos WHERE idProducto = ?");
        $sql->execute($id);
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data [] = $row;
            }    
        }
        return $data;
    }

    //funcion para agregar productos
    public function saveProduct (array $datos, $con) {
        $sql = $con->prepare("INSERT INTO productos(nombreProducto, precio, descuento, imagen, descripcion, idCategoria) VALUES(?,?,?,?,?,?)");
        if ($sql->execute($datos)) {
            return $con->insert_id;
        } else {
            return 0;
        }
    }

    //funcion para actualizar un producto
    public function updateProduct (array $datos, $con) {
        $sql = $con->prepare("UPDATE productos SET nombreProducto = ?, precio = ?, descuento = ?, imagen = ?, descripcion = ?, idCategoria = ? WHERE idProducto = ?");
        $result = $sql->execute($datos);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //funcion para eliminar un producto
    public function deleteProduct ($idProducto, $con) {
        $sql = $con->prepare("DELETE FROM productos WHERE idProducto = ?");
        $result = $sql->execute($idProducto);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
