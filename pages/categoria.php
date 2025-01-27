<?php
	 $pegar_categoria = htmlentities($parametros[1]);
	 $pegar_dados_categoria = BD::conn()->prepare("SELECT titulo FROM `tblcdscat` where slug = ?");
	 $pegar_dados_categoria->execute(array($pegar_categoria));
	 $fetch_cat = $pegar_dados_categoria->fetchObject();
?>
<section class="categories_product_main">
        <div class="categories_main_inner">
            <div class="row row_disable">
                <div class="col-lg-9 float-md-right">
                    <div class="showing_fillter">
                        <div class="row m0">
                            <div class="first_fillter">
                                <h4>Encontrado(s) <?php echo $Site->getRegistrosCat($pegar_categoria); ?> registro(s) <h4>
                            </div>
                        </div>
                    </div>
                    <div class="categories_product_area">
                        <div class="row">
                          <?php
															$pg = (isset($_GET['pagina'])) ? (int)htmlentities($_GET['pagina']) : '1';
															$maximo = '9';
															$inicio = (($pg * $maximo) - $maximo);

                              $pegar_categoria =  htmlentities($parametros[1]);

                              $sql = "SELECT * FROM `tblcdsprod` where categoria = ? ORDER BY id DESC LIMIT $inicio, $maximo";
                              $executar_cat = BD::conn()->prepare($sql);
                              $executar_cat->execute(array($pegar_categoria));

                              if($executar_cat->RowCount() == 0){
                                  echo '<p>Não existe produtos nessa categoria.</p>';
                              }else{
                                while($produto = $executar_cat->fetchObject()){
                          ?>
                            <div class="col-lg-4 col-sm-6">
                                <div class="l_product_item">
                                    <div class="l_p_img">
                                        <img src="<?php echo PATH.'img/product/'.$produto->img_padrao; ?>" alt="">
                                    </div>
                                    <div class="l_p_text">
                                       <ul>
                                            <li class="p_icon"><a href="<?php echo PATH.'produto/'.$produto->slug; ?>"><i class="icon-eye"></i></a></li>
                                            <li><a class="add_cart_btn" href="<?php echo PATH.'carrinho/add/'.$produto->id; ?>">Add carrinho</a></li>
                                        </ul>
                                        <h4><?php echo $produto->titulo; ?></h4>
                                        <h5>R$ <?php echo number_format($produto->valor_atual, 2,',','.'); ?></h5>
                                    </div>
                                </div>
                            </div>
                          <?php }} ?>
                        </div>
                        <nav aria-label="Page navigation example" class="pagination_area">
                          <ul class="pagination">
														<li class="page-item">
														<?php
																$sql_res = BD::conn()->prepare("SELECT * FROM `tblcdsprod` WHERE categoria = ?");
																$sql_res-> execute(array($pegar_categoria));
																$total = $sql_res->rowCount();
																if($total != 0){
																	$pags = ceil($total/$maximo);
																}
																$links = '5';

																echo	'<span>Página: <a>'.$pg.'</a></span>';
																for($i = $pg-$links; $i<=$pg-1; $i++){
																		if($i<=0){}else{
																				echo '<li class="page-item next"><a class="page-link" href="'.PATH.'categoria/'.$pegar_categoria.'&pagina='.$i.'">'.$i.'</a></li>';
																		}
																}
																for($i = $pg+1; $i<=$pg+$links; $i++){
																		if($i>$pags){}else{
																				echo	'<li class="page-item next"><a class="page-link" href="'.PATH.'loja/'.$pegar_categoria.'&pagina='.$i.'">'.$i.'</a></li>';
																		}
																}echo '<li class="page-item next"><a class="page-link" href="'.PATH.'loja/'.$pegar_categoria.'&pagina='.$pags.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>';
														?>
														</li>
													</ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-3 float-md-right">
                    <div class="categories_sidebar">
											<aside class="l_widget l_categories_widget">
                          <div class="l_title">
                              <a href="<?php PATH.'loja' ?>"><h3>Categorias</h3></a>
                            </div>
                                <?php include_once "inc/menucategorialoja.php" ?>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
</section>
