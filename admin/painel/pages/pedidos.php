<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Ultimos pedidos</h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      ID pedido
                    </th>
                    <th>
                      Coordenação solicitada
                    </th>
                    <th>
                      Unepe solicitada
                    </th>
                    <th>
                      Detalhes do pedido
                    </th>
                    <th>
                      Solicitado
                    </th>
                    <th>
                      Status
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                     $pg = (isset($_GET['pg'])) ? (int)htmlentities($_GET['pg']) : '1';
                     $maximo = '10';
                     $inicio = (($pg * $maximo) - $maximo);
                     $dados = array('id','id_prof','coordenacao','unepe','valor_total','status','criado');
                     $Site->selecionarPedidos('tblmvmped', $dados, false, 'id DESC');
                     foreach($Site->Listar() as $campos){
                        if($campos['status'] == 0){
                            $status = 'Pendente';
                            $btnSts = 'warning';

                        }elseif($campos['status'] == '1'){
                            $status = "Autorizado";
                            $btnSts = 'success';

                        }elseif($campos['status'] == '2'){
                            $status = "Recusado";
                            $btnSts = 'danger';
                        }
                  ?>
                  <tr>
                    <td>
                      <?php echo $campos['id']; ?>
                    </td>
                    <td>
                      <?php echo utf8_encode($campos['coordenacao']); ?>
                    </td>
                    <td>
                      <?php echo utf8_encode($campos['unepe']); ?>
                    </td>
                    <td>
                      <a class="badge badge-gradient-info" href="?pagina=detPedidos&pedido_id=<?php echo $campos['id']; ?>">Visualizar</a>
                    </td>
                    <td>
                      <?php echo date('d/m/Y', strtotime($campos['criado'])); ?>
                    </td>
                    <td>
                      <label class="badge badge-gradient-<?php echo $btnSts ?>"><?php echo $status ?></label>
                    </td>
                  </tr>
                <?php } ?>
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
                  $sql_res = BD::conn()->prepare("SELECT * FROM `tblmvmped`");
                  $sql_res-> execute();
                  $total = $sql_res->rowCount();
                  $pags = ceil($total/$maximo);
                  $links = '5';

                  echo	'<span>Página: <a>'.$pg.'</a></span>';
                  for($i = $pg-$links; $i<=$pg-1; $i++){
                      if($i<=0){}else{
                          echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=pedidos='.$i.'">'.$i.'</a></li>';
                      }
                  }
                  for($i = $pg+1; $i<=$pg+$links; $i++){
                      if($i>$pags){}else{
                          echo	'<li class="page-item next"><a class="page-link" href="index.php?pagina=pedidos&pg='.$i.'">'.$i.'</a></li>';
                      }
                  }echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=pedidos&pg='.$pags.'">Ultima página</a></li>';
              ?>
            </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
