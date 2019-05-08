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
                                            PEDIDO
                                        </th>
                                        <th>
                                            COORDENAÇÃO SOLICITADA
                                        </th>
                                        <th>
                                            UNEPE SOLICITADA
                                        </th>
                                        <th>
                                            DATA SOLICITADA
                                        </th>
                                        <th>
                                            STATUS
                                        </th>
                                    </tr>
                                </thead>
                                <h3 class="text-center mb-5">PEDIDOS SOLICITADOS - STATUS</h3>
                                <tbody>
                                    <?php
                                    $pg = (isset($_GET['pg'])) ? (int)htmlentities($_GET['pg']) : '1';
                                    $maximo = '10';
                                    $inicio = (($pg * $maximo) - $maximo);
                                    $selecionar_pedidos = BD::conn()->prepare("SELECT * FROM `tblmvmped` where id_prof = ?");
                                    $selecionar_pedidos->execute(array($usuarioLogado->id));
                                    if ($selecionar_pedidos->rowCount() == 0) {
                                        echo '<tr colspan="5"><td>Não existem pedidos que você solicitou!</td></tr>';
                                    } else {
                                        while ($pedidos = $selecionar_pedidos->fetchObject()) {
                                            if ($pedidos->status == 0) {
                                                $status = 'Pendente';
                                                $btnSts = 'warning';
                                            } elseif ($pedidos->status == '1') {
                                                $status = "Autorizado";
                                                $btnSts = 'success';
                                            } elseif ($pedidos->status == '2') {
                                                $status = "Recusado";
                                                $btnSts = 'danger';
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $pedidos->id ?>
                                                </td>
                                                <td>
                                                    <?php echo $pedidos->coordenacao ?>
                                                </td>
                                                <td>
                                                    <?php echo $pedidos->unepe ?>
                                                </td>
                                                <td>
                                                    <?php echo date('d/m/Y', strtotime($pedidos->criado)); ?>
                                                </td>
                                                <td>
                                                    <label class="badge badge-gradient-<?php echo $btnSts ?>"><?php echo $status ?></label>
                                                </td>
                                            </tr>
                                        <?php }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 float-md-right">
                        <div class="categories_product_area">
                            <nav aria-label="Page navigation example" class="pagination_area">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <?php
                                        $sql_res = BD::conn()->prepare("SELECT * FROM `tblmvmped`");
                                        $sql_res->execute();
                                        $total = $sql_res->rowCount();
                                        $pags = ceil($total / $maximo);
                                        $links = '5';

                                        echo    '<span>Página: <a>' . $pg . '</a></span>';
                                        for ($i = $pg - $links; $i <= $pg - 1; $i++) {
                                            if ($i <= 0) { } else {
                                                echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=pedidos=' . $i . '">' . $i . '</a></li>';
                                            }
                                        }
                                        for ($i = $pg + 1; $i <= $pg + $links; $i++) {
                                            if ($i > $pags) { } else {
                                                echo    '<li class="page-item next"><a class="page-link" href="index.php?pagina=pedidos&pg=' . $i . '">' . $i . '</a></li>';
                                            }
                                        }
                                        echo '<li class="page-item next"><a class="page-link" href="index.php?pagina=pedidos&pg=' . $pags . '">Ultima página</a></li>';
                                        ?>
                                    </li>
                                </ul>
                            </nav>
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