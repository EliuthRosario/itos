<?php 

//funcion para generar el token
function generarToken(){
    return md5(uniqid(mt_rand(), false));
}

//funcion para verificar que los valores no esten nulos
function esNulo(array $parametros){
    foreach($parametros as $parametro){
        if(strlen($parametro) < 1){
            return true;
        }
    }
    return false;
}

//funcion para validar que el email tenga la estructura correcta
function esEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

//funcion para validar que las contraseñas sean iguales
function validaPassword($password, $repassword){
    if(strcmp($password, $repassword) === 0){
        return true;
    }
    return false;
}

//funcion para insertar datos en la tabla cliente
function registrarCliente(array $datos, $con){
    $sql = $con->prepare("INSERT INTO clientes(tipoDocumento, numeroDocumento, nombres, apellidos, telefono, direccion, email) VALUES(?,?,?,?,?,?,?)");
    if($sql->execute($datos)){
        return $con->insert_id;
    }else{
        return 0;
    }
}

//funcion para insertar datos en la tabla usuario
function registrarUsuario(array $datos, $con){
    $sql = $con->prepare("INSERT INTO usuarios(usuario, contrasena, token, idCliente) VALUES(?,?,?,?)");
    if($sql->execute($datos)){
        return $con->insert_id;
    }
    return 0;
}

//funcion para verificar si el usuario ya existe en la BD
function usuarioExiste($usuario, $con){
    $sql = $con->prepare("SELECT idUsuario FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $res = $sql->get_result();
    if($res->num_rows > 0){
        return true;
    }
    return false;
}

//funcion para verificar si el email ya existe en la BD
function emailExiste($email, $con){
    $sql = $con->prepare("SELECT idCliente FROM clientes WHERE email LIKE ? LIMIT 1");
    $sql->execute([$email]);
    $res = $sql->get_result();
    if($res->num_rows > 0){
        return true;
    }
    return false;
}

//funcion para mostrar mensajes al usario en caso de errores
function mostrarMensajes(array $errors){
    if(count($errors) > 0){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '<ul>';
            foreach($errors as $error){
                echo '<li>'. $error .'</li>';
            }
            echo '</ul>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
}

//funcion para verificar si el token coincide
function verificarToken($idUsuario, $token, $con){
    $msg = '';
    $sql = $con->prepare("SELECT idUsuario FROM usuarios WHERE idUsuario = ? AND token LIKE ?");
    $sql->execute([$idUsuario, $token]);
    $res = $sql->get_result();
    if($res->num_rows > 0){
        if (activarUsuario($idUsuario, $con)) {
            $msg = 'Cuenta activada';
        } else {
            $msg = 'Error al activar la cuenta';
        }
    } else {
        $msg = 'No existe el registro del usuario';
    }
    return $msg;
}

//funcion para activar el usuario
function activarUsuario($idUsuario, $con) {
    $sql = $con->prepare("UPDATE usuarios SET estado = 1 WHERE idUsuario = ?");
    return $sql->execute([$idUsuario]);
}

//funcion para validar si el usuario existe y la contraseña coincide
function login($usuario, $password, $con, $proceso) {
    $sql = $con->prepare("SELECT u.idUsuario,  u.contrasena, u.usuario, u.idCliente, c.nombres, c.apellidos FROM usuarios u, clientes c WHERE u.usuario LIKE ? AND u.idCliente = c.idCliente");
    $sql->execute([$usuario]);
    $result = $sql->get_result();
    if ($row = $result->fetch_assoc()) {
        if (esActivo($usuario, $con)) {
            $coincide = password_verify($password, $row['contrasena']);
            if ($coincide) {
                $_SESSION['idUsuario'] = $row['idUsuario'];
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['idCliente'] = $row['idCliente'];
                $_SESSION['nombres'] = $row['nombres'];
                $_SESSION['apellidos'] = $row['apellidos'];
                if ($proceso == 'pago') {
                    header('Location: ./carrito.php');
                } else {
                    header('Location: ./productos.php');
                }
                exit;
            }
        } else {
            return 'El usuario no ha sido activado';
        }
    }
    return 'El usuario y/o contraseña son incorrectos';
}

//funcion para validar si el usuario está activo
function esActivo($usuario, $con) {
    $sql = $con->prepare("SELECT estado FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $result = $sql->get_result();
    $row = $result->fetch_assoc();
    if ($row['estado'] == 1) {
        return true;
    }
    return false;
}

//funcion para recuperar la contraseña
function solicitarPassword($idUsuario, $con) {
    $token = generarToken();
    $sql = $con->prepare("UPDATE usuarios SET tokenPassword = ?, tokenRequest = 1 WHERE idUsuario = ?");
    if ($sql->execute([$token, $idUsuario])) {
        return $token;
    }
    return null;
}

//funcion para validar si el usuario solicito el cambio de contraseña
function verificarTokenRequest($idUsuario, $token, $con) {
    $sql = $con->prepare("SELECT idUsuario FROM usuarios WHERE idUsuario = ? AND tokenPassword LIKE ? AND tokenRequest = 1 LIMIT 1");
    $sql->execute([$idUsuario, $token]);
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        return true;
    }
    return false;
}

//funcion para actualizar la contraseña
function actualizarPassword($idUsuario, $password, $con) {
    $sql = $con->prepare("UPDATE usuarios SET contrasena =?, tokenPassword = '', tokenRequest = 0 WHERE idUsuario = ?");
    if ($sql->execute([$password, $idUsuario])) {
        return true;
    }
    return false;
}

//funcion para generar un identificador único
function generateGUID() {
    if (function_exists('com_create_guid')) {
        // En sistemas Windows
        return trim(com_create_guid(), '{}');
    } else {
        // En sistemas no Windows
        mt_srand((double) microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        return $uuid;
    }
}

//funcion para general la contraseña utilizando el guid
function generatePassword($guid, $length = 12) {
    // Eliminar guiones del GUID
    $cleanGUID = str_replace('-', '', $guid);
    // Truncar el GUID a la longitud deseada
    $password = substr($cleanGUID, 0, $length);
    return $password;
}

//funcion para cifrar la contraseña utilizando el password
function securePassword($password) {
    // Generar un salt aleatorio
    $salt = bin2hex(random_bytes(16));
    // Aplicar un hash seguro (por ejemplo, bcrypt)
    $hashedPassword = password_hash($password . $salt, PASSWORD_BCRYPT);
    return $hashedPassword;
}

?>