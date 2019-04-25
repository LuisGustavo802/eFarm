<?php date_default_timezone_set("America/Sao_Paulo"); ?>
<div id="box-suport"><a onclick="printDiv('imprimir')"><img src="images/suport.png" alt="Imprimir relatório" title="Imprimir relatório" class="print"></a></div>
  <div class="main-panel" id="imprimir">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        PEDIDO
                      </th>
                      <th>
                        PROFESSOR
                      </th>
                      <th>
                        COORDENAÇÃO
                      </th>
                      <th>
                        UNEPE
                      </th>
                      <th>
                        PRODUTO
                      </th>
                      <th>
                        QTD
                      </th>
                      <th>
                        DATA
                      </th>
                      <th>
                        VALOR
                      </th>
                    </tr>
                  </thead>
                  <div id="print" class="conteudo">
                  <img src="images/logo.png" alt="logo"/>
                  <h2 class="text-center mt-3">UTFPR</h2>
                  <h5 class="text-center mb-3">Universidade Tecnológica Federal do Paraná</h5>
                  <h5 class="text-left">Emissor: <?php echo $usuarioLogado->nome ?></h5>
                  <h5 class="text-left">Data: <?php $data = date('d/m/Y'); echo $data ?></h5>
                  <h5 class="text-left mb-3">Hora: <?php $hora = date('H:i:s'); echo $hora ?></h5>
                  <h3 class="text-center mb-5">RELATÓRIO COMPLETO DE PEDIDOS AUTORIZADOS</h3>
                  <tbody>
                    <?php
                       $pg = (isset($_GET['pg'])) ? (int)htmlentities($_GET['pg']) : '1';
                       $maximo = '10';
                       $inicio = (($pg * $maximo) - $maximo);
                       $dados = array('id','id_prof','unepe','valor_total','status','criado');
                       $Site->selecionarPedidos('tblmvmped', $dados, false, 'id DESC');
                       foreach($Site->Listar() as $campos){
                          if($campos['status'] == 0){
                              $status = 'Pendente';
                              $btnSts = 'warning';

                          }elseif($campos['status'] == '1'){
                              $status = "Pedido";
                              $btnSts = 'success';

                          }elseif($campos['status'] == '2'){
                              $status = "Recusado";
                              $btnSts = 'danger';
                          }
                          $id_pedido   = $campos['id'];
                          $pegar_dados = BD::conn()->prepare("SELECT * FROM `tblmvmped` WHERE id = ? and status = 1");
                          $pegar_dados->execute(array($id_pedido));
                          $fetchPedido = $pegar_dados->fetchObject();

                          $pegar_prof = BD::conn()->prepare("SELECT * FROM `tblcdsprof` WHERE id = ?");
                          $pegar_prof->execute(array($fetchPedido->id_prof));
                          $dadosProf  = $pegar_prof->fetchObject();

                          $pegar_produtos = BD::conn()->prepare("SELECT * FROM `tblmvmprodped` WHERE id_pedido = ?");
                          $pegar_produtos->execute(array($fetchPedido->id));
                          while($produto = $pegar_produtos->fetchObject()){
                                $pegar_dados_produto = BD::conn()->prepare("SELECT titulo, valor_atual FROM `tblcdsprod` WHERE id = ?");
                                $pegar_dados_produto->execute(array($produto->id_produto));
                                $fetch = $pegar_dados_produto->fetchObject();
                    ?>
                    <tr>
                      <td>
                        <?php echo $campos['id']; ?>
                      </td>
                      <td>
                        <?php echo utf8_encode($dadosProf->nome); ?>
                      </td>
                      <td>
                        <?php echo utf8_encode($produto->coordenacao); ?>
                      </td>
                      <td>
                        <?php echo utf8_encode($campos['unepe']); ?>
                      </td>
                      <td>
                        <?php echo utf8_encode($fetch->titulo); ?>
                      </td>
                      <td>
                        <?php echo $produto->qtd; ?>
                      </td>
                      <td>
                        <?php echo date('d/m/Y', strtotime($campos['criado'])); ?>
                      </td>
                      <td>
                        R$ <?php echo number_format($fetch->valor_atual, 2,',','.'); ?>
                      </td>
                    </tr>
                  <?php }} ?>
                  </tbody>
                 </div>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
