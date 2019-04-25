<?php
    ob_start(); //LIMPA BUFFER
    session_start(); //START DA SESSION
    include_once "config.php";
    spl_autoload_register(function($classe){
       require_once 'classes/'.$classe.'.class.php';
    });
    BD::conn();
    $Site = new Site();
    $Carrinho = new Carrinho();
    $login = new Login('eFarm_','tblcdsprof');
  	if($login->isLogado()){
  		$strSQL = "SELECT * FROM `tblcdsprof` WHERE email = ? AND senha = ?";
  		$stmt = BD::conn()->prepare($strSQL);
  		$stmt->execute(array($_SESSION['eFarm_emailLog'], $_SESSION['eFarm_senhaLog']));
  		$usuarioLogado = $stmt->fetchObject();
  	}
	  if(isset($_GET['acao']) && $_GET['acao'] == 'sair'){
			if($login->deslogar()){}
  	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo PATH; ?>img/fav-icon.png" type="image/x-icon" />
    <title>eFarm</title>
    <link href="<?php echo PATH; ?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>vendors/line-icon/css/simple-line-icons.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>vendors/elegant-icon/style.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>vendors/revolution/css/settings.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>vendors/revolution/css/layers.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>vendors/revolution/css/navigation.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>vendors/owl-carousel/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>vendors/bootstrap-selector/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>vendors/vertical-slider/css/jQuery.verticalCarousel.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>css/style.css" rel="stylesheet">
    <link href="<?php echo PATH; ?>css/responsive.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<header class="shop_header_area carousel_menu_area">
    <div class="carousel_top_header black_top_header row m0">
        <div class="container">
            <div class="carousel_top_h_inner">
                <div class="float-md-right">
                    <ul class="account_list">
                        <?php if($login->isLogado()){ ?>
                            <?php if($usuarioLogado->tipo_usuario == 1){ ?>
                            <li><a href="<?php echo PATH.'admin' ?>">Painel administrativo |</a></li>
                            <?php }	?>
                            <li><a href="#"><?php echo $usuarioLogado->nome; ?></a></li>
                            <li><a href="&acao=sair">Sair</a></li>
                        <?php }else{	?>
                          <li><a href="<?php echo PATH.'cadastro' ?>">CADASTRAR-SE</a></li>
                          <li><a href="#">|</a></li>
                          <li><a href="<?php echo PATH.'login' ?>">ENTRAR</a></li>
                        <?php }	?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="carousel_menu_inner">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#"><img src="<?php echo PATH; ?>img/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><?php $Site->getPaginas(); ?></li>
                    </ul>
                    <ul class="navbar-nav justify-content-end">
                        <?php if($login->isLogado()){ ?>
                          <li class="user_icon"><a href="<?php echo PATH.'admCliente' ?>"><i class="icon-user icons"></i></a></li>
                        <?php }else{	?>
                            <li class="user_icon"><a href="<?php echo PATH.'verificar' ?>"><i class="icon-user icons"></i></a></li>
                        <?php }	?>
                            <li class="cart_cart"><a href="<?php echo PATH.'carrinho' ?>"><i class="icon-handbag"></i>
                            <?php echo $Carrinho->qtdProdutos(); ?></a></li><!--quantidade no carrinho! -->
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
