<?php
    //professores cadastrados
    $clientesCad = BD::conn()->prepare("SELECT id FROM `tblcdsprof`");
    $clientesCad->execute();
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
 <?php if($usuarioLogado->opPed == '1') { ?>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
          <div class="card-body">
            <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>
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
            <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>
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
            <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>
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
                     $dados = array('id','id_prof','coordenacao','unepe','valor_total','status','criado');
                     $Site->selecionar('tblmvmped', $dados, false, 'id DESC LIMIT 10','0');
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
                      <?php echo $campos['coordenacao']; ?> <!-- SELECT UNEP  -->
                    </td>
                    <td>
                      <?php echo $campos['unepe']; ?> <!-- SELECT UNEP  -->
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
                     $dados = array('id','id_prof','coordenacao','unepe','valor_total','status','criado');
                     $Site->selecionar('tblmvmped', $dados, false, 'id DESC LIMIT 5','2');
                     foreach($Site->Listar() as $campos){
                        if($campos['status'] == 0){
                            $status = 'Pendentes';
                            $btnSts = 'warning';
                        }elseif($campos['status'] == '1'){
                            $status = "Em pedido";
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
                      <?php echo $campos['coordenacao']; ?> <!-- SELECT UNEP  -->
                    </td>
                    <td>
                      <?php echo $campos['unepe']; ?>
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
        <?php } ?>
    </div>
