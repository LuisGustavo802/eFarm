<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'Cadastrar'){
      $nome     = strip_tags(filter_input(INPUT_POST, 'nome'));
      $emailLog = strip_tags(filter_input(INPUT_POST, 'emailLog'));
      $senhaLog = strip_tags(filter_input(INPUT_POST, 'senhaLog'));
      $val = new Validacao();
      $val->set($nome    , 'Nome')->obrigatorio();
      $val->set($emailLog, 'Email de Login')->isEmail();
      $val->set($senhaLog, 'Senha de Login')->obrigatorio();
      if(isset($_POST['checkAcessoAdm']))
      {
          $checkAcessoAdm = $_POST['checkAcessoAdm'][0];
      }else{
          $checkAcessoAdm = 0;
      }
      if(!$val->validar()){
          $erros = $val->getErro();
          echo  '<div class="alert alert-danger" role="alert">
  								<strong>'.$erros[0].'</strong>
  							</div>';
      }else{
          $verificarUsuario = BD::conn()->prepare("SELECT id FROM `tblcdsprof` WHERE email = ?");
          $verificarUsuario->execute(array($emailLog));
          if($verificarUsuario->rowCount() > 0){
            echo '<div class="alert alert-warning" role="alert">
                   <strong>Já existe um professor com esse email!</strong>
                 </div>';
          }else{
             if(substr($emailLog, 0, 4) == "prof"){
                  $options = ['cost' => 10,];
                  $now = date('Y-m-d');
                  $dados = array(
                                  'nome'         => $nome,
                                  'email'        => $emailLog,
                                  'senha'        => password_hash($senhaLog, PASSWORD_DEFAULT, $options),
                                  'data'         => $now,
                                  'tipo_usuario' => $checkAcessoAdm
                                );
                  if($Site->inserir('tblcdsprof', $dados)){
                      if($checkAcessoAdm == 1){
                          $verificarUsuario = BD::conn()->prepare("SELECT id FROM `tblcdsadm` WHERE email = ?");
                          $verificarUsuario->execute(array($emailLog));
                          if($verificarUsuario->rowCount() > 0){
                            echo '<div class="alert alert-danger" role="alert">
                                   <strong>Já existe um administrador que utiliza esse email!</strong>
                                 </div>';
                          }else{
                              $now = date('Y-m-d');
                              $options = ['cost' => 10,];
                              $dadosAdm = array(
                                              'nome'   => $nome,
                                              'email'  => $emailLog,
                                              'senha'  => password_hash($senhaLog, PASSWORD_DEFAULT, $options),
                                              'data'   => $now,
                                              'opCoo'  => 0,
                                              'opUne'  => 0,
                                              'opFor'  => 0,
                                              'opAdm'  => 0,
                                              'opProf' => 0,
                                              'opCat'  => 0,
                                              'opProd' => 0,
                                              'opPed'  => 0,
                                              'opRel'  => 0,
                                              'opOrc'  => 0
                                                );
                              if($Site->inserir('tblcdsadm', $dadosAdm)){
                                 echo '<script>alert("Ok, professor administrador cadastrado com sucesso!");location:href="index.php?pagina=lisAdministrador"</script>';
                              }else{
                                 echo '<script>alert("Erro teste, não foi possivel cadastrar esse professor como administrador");location:href="index.php?pagina=lisAdministrador"</script>';
                              }
                         }
                      }else{
                         echo '<script>alert("Ok, professor cadastrado com sucesso!");location:href="?pagina=lisProfessor"</script>';
                      }
                  }else{
                      echo '<script>alert("Erro, Não foi possivel cadastrar esse professor!");location:href="?pagina=lisProfessor"</script>';
                  }
              }else{
                  echo '<script>alert("Erro, não foi possivel cadastrar esse professor!");location:href="?pagina=lisProfessor"</script>';
              }
          }
      }
 }
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Cadastro de professor</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Email:</label>
              <input type="text" class="form-control" name="emailLog" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Senha:</label>
              <input  type="password" class="form-control" required="required" name="senhaLog" placeholder="Senha">
            </div>
            <label class="card-title">Liberação da administração</label>
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="checkAcessoAdm[]" value="1">Permitir
              </label>
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2 mt-5" value="Próximo Passo">Cadastrar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Cadastrar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
