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
              echo '<script>alert("Esse email já está cadastrado, escolha outro!");location:href="'.PATH.'cadastro"</script>';
          }else{
              $now = date('Y-m-d');
              $dados = array(
                              'nome'         => $nome,
                              'email'        => $emailLog,
                              'senha'        => $senhaLog,
                              'data'         => $now,
                              'tipo_usuario' => $checkAcessoAdm
                            );
              if($Site->inserir('tblcdsprof', $dados)){
                  echo '<script>alert("Ok, professor cadastrador com sucesso!");location:href="?pagina=lisProfessor"</script>';
              }else{
                  echo '<script>alert("Erro, Não foi possivel cadastrar esse professor!");location:href="?pagina=lisProfessor"</script>';
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
              <input type="text" class="form-control" name="nome" placeholder="Nome">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Email:</label>
              <input type="text" class="form-control" name="emailLog" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Senha:</label>
              <input type="text" class="form-control" name="senhaLog" placeholder="Senha">
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
