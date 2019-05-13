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
                       echo '<tr><td>Não foram encontrados pedidos no banco de dados!</td><td></td><td></td><td></td></tr>';
                    }else{
                       while($produtopedidos = $pegar_produtos->fetchObject()){
                    ?>
                  <tr>
                    <td>
                      <?php echo $produtopedidos->categoria; ?>
                    </td>
                    <td>
                      <?php echo $produtopedidos->titulo; ?>
                    </td>
                    <td>
                      <?php echo $produtopedidos->qtd ?>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="valor_total_prod" placeholder="R$:">
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
