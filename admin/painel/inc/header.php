<?php
   	ob_start(); //LIMPA BUFFER
    session_start();
    date_default_timezone_set("America/Sao_Paulo");
    include_once "../../config.php";
    spl_autoload_register(function($classe){
       require_once "../../classes/$classe".'.class.php';
    });
    BD::conn();
    $login = new Login('adm_','tblcdsadm');
    $Site  = new Site();
    $validacao = new Validacao();
    if(!$login->isLogado()){
        header("Location: ../");
        exit;
    }else{
        $pegar_dados = BD::conn()->prepare("SELECT * FROM `tblcdsadm` WHERE email = ? AND senha = ?");
        $pegar_dados->execute(array($_SESSION['adm_emailLog'], $_SESSION['adm_senhaLog']));
        $usuarioLogado = $pegar_dados->fetchObject();
    }
    if(isset($_GET['acao']) && $_GET['acao'] == 'sair'):
        if($login->deslogar()){
          header("Location: ../index.php");
        }
    endif;
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>eFarm - Painel Admin</title>
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/print.css">
  <link rel="shortcut icon" href="images/favicon.png" />
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/dashboard.js"></script>
</head>
<body>
  <div class="container-scroller">
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="?pagina=home"><img src="images/logo.png" alt="logo"/></a>
        <!--<a class="navbar-brand brand-logo-mini" href="?pagina=home"><img src="images/favicon.png" alt="logo"/></a>-->
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
              </div>
              <div class="nav-profile-text">
                <?php if($login->isLogado()){ ?>
                <p class="mb-1 text-black"><?php echo $usuarioLogado->nome; ?></p>
              <?php } ?>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="?acao=sair">
                <i class="mdi mdi-logout mr-2 text-primary"></i>
                Sair
              </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <i class="mdi mdi-email-outline"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
              <h6 class="p-3 mb-0">Tickets</h6>
            </div>
          </li>
          <li class="nav-item nav-settings d-none d-lg-block">
            <a class="nav-link" href="#">
              <i class="mdi mdi-format-line-spacing"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
<div class="container-fluid page-body-wrapper">
