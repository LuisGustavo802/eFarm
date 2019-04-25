<?php
  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'):
     $idAdministrador = (int)$_GET['administrador'];
     $deletar_administrador = BD::conn()->prepare("DELETE FROM `tblcdsadm` WHERE id = ?");
     if($deletar_administrador->execute(array($idAdministrador))){
       echo '<script>alert("Ok, administrador removido com sucesso!");location:href="index.php?pagina=lisAdministrador"</script>';
     }else{
       echo '<script>alert("Erro, não foi possivel remover o administrador");location:href="index.php?pagina=lisAdministrador"</script>';
     }
  endif;
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Listar administradores</h4>
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
                      $maximo = '10';
                      $inicio = (($pg * $maximo) - $maximo);
                      $pegar_administradores = BD::conn()->prepare("SELECT * FROM `tblcdsadm` LIMIT $inicio, $maximo");
                      $pegar_administradores->execute();
                      if($pegar_administradores->rowCount() == 0){
                         echo '<tr><td>Não foram encontrados administradores no banco de dados!</td></tr>';
                      }else{
                         while($administrador = $pegar_administradores->fetchObject()){
                      ?>
                      <td>
                        <?php echo $administrador->id; ?>
                      </td>
                      <td>
                        <?php echo utf8_encode($administrador->nome); ?>
                      </td>
                      <td>
                        <?php echo $administrador->email; ?>
                      </td>
                      <td>
                        <a class="badge badge-gradient-info" href="index.php?pagina=editAdministrador&administrador=<?php echo $administrador->id; ?>">Editar</a>
                      </td>
                      <td>
                        <a class="badge badge-gradient-danger" href="index.php?pagina=lisAdministrador&deletar=sim&administrador=<?php echo $administrador->id; ?>">Remover</a>
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
                    $sql_res = BD::conn()->prepare("SELECT * FROM `tblcdsadm` ORDER BY id DESC");
                    $sql_res-> execute();
                    $total = $sql_res->rowCount();
                    $pags = ceil($total/$maximo);
                    $links = '5';
                    echo	'<span>Página: <a>'.$pg.'</a></span>';
                    for($i = $pg-$links; $i<=$pg-1; $i++){
                        if($i<=0){}else{
                            echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=lisAdministrador&pg='.$i.'">'.$i.'</a></li>';
                        }
                    }
                    for($i = $pg+1; $i<=$pg+$links; $i++){
                        if($i>$pags){}else{
                            echo	'<li class="page-item next"><a class="page-link" href="index.php?pagina=lisAdministrador&pg='.$i.'">'.$i.'</a></li>';
                        }
                    }echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=lisAdministrador&pg='.$pags.'">Ultima página</a></li>';
                ?>
              </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
