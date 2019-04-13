<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'Cadastrar'){
      $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
      $coordenacao = $_POST['coordenacao'];
      $val = new Validacao();
      $val->set($nome    , 'Nome')->obrigatorio();
      $val->set($coordenacao, 'Categoria')->obrigatorio();
      if(!$val->validar()){
          $erros = $val->getErro();
          echo  '<div class="alert alert-danger" role="alert">
  								<strong>'.$erros[0].'</strong>
  							</div>';
      }else{
        $verificarUnepe = BD::conn()->prepare("SELECT id FROM `tblcdsune` WHERE nome = ?");
        $verificarUnepe->execute(array($nome));
        if($verificarUnepe->rowCount() > 0){
           echo '<script>alert("Essa unepe já está cadastrada!");location:href="index.php?pagina=editUnepe&unepe='.$unepe->id.'"</script>';
        }else{
          $dados = array(
                          'nome' => $nome,
                          'coordenacao' => $coordenacao
                        );
          if($Site->inserir('tblcdsune', $dados)){
            echo '<script>alert("Ok, unepe cadastrada com sucesso!");location:href="index.php?pagina=lisUnepe"</script>';
          }else{
            echo '<script>alert("Erro, não foi possivel cadastrar a unepe!");location:href="index.php?pagina=lisUnepe"</script>';
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
          <h4 class="card-title">Cadastro de Unepe</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome">
            </div>
            <div class="form-group">
              <label for="exampleSelectGender">Escolha a coordenação:</label>
                <select class="form-control" name="coordenacao">
                  <option value="" selected="selected">Selecione</option>
                  <?php
                      $pegar_coordenacao = BD::conn()->prepare("SELECT * FROM `tblcdscor` ORDER BY id ASC");
                      $pegar_coordenacao->execute();
                      while($cord = $pegar_coordenacao->fetchObject()){
                  ?>
                  <option value="<?php echo $cord->nome; ?>"><?php echo $cord->nome; ?></option>
                <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2" value="Próximo Passo">Cadastrar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Cadastrar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
