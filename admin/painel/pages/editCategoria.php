<?php
  $idCategoria = (int)$_GET['categoria'];
  $pegar_dados_categoria = BD::conn()->prepare("SELECT * FROM `tblcdscat` WHERE id = ?");
  $pegar_dados_categoria->execute(array($idCategoria));
  $dadosCat = $pegar_dados_categoria->fetchObject();
  if(isset($_POST['acao']) && $_POST['acao'] == 'Editar'){
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
            echo '<script>alert("Essa categoria já está cadastrada!");location:href="index.php?pagina=editCategoria&categoria='.$categoria->id.'"</script>';
        }else{
            $update = BD::conn()->prepare("UPDATE `tblcdscat` SET titulo = ? where id = ?");
            $dados = array($nome,$idCategoria);
            if($update->execute($dados)){
               header("Location: index.php?pagina=lisCategoria");
            }else{
               echo '<script>alert("Erro, não foi possivel editar o administrador");location:href="index.php?pagina=lisCategoria"</script>';
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
          <h4 class="card-title">Edição de Categoria</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $dadosCat->titulo; ?>">
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2" value="Próximo Passo">Editar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Editar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
