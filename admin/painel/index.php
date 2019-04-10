<?php include_once "inc/header.php" ?>
<?php include_once "inc/siderbar-menu.php" ?>
<?php
    if(!isset($_GET['pagina']) || $_GET['pagina'] == ''){
         include_once "pages/home.php";
    }else{
         $pagina = strip_tags($_GET['pagina']);
         if(file_exists('pages/'.$pagina.'.php')){
             include_once "pages/$pagina".'.php';
         }else{
             echo '
             <div class="main-panel">
               <div class="content-wrapper">
                 <div class="row">
                   <div class="col-md-12 stretch-card grid-margin">
                     <div class="card bg-gradient-danger card-img-holder text-white">
                       <div class="card-body">
                         <h4 class="font-weight-normal mb-3">ERRO 404, a página solicitada não foi encontrada.
                         </h4>
                       </div>
                     </div>
                   </div>
                  </div>
                </div>
              </div>';
         }
    }
?>
<?php include_once "inc/footer.php" ?>
