<?php 

$BASE_URL = '/controle-de-estoque';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Controle de Estoque - Elab</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo($BASE_URL); ?>/dist/assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="<?php echo($BASE_URL); ?>/dist/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo($BASE_URL); ?>/dist/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo($BASE_URL); ?>/dist/assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo($BASE_URL); ?>/dist/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo($BASE_URL); ?>/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo($BASE_URL); ?>/dist/assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?php echo($BASE_URL); ?>/dist/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:<?php echo($BASE_URL); ?>/dist/partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
          </div>
          <div>
            <a class="navbar-brand brand-logo" href="<?php echo($BASE_URL); ?>/dist/index.php">
              <img src="<?php echo($BASE_URL); ?>/dist/assets/images/elab.png" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="<?php echo($BASE_URL); ?>/dist/index.php">
              <img src="<?php echo($BASE_URL); ?>/dist/assets/images/elab.png" alt="logo" />
            </a>
          </div>
        </div>
      </nav>

      <div class="container-fluid page-body-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo($BASE_URL); ?>/dist">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#equipamentos-menu" aria-expanded="false" aria-controls="equipamentos-menu">
                <i class="mdi mdi-cube-outline menu-icon"></i>
                <span class="menu-title">Equipamentos</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="equipamentos-menu">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="<?php echo($BASE_URL); ?>/dist/pages/equipamento">Todos os Equipamentos</a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?php echo($BASE_URL); ?>/dist/pages/equipamento/add.php">Cadastrar Equipamento</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#manutencao-menu" aria-expanded="false" aria-controls="manutencao-menu">
                <i class="mdi mdi-wrench menu-icon"></i>
                <span class="menu-title">Manutenção</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="manutencao-menu">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="<?php echo($BASE_URL); ?>/dist/pages/manutencao">Todas as Manutenções</a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?php echo($BASE_URL); ?>/dist/pages/manutencao/add.php">Cadastrar Manutenção</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#localizacao-menu" aria-expanded="false" aria-controls="localizacao-menu">
                <i class="mdi mdi-map-marker-outline menu-icon"></i>
                <span class="menu-title">Localizações</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="localizacao-menu">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="<?php echo($BASE_URL); ?>/dist/pages/localizacao">Todos os Locais</a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?php echo($BASE_URL); ?>/dist/pages/localizacao/add.php">Cadastrar Local</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </nav>
       