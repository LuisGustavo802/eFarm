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
                        CATEGORIA
                      </th>
                      <th>
                        PRODUTO
                      </th>
                      <th>
                        QTD
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
                  <h3 class="text-center mb-5">RELATÓRIO RESUMIDO DE PEDIDOS AUTORIZADOS</h3>
                  <tbody>
                    <?php
                      $pegar_produtos = BD::conn()->prepare("SELECT produto.titulo as titulo, produto.categoria as categoria, sum(prodpedido.qtd) as qtd
                                                             FROM tblmvmprodped as prodpedido
                                                             JOIN tblcdsprod AS produto ON (produto.id = prodpedido.id_produto)
                                                             JOIN tblmvmped AS pedido ON (pedido.id = prodpedido.id_pedido and pedido.status = 1)
                                                             GROUP BY prodpedido.id_produto, produto.titulo
                                                             ORDER BY produto.titulo");
                      $pegar_produtos->execute();
                      if($pegar_produtos->rowCount() == 0){
                         echo '<tr><td>Não foram encontrados pedidos no banco de dados!</td></tr>';
                      }else{
                         while($produtopedidos = $pegar_produtos->fetchObject()){
                      ?>
                    <tr>
                      <td>
                        <?php echo utf8_encode($produtopedidos->categoria); ?>
                      </td>
                      <td>
                        <?php echo utf8_encode($produtopedidos->titulo); ?>
                      </td>
                      <td>
                        <?php echo $produtopedidos->qtd ?>
                      </td>
                      <td>
                        R$
                      </td>
                    </tr>
                  <?php }} ?>
                  </tbody>
                 </div>
                </table>
                <table class="table table-bordered">
                 <thead>
                  <tr>
                   <th>
                   </th>
                  </tr>
                 </thead>
                  <tbody>
                    <tr>
                      <td>
                          VALOR TOTAL: R$
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
