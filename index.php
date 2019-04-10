<!-- header -->
<?php include_once"inc/header.php" ?>

<!-- rotas principais -->
<?php
    $url = (isset($_GET['url'])) ? htmlentities(strip_tags($_GET['url'])) : '';
    $parametros = explode('/', $url);
    $paginas_permitidas = array('login','produto','carrinho','verificar','finalizar','cadastro');

    if(isset($_GET['s']) && $_GET['s'] != ''){
        include_once "pages/busca.php";
    }else{
        if($url == ''){
            include_once "pages/home.php";

        }else if(in_array($parametros[0], $paginas_permitidas)){
            include_once "pages/".$parametros[0].'.php';

        }else if($parametros[0] == 'loja'){

            if(isset($parametros[1]) && !isset($parametros[2])){
                include_once "pages/categoria.php";
            }else if(isset($parametros[2])){
                include_once "pages/subcategoria.php";
            }else{
                include_once "pages/loja.php";
            }

        }else{
            include_once "pages/404.php";
        }
    }
 ?>

<!-- footer -->
<?php include_once"inc/footer.php" ?>
