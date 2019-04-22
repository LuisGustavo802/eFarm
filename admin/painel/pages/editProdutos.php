<?php
    $idProduto = (int)$_GET['produto'];
    $pegar_dados_produto = BD::conn()->prepare("SELECT * FROM `tblcdsprod` WHERE id = ?");
    $pegar_dados_produto->execute(array($idProduto));
    $dadosProd = $pegar_dados_produto->fetchObject();
    if(isset($_POST['acao']) && $_POST['acao'] == 'Editar'):
         include_once "inc/slug.php";
         $img_padrao  = $_FILES['img_padrao'];
         $titulo      = strip_tags(filter_input(INPUT_POST, 'titulo'));
         $slug        = slugify($titulo);
         $categoria   = $_POST['categoria'];
         $valAnterior = $_POST['valAnterior'];
         $valAtual    = $_POST['valAtual'];
         $descricao   = htmlentities($_POST['descricao'], ENT_QUOTES);
         $peso        = strip_tags(filter_input(INPUT_POST, 'peso'));
         $qtdEstoque  = strip_tags(filter_input(INPUT_POST, 'qtdEstoque'));
         $validacao->set($titulo, 'Titulo')->obrigatorio();
         $validacao->set($categoria, 'Categoria')->obrigatorio();
         $validacao->set($valAtual, 'Valor Atual')->obrigatorio();
         $validacao->set($descricao, 'Descrição')->obrigatorio();
         $validacao->set($qtdEstoque, 'Quantidade em estoque')->obrigatorio();
         if($img_padrao['error'] == '4'){
             if($categoria == ''){
                 $update = BD::conn()->prepare("UPDATE `tblcdsprod` SET titulo = ?, valor_anterior = ?, valor_atual = ?,
                 descricao = ?, peso = ?, estoque = ? WHERE id = ?");
                 $dados = array($titulo, $valAnterior, $valAtual, $descricao, $peso, $qtdEstoque, $idProduto);
                 if($update->execute($dados)){
                     echo '<script>alert("Produto editado corretamente!");location.href="index.php?pagina=lisProdutos"</script>';
                 }else{
                    echo '<script>alert("Não foi possivel editar o produto!");location.href="index.php?pagina=lisProdutos"</script>';
                 }
             }else{
                 $update = BD::conn()->prepare("UPDATE `tblcdsprod` SET titulo = ?, categoria = ?, valor_anterior = ?, valor_atual = ?,
                 descricao = ?, peso = ?, estoque = ? WHERE id = ?");
                 $dados = array($titulo, $categoria, $valAnterior, $valAtual, $descricao, $peso, $qtdEstoque, $idProduto);
                 if($update->execute($dados)){
                     echo '<script>alert("Produto editado corretamente!");location.href="index.php?pagina=lisProdutos"</script>';
                 }else{
                    echo '<script>alert("Não foi possivel editar o produto!");location.href="index.php?pagina=lisProdutos"</script>';
                 }
             }
         }else{
           if($categoria == ''){
               unlink('../../produtos/'.$dadosProd->img_padrao);
               $nomeImg = md5(uniqid(rand(), true)).$img_padrao['name'];
               $Site->upload($img_padrao['tmp_name'], $img_padrao['name'], $nomeImg, '350', '../../img/product/');
               $update = BD::conn()->prepare("UPDATE `tblcdsprod` SET img_padrao = ?, titulo = ?, valor_anterior = ?, valor_atual = ?,
               descricao = ?, peso = ?, estoque = ? WHERE id = ?");
               $dados = array($nomeImg, $titulo, $valAnterior, $valAtual, $descricao, $peso, $qtdEstoque, $idProduto);
               if($update->execute($dados)){
                   echo '<script>alert("Produto editado corretamente!");location.href="index.php?pagina=lisProdutos"</script>';
               }else{
                  echo '<script>alert("Não foi possivel editar o produto!");location.href="index.php?pagina=lisProdutos"</script>';
               }
           }else{
               unlink('../../produtos/'.$dadosProd->img_padrao);
               $nomeImg = md5(uniqid(rand(), true)).$img_padrao['name'];
               $Site->upload($img_padrao['tmp_name'], $img_padrao['name'], $nomeImg, '350', '../../img/product/');
               $update = BD::conn()->prepare("UPDATE `tblcdsprod` SET img_padrao = ?, titulo = ?, categoria = ?, valor_anterior = ?, valor_atual = ?,
               descricao = ?, peso = ?, estoque = ? WHERE id = ?");
               $dados = array($nomeImg, $titulo, $categoria, $valAnterior, $valAtual, $descricao, $peso, $qtdEstoque, $idProduto);
               if($update->execute($dados)){
                   echo '<script>alert("Produto editado corretamente!");location.href="index.php?pagina=lisProdutos"</script>';
               }else{
                  echo '<script>alert("Não foi possivel editar o produto!");location.href="index.php?pagina=lisProdutos"</script>';
               }
           }
         }
      endif;
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Edição de produto</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Mudar imagem Padrão:</label>
              <div class="input-group col-xs-12">
                <span class="input-group-append">
                  <input class="file-upload-browse btn btn-gradient-primary" type="file" name="img_padrao" value="Procurar"></input>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputName1">Titulo do produto:</label>
              <input type="text" class="form-control" name="titulo" placeholder="Titulo" value="<?php echo $dadosProd->titulo; ?>">
            </div>
            <div class="form-group">
              <label for="exampleSelectGender">Escolha a categoria:</label>
                <select class="form-control" name="categoria">
                  <option value="" selected="selected">Selecione</option>
                  <?php
                      $pegar_categorias = BD::conn()->prepare("SELECT * FROM `tblcdscat` ORDER BY id DESC");
                      $pegar_categorias->execute();
                      while($cat = $pegar_categorias->fetchObject()){
                  ?>
                  <option value="<?php echo $cat->slug; ?>"><?php echo $cat->titulo; ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Valor Anterior:</label>
              <input type="text" class="form-control" name="valAnterior" placeholder="Valor anterior" value="<?php echo $dadosProd->valor_anterior; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Valor Atual:</label>
              <input type="text" class="form-control" name="valAtual" placeholder="Valor atual" value="<?php echo $dadosProd->valor_atual; ?>">
            </div>
            <div class="form-group">
              <label for="exampleTextarea1">Descrição do produto:</label>
              <textarea class="form-control" name="descricao" rows="5"><?php echo $dadosProd->descricao; ?></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Peso do produto:</label>
              <input type="text" class="form-control" name="peso" placeholder="Peso" value="<?php echo $dadosProd->peso; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail3">Quantidade em estoque:</label>
              <input type="text" class="form-control" name="qtdEstoque" placeholder="Estoque" value="<?php echo $dadosProd->estoque; ?>">
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2" value="Próximo Passo">Editar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Editar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
