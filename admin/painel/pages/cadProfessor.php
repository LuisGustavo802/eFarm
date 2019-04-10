<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'Cadastrar'){
      $nome     = strip_tags(filter_input(INPUT_POST, 'nome'));
      $emailLog = strip_tags(filter_input(INPUT_POST, 'emailLog'));
      $senhaLog = strip_tags(filter_input(INPUT_POST, 'senhaLog'));
      $val = new Validacao();
      $val->set($nome    , 'Nome')->obrigatorio();
      $val->set($emailLog, 'Email de Login')->isEmail();
      $val->set($senhaLog, 'Senha de Login')->obrigatorio();
      if(!$val->validar()){
          $erros = $val->getErro();
          echo  '<div class="alert alert-danger" role="alert">
  								<strong>'.$erros[0].'</strong>
  							</div>';
      }else{
          $verificarUsuario = BD::conn()->prepare("SELECT id FROM `tblcdsprof` WHERE email = ?");
          $verificarUsuario->execute(array($emailLog));
          if($verificarUsuario->rowCount() > 0){
              echo '<script>alert("Esse email já está cadastrado, escolha outro!");location:href="'.PATH.'cadastro"</script>';
          }else{
              $dados = array(
                              'nome'  => $nome,
                              'email' => $emailLog,
                              'senha' => $senhaLog
                            );
              if($Site->inserir('tabela_clientes', $dados)){
                  echo  ' <div class="card">
                            <div class="card-body">
                               <div class="card bg-gradient-success card-img-holder text-white">
                                  <div class="card-body">
                                    <h4 class="font-weight-normal mb-3">Ok, professor cadastrado com sucesso!</h4>
                                  </div>
                                </div>
                            </div>
                          </div>';
              }else{
                  echo  ' <div class="card">
                            <div class="card-body">
                               <div class="card bg-gradient-danger card-img-holder text-white">
                                  <div class="card-body">
                                    <h4 class="font-weight-normal mb-3">Erro, não foi possivel cadastrar o professor!</h4>
                                  </div>
                                </div>
                            </div>
                          </div>';
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
          <h4 class="card-title">Cadastro de professor <?php echo $dadosProd->titulo; ?></h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $dadosProd->titulo; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Email:</label>
              <input type="text" class="form-control" name="emailLog" placeholder="Email" value="<?php echo $dadosProd->valor_anterior; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Senha:</label>
              <input type="text" class="form-control" name="senhaLog" placeholder="Senha" value="<?php echo $dadosProd->valor_atual; ?>">
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2" value="Próximo Passo">Cadastrar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Cadastrar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
