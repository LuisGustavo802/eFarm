<?php
  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'):
     $idUnepe = (int)$_GET['unepe'];
     $deletar_unepe = BD::conn()->prepare("DELETE FROM `tblcdsune` WHERE id = ?");
     if($deletar_unepe->execute(array($idUnepe))){
       echo '<script>alert("Ok, unepe removida com sucesso!");location:href="index.php?pagina=lisUnepe"</script>';
     }else{
       echo '<script>alert("Erro, não foi possivel remover essa unepe!");location:href="index.php?pagina=lisUnepe</script>';
     }
  endif;
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Listar Unepes</h4>
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
                      Coordenação
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
                      $pegar_unepes = BD::conn()->prepare("SELECT * FROM `tblcdsune` LIMIT $inicio, $maximo");
                      $pegar_unepes->execute();
                      if($pegar_unepes->rowCount() == 0){
                         echo '<tr><td>Não foram encontradas unepes no banco de dados!</td></tr>';
                      }else{
                         while($unepe = $pegar_unepes->fetchObject()){
                      ?>
                      <td>
                        <?php echo $unepe->id; ?>
                      </td>
                      <td>
                        <?php echo $unepe->nome; ?>
                      </td>
                      <td>
                        <?php echo $unepe->coordenacao; ?>
                      </td>
                      <td>
                        <a class="badge badge-gradient-info" href="index.php?pagina=editUnepe&unepe=<?php echo $unepe->id; ?>">Editar</a>
                      </td>
                      <td>
                        <a class="badge badge-gradient-danger" href="index.php?pagina=lisUnepe&deletar=sim&unepe=<?php echo $unepe->id; ?>">Remover</a>
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
                    $sql_res = BD::conn()->prepare("SELECT * FROM `tblcdsune` ORDER BY id DESC");
                    $sql_res-> execute();
                    $total = $sql_res->rowCount();
                    $pags = ceil($total/$maximo);
                    $links = '5';
                    echo	'<span>Página: <a>'.$pg.'</a></span>';
                    for($i = $pg-$links; $i<=$pg-1; $i++){
                        if($i<=0){}else{
                            echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=lisUnepe&pg='.$i.'">'.$i.'</a></li>';
                        }
                    }
                    for($i = $pg+1; $i<=$pg+$links; $i++){
                        if($i>$pags){}else{
                            echo	'<li class="page-item next"><a class="page-link" href="index.php?pagina=lisUnepe&pg='.$i.'">'.$i.'</a></li>';
                        }
                    }echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=lisUnepe&pg='.$pags.'">Ultima página</a></li>';
                ?>
              </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
