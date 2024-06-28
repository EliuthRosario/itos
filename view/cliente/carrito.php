<?php 

require("../../conexion.php");
require("../../model/config.php");
// session_destroy();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$listaCarrito = array();
if($productos != null){
  foreach($productos as $clave => $cantidad){
    $query = "SELECT idProducto, nombreProducto, descripcion, precio, descuento, $cantidad AS cantidad FROM productos WHERE idproducto = '$clave' ";
    $queryRun = mysqli_query($con, $query);
    $listaCarrito[] = mysqli_fetch_array($queryRun);
  }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <title>Carrito</title>
</head>
<body>

    <!--barra de navegación-->
    <header class="header">
      <a href="#" class="logo">
        <i class="bi bi-basket-fill"></i> Itos
      </a>
      <nav class="nav-bar">
        <a href="../../index.php" class="link">Inicio</a>
        <a href="../../index.php#about" class="link">Sobre nosotros</a>
        <a href="../../index.php#services" class="link">Servicios</a>
        <a href="./productos.php" class="link">Productos</a>
        <a href="#" class="link" data-bs-toggle="modal" data-bs-target="#modalContacto">Contacto</a>
      </nav>

      <div class="icons">
        <?php if (isset($_SESSION['idUsuario'])) { ?>
          <a href="#" class="me-1" id="btn-user" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <small class="text-dark">
              <?= $_SESSION['nombres'] .' '. $_SESSION['apellidos']; ?>
              <i class="bi bi-chevron-down"></i>
            </small>
          </a>
          <ul class="dropdown-menu" aria-labelledby="btn-user">
            <li><a class="dropdown-item" href="./perfil.php">Mi cuenta</a></li>
            <li><a class="dropdown-item" href="./compras.php">Mis compras</a></li>
            <li><a class="dropdown-item text-danger" href="../../cerrarSesion.php">Cerrar sesión</a></li>
          </ul> 
        <?php } else { ?>
          <a href="./view/cliente/login.php" class="btn btn-primary text-sm-center" id="btn-user">
            <i class="bi bi-person"></i>
          </a>  
        <?php } ?>  
        <a href="#" class="btn btn-danger" id="btn-car">
          <i class="bi bi-cart"></i>
          <span class="num-cart mt-0" id="num-cart">
            <?php echo $numCart; ?>
          </span>
        </a>
        <a href="#" class="btn btn-secondary" id="btn-menu">
          <i class="bi bi-list"></i>
        </a>
      </div>
    </header>

    <!--start menu-mobile-->
    <div class="menu-mobile" id="menu-mobile">
      <div class="menu-mobile-content">
        <div class="menu-mobile-header">
          <div class="mobile-logo">
            <i class="bi bi-basket-fill"></i> Itos
          </div>
          <span class="mobile-close text-white" id="btn-close"><i class="bi bi-x"></i></span>
        </div>
        <div class="menu-mobile-body">
          <nav class="menu-options">
            <a href="../../index.php" class="option"><i class="bi bi-house"></i> Inicio</a>
            <a href="../../index.php#about" class="option"><i class="bi bi-info-circle"></i> Sobre nosotros</a>
            <a href="./productos.php" class="option">
              <i class="bi bi-cart"></i> Productos
            </a>
            <a href="#" class="option" data-bs-toggle="modal" data-bs-target="#modalContacto">
              <i class="bi bi-telephone"></i> Contacto
            </a>
          </nav>
        </div>
        <div class="menu-mobile-footer">
          <a href="https:/api.whatsapp.com/send?phone=3116173098" target="_blank"><i class="bi bi-whatsapp"></i></a>
          <a href="https://www.facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/erosariohernandez/" target="_blank"><i class="bi bi-instagram"></i></a>
          <a href="https://twitter.com" target="_blank"><i class="bi bi-twitter"></i></a>
        </div>
      </div>
    </div>
    <!-- end menu-mobile -->

    <?php include '../components/contacto.php'; ?>

    <!--Productos-->
    <main class="main w-100">
      <div class="container mt-4">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if ($listaCarrito == null) { ?>
              <tr>
                <td colspan="5" class="text-center">
                  <b>Carrito vacío</b>
                </td>
              </tr>
              <?php 
              } else {
                $total = 0;
                foreach ($listaCarrito as $producto){
                  $idProducto = $producto['idProducto'];
                  $nombre = $producto['nombreProducto'];
                  $descripcion = $producto['descripcion'];
                  $precio = $producto['precio'];
                  $descuento = $producto['descuento'];
                  $precioFinal = $precio - (($precio * $descuento) / 100);
                  $cantidad = $producto['cantidad'];
                  $subtotal = $cantidad * $precioFinal;
                  $total += $subtotal;
              ?>
              <tr>
                <td><?= $nombre; ?></td>
                <td><?= MONEDA . number_format($precioFinal, 2, '.', ','); ?></td>
                <td>
                  <input type="number" min="1" max="10" step="1" value="<?= $cantidad; ?>" size="5" 
                  id="cantidad-<?= $idProducto; ?>" onchange="actualizarCantidad(this.value, <?= $idProducto; ?>)">
                </td>
                <td>
                  <div id="subtotal-<?= $idProducto; ?>" name="subtotal[]">
                    <?= MONEDA . number_format($subtotal, 2, '.', ','); ?>
                  </div>
                </td>
                <td>
                  <a href="#" class="btn btn-danger btn-sm" id="eliminar" data-bs-idProducto="<?= $idProducto; ?>" data-bs-toggle="modal" data-bs-target="#eliminarProducto">
                    Eliminar
                  </a>
                </td>
              </tr>
              <?php 
                }
              ?>
              <tr>
                <td colspan="3"></td>
                <td colspan="2">
                  <p class="h3" id="total"><?= MONEDA . number_format($total, 2, '.', ','); ?></p>
                </td>
              </tr>
              <?php 
              }
              ?>
            </tbody>
          </table>
        </div>
        <?php 
        if($listaCarrito != null){ ?>
        <div class="row">
          <div class="col-md-3 offset-md-7 d-grid gap-2">
            <?php if (isset($_SESSION['idCliente'])) { ?>
              <a href="./pago.php" class="btn btn-success">Realizar pago</a>
            <?php } else { ?>  
              <a href="./login.php?pago" class="btn btn-success">Realizar pago</a>
            <?php } ?>  
          </div>
        </div>
        <?php 
        } 
        ?>
      </div>
    </main>

    <!--Modal para eliminar productos de carrito-->
    <div class="modal fade" id="eliminarProducto" tabindex="-1" role="dialog" aria-labelledby="eliminarProductoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="eliminarProductoLabel">
              Alerta
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ¿Desea eliminar el producto del carrito?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              Cerrar
            </button>
            <button id="btn-eliminar" type="button" class="btn btn-danger" onclick="Eliminar()">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
    

    <!--Boton para ir hacia arriba-->
    <div class="btn-top" id="btn-top">
      <i class="bi bi-chevron-up"></i>
    </div>

    <!--Boton para ir a Whatsaap-->
    <div class="btn-whatsapp">
      <a href="#" target="_blank"><i class="bi bi-whatsapp"></i></a>
    </div>
    
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/funciones.js"></script>

    <script>

      let eliminarProducto = document.getElementById('eliminarProducto');
      eliminarProducto.addEventListener("show.bs.modal", (e) => {
        let button = e.relatedTarget;
        let idProducto = button.getAttribute('data-bs-idProducto');
        let buttonEliminar = eliminarProducto.querySelector('.modal-footer #btn-eliminar');
        buttonEliminar.value = idProducto;
      });

      //funcion para eliminar productos en el carrito
      function Eliminar(){
        let botonEliminar = document.getElementById('btn-eliminar');
        idProducto = botonEliminar.value;

        let url = '../../model/actualizarCarrito.php';
        let formData = new FormData();
        formData.append('action', 'eliminar');
        formData.append('idProducto', idProducto);
        fetch(url, {
          method: 'POST',
          body: formData, 
          mode: 'cors'
        })
        .then(response => response.json())
        .then(data => {
          if(data.ok){
            location.reload();
          }
        })
      }

      //funcion para actualizar la cantidad de productos en el carrito
      function actualizarCantidad(cantidad, idProducto){
        let url = '../../model/actualizarCarrito.php';
        let formData = new FormData();
        formData.append('action', 'agregar');
        formData.append('idProducto', idProducto);
        formData.append('cantidad', cantidad);
        fetch(url, {
          method: 'POST',
          body: formData, 
          mode: 'cors'
        }).then(response => response.json())
        .then(data => {
          if(data.ok){
            let subtotal =  document.getElementById('subtotal-'+idProducto);
            subtotal.innerHTML = data.sub;

            let total = 0.00;
            let list = document.getElementsByName('subtotal[]');
            for(let i = 0; i < list.length; i++){
              total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''));
            }

            total = new Intl.NumberFormat('en-US', {
              minimumFractionDigits: 2
            }).format(total);
            document.getElementById('total').innerHTML = '<?= MONEDA; ?>' + total; 

          }
        })
      }

    </script>

</body>
</html>