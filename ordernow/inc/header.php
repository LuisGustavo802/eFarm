<?php
	ob_start(); //LIMPA BUFFER
    session_start(); //START DA SESSION
    date_default_timezone_set("America/Sao_Paulo");
    include_once "config.php";
    function __autoload($classe){
       if(!strstr($classe, 'PagSeguro')){
		   require_once 'classes/'.$classe.'.class.php';
		}
    }
    BD::conn();
    $Site = new Site();
    $Carrinho = new Carrinho();
    $login = new Login;

	if($login->isLogado()){
		$strSQL = "SELECT * FROM `tabela_clientes` WHERE email_log = ? AND senha_log = ?";
		$stmt = BD::conn()->prepare($strSQL);
		$stmt->execute(array($_SESSION['ordernow_emailLog'], $_SESSION['ordernow_senhaLog']));
		$usuarioLogado = $stmt->fetchObject();
	}
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>OrderNow</title>
	<!--
		CSS
		============================================= -->
	<link rel="stylesheet" href="<?php echo PATH; ?>css/linearicons.css">
	<link rel="stylesheet" href="<?php echo PATH; ?>css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo PATH; ?>css/themify-icons.css">
	<link rel="stylesheet" href="<?php echo PATH; ?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo PATH; ?>css/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo PATH; ?>css/nice-select.css">
	<link rel="stylesheet" href="<?php echo PATH; ?>css/nouislider.min.css">
	<link rel="stylesheet" href="<?php echo PATH; ?>css/ion.rangeSlider.css" />
	<link rel="stylesheet" href="<?php echo PATH; ?>css/ion.rangeSlider.skinFlat.css" />
	<link rel="stylesheet" href="<?php echo PATH; ?>css/magnific-popup.css">
	<link rel="stylesheet" href="<?php echo PATH; ?>css/main.css">
</head>

<body>

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.html"><img src="img/logo.png" alt=""></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav menu_nav ml-auto">
							<?php $Site->getPaginas(); ?>
							<li class="nav-item submenu dropdown">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								 aria-expanded="false">Sistema</a>
								<ul class="dropdown-menu">
									<?php $Site->getSubpaginas(); ?></a></li>
								</ul>
							</li>
							<li class="nav-item"><a class="nav-link" href="contact.html">Contato</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item"><div class="qty"><?php echo $Carrinho->qtdProdutos(); ?></div><a href="#" class="cart"><span class="ti-bag"></span></a></li>
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<!--<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>-->
	</header>
	<!-- End Header Area -->
