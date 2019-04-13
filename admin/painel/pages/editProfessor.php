<?php
  $idProfessor = (int)$_GET['professor'];
  $pegar_dados_professor = BD::conn()->prepare("SELECT * FROM `tblcdsprof` WHERE id = ?");
  $pegar_dados_professor->execute(array($idProfessor));
  $dadosProf = $pegar_dados_professor->fetchObject();
  if(isset($_POST['acao']) && $_POST['acao'] == 'Editar'){
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
          $verificarUnepe = BD::conn()->prepare("SELECT id FROM `tblcdsprof` WHERE nome = ? and email = ? and senha = ?");
          $verificarUnepe->execute(array($nome,$emailLog,$senhaLog));
          if($verificarUnepe->rowCount() > 0){
              echo '<script>alert("Já existe um professor com esses dados!");location:href="index.php?pagina=lisProfessor"</script>';
          }else{
              $update = BD::conn()->prepare("UPDATE `tblcdsprof` SET nome = ?, email = ?, senha = ? where id = ?");
              $dados = array($nome,$emailLog,$senhaLog,$idProfessor);
              if($update->execute($dados)){
                 header("Location: index.php?pagina=lisProfessor");
              }else{
                 echo '<script>alert("Erro, não foi possivel editar o professor");location:href="index.php?pagina=lisProfessor"</script>';
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
          <h4 class="card-title">Edição de professor <?php echo $dadosProd->titulo; ?></h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $dadosProf->nome; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Email:</label>
              <input type="text" class="form-control" name="emailLog" placeholder="Email" value="<?php echo $dadosProf->email; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Senha:</label>
              <input type="text" class="form-control" name="senhaLog" placeholder="Senha" value="<?php echo $dadosProf->senha; ?>">
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2" value="Próximo Passo">Editar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Editar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
