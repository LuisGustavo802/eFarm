<?php
  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'):
      $idProduto = (int)$_GET['produto'];
      $pegar_dados_produto = BD::conn()->prepare("SELECT img_padrao FROM `tblcdsprod` WHERE id = ?");
      $pegar_dados_produto->execute(array($idProduto));
      $dadosProd = $pegar_dados_produto->fetchObject();
      if(unlink('../../img/product/'.$dadosProd->img_padrao)){
         $deletar_produto = BD::conn()->prepare("DELETE FROM `tblcdsprod` WHERE id = ?");
         if($deletar_produto->execute(array($idProduto))){
            echo '<script>alert("Produto excluido corretamente!");location.href="index.php?pagina=estoqueProdutos"</script>';
         }else{
            echo '<script>alert("Não foi possivel excluir esse produto!");location.href="index.php?pagina=estoqueProdutos"</script>';
         }
      }
  endif;
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Gerenciamento de estoque <?php echo $id_pedido ?></h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      Titulo do produto
                    </th>
                    <th>
                      Estoque
                    </th>
                    <th>
                      Editar
                    </th>
                    <th>
                      Remover
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php
                      $pg = (isset($_GET['pg'])) ? (int)htmlentities($_GET['pg']) : '1';
                      $maximo = '10';
                      $inicio = (($pg * $maximo) - $maximo);
                      $pegar_produtos = BD::conn()->prepare("SELECT * FROM `tblcdsprod` LIMIT $inicio, $maximo");
                      $pegar_produtos->execute();
                      if($pegar_produtos->rowCount() == 0){
                         echo '<tr><td>Não foram encontrados produtos em falta no banco de dados!</td></tr>';
                      }else{
                         while($produto = $pegar_produtos->fetchObject()){
                      ?>
                      <td>
                        <?php echo $produto->titulo; ?>
                      </td>
                      <?php if ($produto->estoque >= 0){ ?>
                      <td class="estpositivo">
                          <?php echo $produto->estoque; ?>
                      </td>
                      <?php }else{ ?>
                      <td class="estnegativo">
                        <?php echo $produto->estoque; ?>
                      </td>
                    <?php }?>
                      <td>
                        <a class="badge badge-gradient-info" href="index.php?pagina=editProdutos&produto=<?php echo $produto->id; ?>">Editar</a>
                      </td>
                      <td>
                        <a class="badge badge-gradient-danger" href="index.php?pagina=editarProdutos&deletar=sim&produto=<?php echo $produto->id; ?>">Remover</a>
                      </td>
                    </tr>
                   <?php }} ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 float-md-right">
          <div class="categories_product_area">
            <nav aria-label="Page navigation example" class="pagination_area">
              <ul class="pagination">
                <li class="page-item">
                <?php
                    $sql_res = BD::conn()->prepare("SELECT * FROM `tblcdsprod` WHERE estoque <= 0");
                    $sql_res-> execute();
                    $total = $sql_res->rowCount();
                    $pags = ceil($total/$maximo);
                    $links = '5';
                    echo	'<span>Página: <a>'.$pg.'</a></span>';
                    for($i = $pg-$links; $i<=$pg-1; $i++){
                        if($i<=0){}else{
                            echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=estoqueProdutos&pg='.$i.'">'.$i.'</a></li>';
                        }
                    }
                    for($i = $pg+1; $i<=$pg+$links; $i++){
                        if($i>$pags){}else{
                            echo	'<li class="page-item next"><a class="page-link" href="index.php?pagina=estoqueProdutos&pg='.$i.'">'.$i.'</a></li>';
                        }
                    }echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=estoqueProdutos&pg='.$pags.'">Ultima página</a></li>';
                ?>
              </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
