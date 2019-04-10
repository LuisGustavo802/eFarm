<?php
	$pegar_slug = strip_tags(trim($parametros[1]));
	$selecionar_produto = "SELECT * FROM `tblcdsprod` WHERE slug = ?";
	$executar = BD::conn()->prepare($selecionar_produto);
	$executar->execute(array($pegar_slug));
	$fetch_produto = $executar->fetchObject();
?>
<section class="product_details_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="product_details_slider">
                    <div id="product_slider" class="rev_slider" data-version="5.3.1.6">
                        <ul>
                            <li>
                                <img src="<?php echo PATH.'img/product/'.$fetch_produto->img_padrao; ?>"  alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="5" class="rev-slidebg" data-no-retina>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="product_details_text">
                    <form action="<?php echo PATH.'carrinho'; ?>" method="post" enctype="multipart/form-data">
                      <h3><?php echo $fetch_produto->titulo; ?></h3>
                      <h4>R$<?php echo $fetch_produto->valor_atual; ?></h4>
                      <p><?php echo html_entity_decode($fetch_produto->descricao); ?></p>
                      <div class="p_color">
                          <h4 class="p_d_title">KG </h4>
                          <select class="selectpicker">
                              <option>Selecione o tamanho</option>
                              <option>Select your size M</option>
                              <option>Select your size XL</option>
                          </select>
                      </div>
                      <div class="quantity">
                          <div class="custom">
                              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="icon_minus-06"></i></button>
                              <input type="text" name="prodSingle[<?php echo $fetch_produto->id; ?>]" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button"><i class="icon_plus"></i></button>
                          </div>
                          <input class="add_cart_btn" type="submit" name="add carrinho"/>
                      </div>
                      <div class="shareing_icon">
                          <h5>share :</h5>
                          <ul>
                              <li><a href="#"><i class="social_facebook"></i></a></li>
                              <li><a href="#"><i class="social_twitter"></i></a></li>
                              <li><a href="#"><i class="social_pinterest"></i></a></li>
                              <li><a href="#"><i class="social_instagram"></i></a></li>
                              <li><a href="#"><i class="social_youtube"></i></a></li>
                          </ul>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</section>
