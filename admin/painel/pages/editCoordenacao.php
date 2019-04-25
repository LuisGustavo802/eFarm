<?php
  $idCoordenacao = (int)$_GET['coordenacao'];
  $pegar_dados_coordenacao = BD::conn()->prepare("SELECT * FROM `tblcdscor` WHERE id = ?");
  $pegar_dados_coordenacao->execute(array($idCoordenacao));
  $dadosCor = $pegar_dados_coordenacao->fetchObject();
  if(isset($_POST['acao']) && $_POST['acao'] == 'Editar'){
      $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
      $val = new Validacao();
      $val->set($nome, 'Nome')->obrigatorio();
      if(!$val->validar()){
          $erros = $val->getErro();
          echo  '<div class="alert alert-danger" role="alert">
  								<strong>'.$erros[0].'</strong>
  							</div>';
      }else{
          $verificarAdm = BD::conn()->prepare("SELECT id FROM `tblcdscor` WHERE nome = ?");
          $verificarAdm->execute(array($nome));
          if($verificarAdm->rowCount() > 0){
              echo '<script>alert("Já existe uma coordenação com esse nome!");location:href="index.php?pagina=lisCoordenacao"</script>';
          }else{
              $update = BD::conn()->prepare("UPDATE `tblcdscor` SET nome = ? where id = ?");
              $dados = array($nome,$idCoordenacao);
              if($update->execute($dados)){
                 header("Location: index.php?pagina=lisCoordenacao");
              }else{
                 echo '<script>alert("Erro, não foi possivel editar o administrador");location:href="index.php?pagina=lisCoordenacao"</script>';
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
          <h4 class="card-title">Edição de Coordenação</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $dadosCor->nome; ?>">
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2" value="Próximo Passo">Editar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Editar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
