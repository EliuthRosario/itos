<?php 

require "../../conexion.php";
require("../../model/config.php");

$productos = array(); 
$idCategoria = isset($_GET['idCategoria']) ? $_GET['idCategoria'] : 'todos';
if ($idCategoria == 'todos') {
  $categoriaNombre = "Todos los productos";
  $query = "SELECT * FROM productos";
  $queryRun = mysqli_query($con, $query);
  if (mysqli_num_rows($queryRun) > 0) {
    while ($row = mysqli_fetch_array($queryRun)){
      $productos[] = $row;
    }
  }
} else {
  $query = "SELECT p.idProducto, p.nombreProducto, p.precio, p.descuento, p.imagen, c.nombreCategoria FROM productos p JOIN categorias c ON p.idCategoria = c.idCategoria WHERE p.idCategoria=$idCategoria";
  $queryRun = mysqli_query($con, $query);
  if (mysqli_num_rows($queryRun) > 0) {
    while ($row = mysqli_fetch_array($queryRun)){
      $productos[] = $row;
      $categoriaNombre = $row['nombreCategoria'];
    }
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
  <title>Productos</title>
</head>
<body>

  <!--start barra de navegación-->
  <header class="header" id="header">
    <a href="#" class="logo">
      <i class="bi bi-basket-fill"></i> Itos
    </a>
    <nav class="nav-bar">
      <a href="../../index.php" class="link">Inicio</a>
      <a href="../../index.php#about" class="link">Sobre nosotros</a>
      <a href="../../index.php#services" class="link">Servicios</a>
      <a href="productos.php" class="link">Productos</a>
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
        <a href="./login.php" class="btn btn-primary text-sm-center" id="btn-user">
          <i class="bi bi-person"></i>
        </a>  
      <?php } ?>  
      <a href="carrito.php" class="btn btn-danger" id="btn-car">
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
  <!-- end barra de navegacion -->

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
          <a href="../../index.php" class="option option-link"><i class="bi bi-house"></i> Inicio</a>
          <a href="../../index.php#about" class="option option-link"><i class="bi bi-info-circle"></i> Sobre nosotros</a>
          <a href="./productos.php" class="option option-link">
            <i class="bi bi-cart"></i> Productos
          </a>
          <div class="option">
            <a href="#" class="option-categorys" data-bs-toggle="collapse" data-bs-target="#categorias" aria-expanded="false" aria-controls="contentId">
              <i class="bi bi-arrow-right"></i> Categorias <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="categorias">
              <ul>
                <li class="mt-3 mb-3">
                  <a href="productos.php?idCategoria=todos" class="category">Todos</a>
                </li>
                <?php 
                  $sql = $con->prepare("SELECT * FROM categorias");
                  $sql->execute();
                  $result = $sql->get_result();
                  if ($result->num_rows > 0) { 
                    while ($row = $result->fetch_assoc()) { ?>
                    <li class="mb-3">
                      <a href="productos.php?idCategoria=<?= $row['idCategoria']; ?>" class="category"><?= $row['nombreCategoria']; ?></a>
                    </li>
                <?php
                    }
                  }  
                ?>
              </ul>
            </div>
          </div>
          <a href="#" class="option option-link" data-bs-toggle="modal" data-bs-target="#modalContacto">
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

  <!-- start wrapper -->
  <div class="container-fluid p-0 wrapper">
    <!-- start aside -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <h6>Categoria de productos</h6>
      </div>
      <div class="sidebar-content">
        <div class="sidebar-categorys">
          <li class="sidebar-category">
            <a href="?idCategoria=todos"><i class="bi bi-arrow-right"></i> Todos los productos</a>
          </li>
          <?php 
          $sql = "SELECT * FROM categorias";
          $sqlRun = mysqli_query($con, $sql);
          if (mysqli_num_rows($sqlRun) > 0) {
            while ($categoria = mysqli_fetch_assoc($sqlRun)){
          ?>
          <li class="sidebar-category">
            <a href="productos.php?idCategoria=<?= $categoria['idCategoria']; ?>"><i class="bi bi-arrow-right"></i> <?= ucwords($categoria['nombreCategoria']); ?></a>
          </li>
          <?php 
            }
          } else {
            echo "No hay categorias";
          }
          ?>
        </div>
      </div>
    </aside>
    <!-- end aside -->

    <!-- start productos-->
    <main class="main">
      <div class="mt-4 contenedor-productos">
        <h5 class="text-center mt-4 mb-3 title-producto">
          <?= ucwords($categoriaNombre); ?>
        </h5>
        <div class="row mb-3 d-flex justify-content-center">
          <div class="col-12 col-sm-8 col-md-6">
            <input type="search" name="nombreProducto" id="nombreProducto" class="form-control" placeholder="buscar">
          </div>
        </div>
        <div class="mt-4 productos">
          <?php
          if (!empty($productos)) {
            foreach($productos as $producto){
            ?>
            <div class="item-producto">
              <div class="card shadow-sm">
                <img src="../<?= $producto['imagen']; ?>" width="" alt="imagen de . <?= $producto['nombreProducto']; ?>">
                <div class="card-body">
                  <h6 class="card-title"><?= $producto['nombreProducto']; ?></h6>
                  <?php
                  if ($producto['descuento'] > 0) { ?>
                    <p class="card-text">
                      <small><?= MONEDA . number_format($producto['precio'], 2, '.', ','); ?></small>
                      <small class="text-success"><?= $producto['descuento']; ?>% descuento</small>
                    </p>
                  <?php 
                  } else { ?>
                    <p class="card-text">
                      <small><?= MONEDA . number_format($producto['precio'], 2, '.', ','); ?></small>
                    </p>
                  <?php
                  }
                  ?>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <input type="number" id="cantidad-<?= $producto['idProducto']; ?>" class="form-control" value="1" min="1" max="10">
                    </div>
                    <button class="btn btn-danger" type="button" onclick="agregarProducto(<?= $producto['idProducto']; ?>, '<?= hash_hmac('sha1', $producto['idProducto'], KEY_TOKEN); ?>')">
                      <i class="bi bi-cart"></i>
                    </button>
                  </div>        
                </div>
              </div>
            </div>
          <?php
            }
          } else {
            echo '<span class="text-center">No hay productos en esta categoría</span>';
          } 
          ?>
        </div>
      </div>
    </main>
    <!-- end productos -->
  </div>
  <!-- end wrapper-->

  <!--Boton para ir hacia arriba-->
  <div class="btn-top" id="btn-top">
    <i class="bi bi-chevron-up"></i>
  </div>

  <!--Boton para ir a Whatsaap-->
  <div class="btn-whatsapp">
    <a href="#" target="_blank"><i class="bi bi-whatsapp"></i></a>
  </div>

  <?php include '../components/footer.php'; ?>
  
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="../../assets/js/productos.js"></script>
  <script src="../../assets/js/busqueda.js"></script>

  <script>
    //funcion para agregar al carrito
    function agregarProducto(idProducto, token) {
      let url = '../../model/carrito.php';
      let cantidad = document.getElementById('cantidad-' + idProducto).value;

      let formData = new FormData();
      formData.append('idProducto', idProducto);
      formData.append('token', token);
      formData.append('cantidad', cantidad);

      fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
      }).then(response => response.json())
      .then(data => {
        if(data.ok){
          console.log(data);
          let elemento =  document.getElementById('num-cart');
          elemento.innerHTML = data.numero;
          //document.getElementById('cantidad-' + idProducto).value = 1;
        }
      })
    }
  </script>

</body>
</html>
