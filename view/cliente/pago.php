<?php 

//session_start();
require("../../conexion.php");
require("../../model/config.php");

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$listaCarrito = array();
if ($productos != null) {
  foreach($productos as $clave => $cantidad){
    $query = "SELECT idProducto, nombreProducto, descripcion, precio, descuento, $cantidad AS cantidad FROM productos WHERE idProducto = '$clave' ";
    $queryRun = mysqli_query($con, $query);
    $listaCarrito[] = mysqli_fetch_array($queryRun);
  }
} else {
  header("Location: productos.php");
  exit;
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
    <title>Pago</title>
</head>
<body>

    <!--barra de navegación-->
    <header class="header">
      <a href="#" class="logo">
        <i class="bi bi-basket-fill"></i> Itos
      </a>
      <nav class="nav-bar" class="link">
        <a href="../../index.php" class="link">Inicio</a>
        <a href="./productos.php" class="link">Productos</a>
        <a href="#" class="link" data-bs-toggle="modal" data-bs-target="#modalContacto">Contacto</a>
      </nav>

      <div class="icons">
        <a href="login.html" target="_blank" class="btn btn-primary" id="btn-user"><i class="bi bi-person"></i></a>
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

    <!-- Modal  para menu responsivo-->
    <div class="modal fade" id="modalMenu"tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
      <div class="modal-dialog modal-menu" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <a href="#" class="logo">
              <i class="bi bi-basket-fill"></i> Itos
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <i class="bi bi-x"></i>
            </button>
          </div>
          <div class="modal-body">
            <div class="modal-line">
              <a href="#"><i class="bi bi-house"></i> Inicio</a>
            </div>
            <div class="modal-line">
              <a href="#"><i class="bi bi-info-circle"></i> Sobre nosotros</a>
            </div>
            <div class="modal-line">
              <a href="#"><i class="bi bi-cart"></i> Productos</a>
            </div>
            <div class="modal-line">
              <a href="#"><i class="bi bi-telephone"></i> Contacto</a>
            </div>
          </div>
          <div class="mobile-modal-footer">
            <a href="#" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="#" target="_blank"><i class="bi bi-twitter"></i></a>
            <a href="#" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="#" target="_blank"><i class="bi bi-whatsapp"></i></a>
          </div>
        </div>
      </div>
    </div>

    <?php include '../components/contacto.php'; ?>

    <!--Productos-->
    <main class="main mt-4 w-100">
      <div class="container mt-4">
        <div class="row">
          <div class="col-12 col-md-6">
            <h4>Detalles del pago</h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Subtotal</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if($listaCarrito == null){?>
                  <tr>
                    <td colspan="5" class="text-center">
                      <b>Carrito vacío</b>
                    </td>
                  </tr>
                  <?php 
                  }else{
                    $total = 0;
                    foreach ($listaCarrito as $producto){
                      $idProducto = $producto['idProducto'];
                      $nombre = $producto['nombreProducto'];
                      $descripcion = $producto['descripcion'];
                      $precio = $producto['precio'];
                      $descuento = $producto['descuento'];
                      $cantidad = $producto['cantidad'];
                      $precioFinal = $precio - (($precio * $descuento) / 100);
                      $subtotal = $cantidad * $precioFinal;
                      $total += $subtotal;
                  ?>
                  <tr>
                    <td><?= $nombre; ?></td>
                    <td>
                      <div id="subtotal-<?= $idProducto; ?>" name="subtotal[]">
                        <?= MONEDA . number_format($subtotal, 2, '.', ','); ?>
                      </div>
                    </td>
                  </tr>
                  <?php 
                    }
                  ?>
                  <tr>
                    <td colspan="2">
                      <p class="h3 text-end" id="total"><?= MONEDA . number_format($total, 2, '.', ','); ?></p>
                    </td>
                  </tr>
                  <?php 
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <!-- Set up a container element for the button -->
            <div id="paypal-button-container"></div>
          </div> 
        </div>
      </div>
    </main>
    
    <!--Boton para ir hacia arriba-->
    <div class="btn-top" id="btn-top">
      <i class="bi bi-arrow-up"></i>
    </div>

    <!--Boton para ir a Whatsaap-->
    <div class="btn-whatsapp">
      <a href="#" target="_blank"><i class="bi bi-whatsapp"></i></a>
    </div>

    <!-- PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=<?= CLIENT_ID; ?>"></script>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/funciones.js"></script>

    <script>
      paypal.Buttons({
        style:{
          shape: 'pill',
          label: 'pay'
        },
        createOrder: function(data, actions){
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: <?= $total; ?>
              }
            }]
          });
        },

        onApprove: function(data, actions){
          actions.order.capture().then(function(detalles){
            //window.location.href="pago.php"
            const url = '../../model/detallesCompra.php';
            console.log(detalles);
            fetch(url, {
              method: 'post',
              headers: {
                'content-type': 'application/json'
              },
              body: JSON.stringify({
                detalles: detalles
              })
            }).then(function(response) {
              window.location.href = 'completado.php?id='+detalles['id'];
            });
          });
        },

        onCancel: function(data){
          alert("Pago cacelado")
        }

      }).render('#paypal-button-container')
    </script>

</body>
</html>