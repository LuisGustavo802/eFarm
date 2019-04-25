<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'Cadastrar'){
      $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
      $val = new Validacao();
      $val->set($nome    , 'Nome')->obrigatorio();
      if(!$val->validar()){
          $erros = $val->getErro();
          echo  '<div class="alert alert-danger" role="alert">
  								<strong>'.$erros[0].'</strong>
  							</div>';
      }else{
        $verificarCat = BD::conn()->prepare("SELECT id FROM `tblcdscat` WHERE titulo = ?");
        $verificarCat->execute(array($nome));
        if($verificarCat->rowCount() > 0){
          echo '<div class="alert alert-warning" role="alert">
                 <strong>Essa categoria já foi cadastrada!</strong>
               </div>';
        }else{
          include_once "inc/slug.php";
          $slug = slugify($nome);
          $dados = array(
                          'titulo' => $nome,
                          'slug'   => $slug
                        );
          if($Site->inserir('tblcdscat', $dados)){
            echo '<script>alert("Ok, categoria cadastrada com sucesso!");location:href="index.php?pagina=lisCategoria"</script>';
          }else{
            echo '<script>alert("Erro, não foi possivel cadastrar a categoria!");location:href="index.php?pagina=lisCategoria"</script>';
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
          <h4 class="card-title">Cadastro de Categoria</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome">
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2" value="Próximo Passo">Cadastrar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Cadastrar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
