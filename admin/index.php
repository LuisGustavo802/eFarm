<?php
    session_start();
    include_once "../config.php";
    function __autoload($classe){
          require_once "../classes/$classe".'.class.php';
    }
    BD::conn();
    $login = new Login('adm_','tblcdsadm');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>ONCE - Painel Admin</title>
  <link rel="stylesheet" href="../admin/painel/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../admin/painel/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../admin/painel/css/style.css">
  <link rel="shortcut icon" href="../admin/painel/images/favicon.png">
</head>
<body>
<?php
     if(isset($_POST['acao']) && $_POST['acao'] == 'Entrar'):
         $email = strip_tags(filter_input(INPUT_POST, 'email'));
         $senha = strip_tags(filter_input(INPUT_POST, 'senha'));
         if($email == '' || $senha == ''){
						echo '<div class="alert alert-warning" role="alert">
							       <strong>Aviso!</strong> usuário não foi encontrado.
						     </div>';
         }else{
              $login->setEmail($email);
              $login->setSenha($senha);
              if($login->logar()){
                  header("Location: painel/index.php");
              }else{
                echo '<div class="alert alert-warning" role="alert">
                         <strong>Aviso!</strong> usuário não foi encontrado.
                     </div>';
              }
         }
    endif;
?>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="../admin/painel/images/logo.png">
              </div>
              <h4>Ola adminstrador!</h4>
              <h6 class="font-weight-light">Faça o login para continuar</h6>
              <form class="pt-3" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Nome" name="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Senha" name="senha">
                </div>
                <div class="mt-3">
                  <input type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" name="acao" value="Entrar">
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="mb-2">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../admin/painel/vendors/js/vendor.bundle.base.js"></script>
  <script src="../admin/painel/vendors/js/vendor.bundle.addons.js"></script>
  <script src="../admin/painel/js/off-canvas.js"></script>
  <script src="../admin/painel/js/misc.js"></script>
</body>
</html>
