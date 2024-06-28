<?php 

require '../../conexion.php';
require '../../model/config.php';
require '../../model/producto.php';
require '../../model/mensajes.php';

if (empty($_SESSION['idAdmin'])) {
    header('Location: ./login.php');
}

$mensaje = '0';
if (isset($_SESSION['mensaje'])) {
    $mensaje = mensajes($_SESSION['mensaje']);
    unset($_SESSION['mensaje']);
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - Admin</title>
        <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <link rel="stylesheet" href="../../assets/css/admin.css">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">

        <nav class="sb-topnav navbar navbar-expand d-flex justify-content-between navbar-light bg-primary">
            <div class="justify-content-between">
                <!-- Navbar Brand-->
                <a class="navbar-brand ps-3 fw-bold" href="index.html">Tienda Itos</a>
                <!-- Sidebar Toggle-->
                <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            </div>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Perfil</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="./exit.php">Salir</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div id="layoutSidenav">
            <!-- sidebar -->
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav bg-primary text-white" id="sidenavAccordion">
                    <div class="sb-sidenav-menu text-white">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Opciones</div>
                            <a class="nav-link text-white" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Inicio
                            </a>
                            <a class="nav-link text-white" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Productos
                            </a>
                            <a class="nav-link text-white" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Ventas
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Desarrollado por:</div>
                        Tienda Itos
                    </div>
                </nav>
            </div>
            <!-- end-sidebar -->

            <div id="layoutSidenav_content">
                <!-- main -->
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <div class="table-responsive mt-4">
                            <h5 class="text-center mb-3">Lista de productos</h5>
                            <div class="d-flex justify-content-center mb-3">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarProducto">
                                    Agregar
                                </button>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Imagen</th>
                                        <th>Descripción</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $pro = new Producto();
                                    $productos = $pro->getProducts($con);
                                    if (!empty($productos)) { 
                                        foreach ($productos as $producto): ?>
                                        <tr>
                                            <td><?= $producto['nombreProducto']; ?></td>
                                            <td><?= MONEDA . number_format($producto['precio'], 2, '.', ','); ?></td>
                                            <td>
                                                <img src="../<?= $producto['imagen']; ?>" alt="" width="60px">
                                            </td>
                                            <td><?= $producto['descripcion']; ?></td>
                                            <td>
                                                <a href="#" class="btn btn-primary" data-bs-idProducto="<?= $producto['idProducto']; ?>" data-bs-toggle="modal" data-bs-target="#editarProducto">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger" data-bs-idProducto="<?= $producto['idProducto']; ?>" data-bs-toggle="modal" data-bs-target="#eliminarProducto">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                        endforeach;
                                    } else {
                                        echo '<tr>';
                                            echo '<td colspan="5" class="text-center">';
                                                echo '<b>No hay productos disponibles</b>';
                                            echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
                <!-- end-main -->

                <!-- footer -->
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Tienda Itos 2024</div>
                            <div>
                                <a href="#">Políticas de privacidad</a>
                                &middot;
                                <a href="#">Términos &amp; Condiciones</a>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end-footer -->

            </div>
        </div>

        <?php include './agregarProducto.php'; ?>
        <?php include './editarProducto.php'; ?>
        <?php include './eliminarProducto.php'; ?>

        <script src="../../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/sweetalert2/sweetalert2.all.min.js"></script>
        <script src="../../assets/js/admin.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

        <script>
            let mensaje = <?= $mensaje ?>;
        </script>

    </body>
</html>