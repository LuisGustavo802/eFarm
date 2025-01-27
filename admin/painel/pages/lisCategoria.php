<?php
  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'):
     $idCategoria = (int)$_GET['categoria'];
     $deletar_categoria = BD::conn()->prepare("DELETE FROM `tblcdscat` WHERE id = ?");
     if($deletar_categoria->execute(array($idCategoria))){
       echo '<script>alert("Ok, categoria removida com sucesso!");location:href="index.php?pagina=lisCategoria"</script>';
     }else{
       echo '<script>alert("Erro, não foi possivel remover essa categoria!");location:href="index.php?pagina=lisCategoria</script>';
     }
  endif;
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Listar Categorias</h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      ID
                    </th>
                    <th>
                      Nome
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
                      $pegar_categorias = BD::conn()->prepare("SELECT * FROM `tblcdscat` LIMIT $inicio, $maximo");
                      $pegar_categorias->execute();
                      if($pegar_categorias->rowCount() == 0){
                         echo '<tr><td>Não foram encontradas categorias no banco de dados!</td></tr>';
                      }else{
                         while($categoria = $pegar_categorias->fetchObject()){
                      ?>
                      <td>
                        <?php echo $categoria->id; ?>
                      </td>
                      <td>
                        <?php echo $categoria->titulo; ?>
                      </td>
                      <td>
                        <a class="badge badge-gradient-info" href="index.php?pagina=editCategoria&categoria=<?php echo $categoria->id; ?>">Editar</a>
                      </td>
                      <td>
                        <a class="badge badge-gradient-danger" href="index.php?pagina=lisCategoria&deletar=sim&categoria=<?php echo $categoria->id; ?>">Remover</a>
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
                    $sql_res = BD::conn()->prepare("SELECT * FROM `tblcdscat` ORDER BY id DESC");
                    $sql_res-> execute();
                    $total = $sql_res->rowCount();
                    $pags = ceil($total/$maximo);
                    $links = '5';
                    echo	'<span>Página: <a>'.$pg.'</a></span>';
                    for($i = $pg-$links; $i<=$pg-1; $i++){
                        if($i<=0){}else{
                            echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=lisCategoria&pg='.$i.'">'.$i.'</a></li>';
                        }
                    }
                    for($i = $pg+1; $i<=$pg+$links; $i++){
                        if($i>$pags){}else{
                            echo	'<li class="page-item next"><a class="page-link" href="index.php?pagina=lisCategoria&pg='.$i.'">'.$i.'</a></li>';
                        }
                    }echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=lisCategoria&pg='.$pags.'">Ultima página</a></li>';
                ?>
              </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
