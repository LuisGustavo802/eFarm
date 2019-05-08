<section class="home_sidebar_area">
    <div class="row row_disable">
        <div class="col-lg-9 float-md-right">
            <div class="sidebar_main_content_area">
                <div class="card" id="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            PRODUTO
                                        </th>
                                        <th>
                                            QUANTIDADE
                                        </th>
                                        <th>
                                            VALOR
                                        </th>
                                    </tr>
                                </thead>
                                    <h3 class="text-center mb-5">PRODUTOS PEDIDOS - QUANTIDADE</h3>
                                    <tbody>
                                        <?php
                                        $pegar_produtos = BD::conn()->prepare("SELECT produto.titulo as titulo, produto.categoria as categoria, sum(prodpedido.qtd) as qtd
                                                                                FROM tblmvmprodped as prodpedido
                                                                                JOIN tblcdsprod AS produto ON (produto.id = prodpedido.id_produto)
                                                                                JOIN tblmvmped AS pedido ON (pedido.id = prodpedido.id_pedido and pedido.status = 1)
                                                                                WHERE pedido.id_prof = ? 
                                                                                GROUP BY prodpedido.id_produto, produto.titulo
                                                                                ORDER BY produto.titulo");
                                        $pegar_produtos->execute(array($usuarioLogado->id)); 
                                        if ($pegar_produtos->rowCount() == 0) {
                                            echo '<tr><td>Não foram encontrados pedidos no banco de dados!</td><td></td><td></td><td></td></tr>';
                                        } else {
                                            while ($produtopedidos = $pegar_produtos->fetchObject()) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $produtopedidos->titulo; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $produtopedidos->qtd ?>
                                                    </td>
                                                    <td>
                                                        R$
                                                    </td>
                                                </tr>
                                            <?php }
                                    } ?>
                                    </tbody>
                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 float-md-right">
            <div class="left_sidebar_area">
                <aside class="l_widget l_categories_widget">
                    <?php include_once "inc/menupainelprofessor.php" ?>
                </aside>
            </div>
        </div>
    </div>
</section>