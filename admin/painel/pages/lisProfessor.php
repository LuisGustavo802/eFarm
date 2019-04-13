<?php
  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'):
      $idProfessor = (int)$_GET['professor'];
         $deletar_professor = BD::conn()->prepare("DELETE FROM `tblcdsprof` WHERE id = ?");
         if($deletar_professor->execute(array($idProfessor))){
            echo '<script>alert("Ok, professor removido com sucesso!");location:href="index.php?pagina=lisProfessor"</script>';
         }else{
           echo '<script>alert("Erro, não foi possivel remover esse professor!");location:href="index.php?pagina=lisProfessor</script>';
        }
  endif;
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Listar professores <?php echo $id_pedido ?></h4>
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
                      Email
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
                      $maximo = '15';
                      $inicio = (($pg * $maximo) - $maximo);
                      $pegar_professores = BD::conn()->prepare("SELECT * FROM `tblcdsprof` LIMIT $inicio, $maximo");
                      $pegar_professores->execute();
                      if($pegar_professores->rowCount() == 0){
                         echo '<tr><td>Não foram encontrados professores no banco de dados!</td></tr>';
                      }else{
                         while($professor = $pegar_professores->fetchObject()){
                      ?>
                      <td>
                        <?php echo $professor->id; ?>
                      </td>
                      <td>
                        <?php echo $professor->nome; ?>
                      </td>
                      <td>
                        <?php echo $professor->email; ?>
                      </td>
                      <td>
                        <a class="badge badge-gradient-info" href="index.php?pagina=editProfessor&professor=<?php echo $professor->id; ?>">Editar</a>
                      </td>
                      <td>
                        <a class="badge badge-gradient-danger" href="index.php?pagina=lisProfessor&deletar=sim&professor=<?php echo $professor->id; ?>">Remover</a>
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
                    $sql_res = BD::conn()->prepare("SELECT * FROM `tblcdsprof` ORDER BY id DESC");
                    $sql_res-> execute();
                    $total = $sql_res->rowCount();
                    $pags = ceil($total/$maximo);
                    $links = '5';
                    echo	'<span>Página: <a>'.$pg.'</a></span>';
                    for($i = $pg-$links; $i<=$pg-1; $i++){
                        if($i<=0){}else{
                            echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=lisProfessor&pg='.$i.'">'.$i.'</a></li>';
                        }
                    }
                    for($i = $pg+1; $i<=$pg+$links; $i++){
                        if($i>$pags){}else{
                            echo	'<li class="page-item next"><a class="page-link" href="index.php?pagina=lisProfessor&pg='.$i.'">'.$i.'</a></li>';
                        }
                    }echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=lisProfessor&pg='.$pags.'">Ultima página</a></li>';
                ?>
              </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
