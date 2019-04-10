<?php
	 $pegar_categoria = htmlentities($parametros[1]);
	 $pegar_dados_categoria = BD::conn()->prepare("SELECT titulo FROM `tblcdscat` where slug = ?");
	 $pegar_dados_categoria->execute(array($pegar_categoria));
	 $fetch_cat = $pegar_dados_categoria->fetchObject();
?>
<section class="categories_product_main p_80">
    <div class="container">
        <div class="categories_main_inner">
            <div class="row row_disable">
                <div class="col-lg-9 float-md-right">
                    <div class="showing_fillter">
                        <div class="row m0">
                            <div class="first_fillter">
                              <?php
                                  $pesquisa = strip_tags(trim(htmlentities($_GET['s'])));
                                  $pegar_categoria =  htmlentities($parametros[1]);

                                  if($_GET['s'] != ''){

                                      $explode = explode(' ', $_GET['s']);
                                      $num = count($explode);
                                      $busca = '';

                                      for($i = 0; $i < $num; $i++){
                                          $busca .= "`titulo` LIKE :busca$i";
                                          if($i<>$num-1){$busca .= ' AND';}
                                      }

                                      $pg = (isset($_GET['pagina'])) ? (int)htmlentities($_GET['pagina']) : '1';
                                      $maximo = '9';
                                      $inicio = (($pg * $maximo) - $maximo);

                                      $buscar = BD::conn()->prepare("SELECT * FROM `tblcdsprod` WHERE $busca LIMIT $inicio, $maximo");
                                      for($i=0; $i<$num; $i++){
                                          $buscar->bindValue(":busca$i",'%'.$explode[$i].'%', PDO::PARAM_STR);
                                      }
                                      $buscar->execute();
                                  }//se a busca for diferente que vazio

                                  if($buscar->rowCount() > 0){
                                      while($resultado = $buscar->fetchObject()){
                                ?>
                                <h4>Encontrados <?php echo $buscar->rowCount(); ?> registros <h4>
                            </div>
                        </div>
                    </div>
                    <div class="categories_product_area">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6">
                                <div class="l_product_item">
                                    <div class="l_p_img">
                                        <img src="<?php echo PATH;?>img/product/<?php echo $resultado->img_padrao; ?>" alt="">
                                    </div>
                                    <div class="l_p_text">
                                       <ul>
                                            <li class="p_icon"><a href="<?php echo PATH?>produto/<?php echo $resultado->slug; ?>"><i class="icon_piechart"></i></a></li>
                                            <li><a class="add_cart_btn" href="<?php echo PATH;?>carrinho/add/<?php echo $resultado->id; ?>">Add carrinho</a></li>
                                        </ul>
                                        <h4><?php echo $resultado->titulo; ?></h4>
                                        <h5>R$ <?php echo number_format($resultado->valor_atual, 2,',','.'); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }}else{ ?>
                                    <h4>Encontrados <?php echo $buscar->rowCount(); ?> registros <h4>
                                </div>
                            </div>
                        </div>
                          <div class="categories_product_area">
                              <div class="row">
                                  <div class="col-lg-4 col-sm-6">
                                  </h4>Não foi encontrado produto com essa busca.</h4>
                                  </div>
                              </div>
                        <?php } ?>
                        <nav aria-label="Page navigation example" class="pagination_area">
                          <ul class="pagination">
														<li class="page-item">
														<?php
																$sql_res = BD::conn()->prepare("SELECT id FROM `tblcdsprod` WHERE $busca");
                                for($i=0; $i<$num; $i++){
                                    $sql_res->bindValue(":busca$i",'%'.$explode[$i].'%', PDO::PARAM_STR);
                                }
																$sql_res-> execute();
																$total = $sql_res->rowCount();
																$pags = ceil($total/$maximo);
																$links = '5';

																echo	'<span>Página: <a>'.$pg.'</a></span>';
																for($i = $pg-$links; $i<=$pg-1; $i++){
																		if($i<=0){}else{
																				echo '<li class="page-item next"><a class="page-link" href="'.PATH.'?s='.$pesquisa.'&pagina='.$i.'">'.$i.'</a></li>';
																		}
																}

																for($i = $pg+1; $i<=$pg+$links; $i++){
																		if($i>$pags){}else{
																				echo	'<li class="page-item next"><a class="page-link" href="'.PATH.'?s='.$pesquisa.'&pagina='.$i.'">'.$i.'</a></li>';
																		}
																}echo '<li class="page-item next"><a class="page-link" href="'.PATH.'?s='.$pesquisa.'&pagina='.$pags.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>';
														?>
														</li>
													</ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-3 float-md-right">
                    <div class="categories_sidebar">
                        <aside class="l_widgest l_p_categories_widget">
                            <div class="l_w_title">
                              <a href="<?php PATH.'loja' ?>"><h3>Categorias</h3></a>
                            </div>
                                <?php include_once"inc/menucategorialoja.php" ?>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
