<?php
//produtos autorizados
$pedstsaut = BD::conn()->prepare("SELECT status FROM `tblmvmped` WHERE status = 1");
$pedstsaut->execute();
//pedidos em pendencia
$pedstsped = BD::conn()->prepare("SELECT status FROM `tblmvmped` WHERE status = 0");
$pedstsped->execute();
//pedidos recusados
$pedstsrec = BD::conn()->prepare("SELECT status FROM `tblmvmped` WHERE status = 2");
$pedstsrec->execute();
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
          <div class="card-body">
            <img src="painel/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Pedidos Pendentes
            </h4>
            <h2 class="mb-5"><?php echo $pedstsaut->rowCount(); ?></h2>
            <h6 class="card-text">Status</h6>
          </div>
        </div>
      </div>
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-warning card-img-holder text-white">
          <div class="card-body">
            <img src="painel/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Pedidos Pendentes
            </h4>
            <h2 class="mb-5"><?php echo $pedstsped->rowCount(); ?></h2>
            <h6 class="card-text">Status</h6>
          </div>
        </div>
      </div>
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
          <div class="card-body">
            <img src="painel/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Pedidos Recusados
            </h4>
            <h2 class="mb-5"><?php echo $pedstsrec->rowCount(); ?></h2>
            <h6 class="card-text">Status</h6>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Ultimos Pedidos pendentes</h4>
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
                  $selecionar_pedidos = BD::conn()->prepare("SELECT * FROM `tblmvmped` WHERE id_prof = ? AND status = '0' LIMIT 10 ");
                  $selecionar_pedidos->execute(array($usuarioLogado->id));
                  if ($selecionar_pedidos->rowCount() == 0) {
                    echo '<tr><td>Não existem pedidos recentes pendentes!</td></tr>';
                  }
                  while ($pedido = $selecionar_pedidos->fetchObject()) {
                    if ($pedido->status == 0) {
                      $status = 'Pendente';
                      $btnSts = 'warning';
                    } elseif ($pedido->status == '1') {
                      $status = "Autorizado";
                      $btnSts = 'success';
                    } elseif ($pedido->status == '2') {
                      $status = "Recusado";
                      $btnSts = 'danger';
                    }
                    ?>
                    <tr>
                      <td>
                        <?php echo $pedido->id ?>
                      </td>
                      <td>
                        <?php echo $pedido->coordenacao ?>
                        <!-- SELECT UNEP  -->
                      </td>
                      <td>
                        <?php echo $pedido->unepe ?>
                        <!-- SELECT UNEP  -->
                      </td>
                      <td>
                        <a class="badge badge-gradient-info" href="index.php?pagina=detPedidos&pedido_id=<?php echo $pedido->id ?>">Visualizar</a>
                      </td>
                      <td>
                        <?php echo date('d/m/Y', strtotime($pedido->criado)); ?>
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
    </div>
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Ultimos Pedidos recusados</h4>
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
                  $selecionar_pedidos = BD::conn()->prepare("SELECT * FROM `tblmvmped` WHERE id_prof = ? AND status = '2' LIMIT 10 ");
                  $selecionar_pedidos->execute(array($usuarioLogado->id));
                  if ($selecionar_pedidos->rowCount() == 0) {
                    echo '<tr><td>Não existem pedidos recentes recusados!</td></tr>';
                  }
                  while ($pedido = $selecionar_pedidos->fetchObject()) {
                    if ($pedido->status == 0) {
                      $status = 'Pendente';
                      $btnSts = 'warning';
                    } elseif ($pedido->status == '1') {
                      $status = "Autorizado";
                      $btnSts = 'success';
                    } elseif ($pedido->status == '2') {
                      $status = "Recusado";
                      $btnSts = 'danger';
                    }
                    ?>
                    <tr>
                      <td>
                        <?php echo $pedido->id ?>
                      </td>
                      <td>
                        <?php echo $pedido->coordenacao ?>
                        <!-- SELECT UNEP  -->
                      </td>
                      <td>
                        <?php echo $pedido->unepe ?>
                        <!-- SELECT UNEP  -->
                      </td>
                      <td>
                        <a class="badge badge-gradient-info" href="?pagina=detPedidos&pedido_id=<?php echo $pedido->id ?>">Visualizar</a>
                      </td>
                      <td>
                        <?php echo date('d/m/Y', strtotime($pedido->criado)); ?>
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
    </div>