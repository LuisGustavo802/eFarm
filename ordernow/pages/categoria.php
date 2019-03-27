<?php
	 $pegar_categoria = htmlentities($parametros[1]);
	 $pegar_dados_categoria = BD::conn()->prepare("SELECT titulo FROM `tabela_categorias` where slug = ?");
	 $pegar_dados_categoria->execute(array($pegar_categoria));
	 $fetch_cat = $pegar_dados_categoria->fetchObject();
	 $Site->atualizarViewCat($pegar_categoria);
?>
	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Shop Category page</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Shop<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Fashon Category</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
	<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Categorias</div>
						<?php include_once"inc/sidebar-menu.php" ?>
				</div>
			</div>
			<div class="col-xl-9 col-lg-8 col-md-7">
				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="sorting">
						<select>
							<option value="1">Default sorting</option>
							<option value="1">Default sorting</option>
							<option value="1">Default sorting</option>
						</select>
					</div>
					<div class="sorting mr-auto">
						<select>
							<option value="1">Show 12</option>
							<option value="1">Show 12</option>
							<option value="1">Show 12</option>
						</select>
					</div>
					<div class="pagination">
						<a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
						<a href="#" class="active">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
						<a href="#">6</a>
						<a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
					</div>
				</div>
				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<?php
							$pegar_categoria =  htmlentities($parametros[1]);

							$sql = "SELECT * FROM `tabela_produtos` where categoria = ? ORDER BY id DESC";
							$executar_cat = BD::conn()->prepare($sql);
							$executar_cat->execute(array($pegar_categoria));

							if($executar_cat->RowCount() == 0){
									echo '<script>Alert("Não existe produtos nessa categoria.");</p>';
							}else{
								while($produto = $executar_cat->fetchObject()){
					?>
						<div class="row">
								<!-- single product -->
								<div class="col-lg-4 col-md-6">
									<div class="single-product">
										<img class="img-fluid" id="imgproduct" src="<?php echo PATH.'img/product/'.$produto->img_padrao; ?>"  alt="">
										<div class="product-details">
											<h6><a href="<?php echo PATH.'produto/'.$produto->slug; ?>"><?php echo $produto->titulo; ?></a></h6>
											<div class="price">
												<h6>R$ <?php echo number_format($produto->valor_atual, 2,',','.'); ?></h6>
												<h6 class="l-through"><?php echo number_format($produto->valor_anterior, 2,',','.'); ?></h6>
											</div>
											<div class="prd-bottom">
												<a href="<?php echo PATH.'carrinho/add/'.$produto->id; ?>" class="social-info">
													<span class="ti-bag"></span>
													<p class="hover-text">Pedir</p>
												</a>
												<a href="<?php echo PATH.'produto/'.$produto->slug; ?>" class="social-info">
													<span class="lnr lnr-move"></span>
													<p class="hover-text">Ver mais</p>
												</a>
											</div>
										</div>
									</div>
							</div>
					<?php }} ?>
				</section>
				<!-- End Best Seller -->
				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="sorting mr-auto">
						<select>
							<option value="1">Show 12</option>
							<option value="1">Show 12</option>
							<option value="1">Show 12</option>
						</select>
					</div>
					<div class="pagination">
						<a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
						<a href="#" class="active">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
						<a href="#">6</a>
						<a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
					</div>
				</div>
				<!-- End Filter Bar -->
			</div>
		</div>
	</div>

	