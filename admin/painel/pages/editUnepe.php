<?php
  $idUnepe = (int)$_GET['unepe'];
  $pegar_dados_unepe = BD::conn()->prepare("SELECT * FROM `tblcdsune` WHERE id = ?");
  $pegar_dados_unepe->execute(array($idUnepe));
  $dadosUnepe = $pegar_dados_unepe->fetchObject();
  if(isset($_POST['acao']) && $_POST['acao'] == 'Editar'){
      $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
      $coordenacao = $_POST['coordenacao'];
      $val = new Validacao();
      $val->set($nome    , 'Nome')->obrigatorio();
      $val->set($coordenacao, 'Coordenação')->obrigatorio();
      if(!$val->validar()){
          $erros = $val->getErro();
          echo  '<div class="alert alert-danger" role="alert">
  								<strong>'.$erros[0].'</strong>
  							</div>';
      }else{
          $verificarUnepe = BD::conn()->prepare("SELECT id FROM `tblcdsune` WHERE nome = ? and coordenacao = ?");
          $verificarUnepe->execute(array($nome,$coordenacao));
          if($verificarUnepe->rowCount() > 0){
              echo '<script>alert("Já existe uma unepe com esses dados!");location:href="index.php?pagina=lisUnepe"</script>';
          }else{
              $update = BD::conn()->prepare("UPDATE `tblcdsune` SET nome = ?, coordenacao = ? where id = ?");
              $dados = array($nome,$coordenacao,$idUnepe);
              if($update->execute($dados)){
                 header("Location: index.php?pagina=lisUnepe");
              }else{
                 echo '<script>alert("Erro, não foi possivel editar a unepe");location:href="index.php?pagina=lisCoordenacao"</script>';
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
          <h4 class="card-title">Edição de Unepe</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $dadosUnepe->nome; ?>">
            </div>
            <div class="form-group">
              <label for="exampleSelectGender">Escolha a coordenação:</label>
                <select class="form-control" name="coordenacao">
                  <option value="" selected="selected">Atual: <?php echo $dadosUnepe->coordenacao; ?></option>
                  <?php
                      $pegar_coordenacao = BD::conn()->prepare("SELECT * FROM `tblcdscor` ORDER BY id ASC");
                      $pegar_coordenacao->execute();
                      while($cord = $pegar_coordenacao->fetchObject()){
                  ?>
                  <option value="<?php echo $cord->nome; ?>"><?php echo $cord->nome; ?></option>
                <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2" value="Próximo Passo">Editar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Editar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
