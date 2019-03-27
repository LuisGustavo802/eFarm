<?php

	if(isset($parametros[1]) && $parametros[1] == 'add' && isset($parametros[2]) && $parametros[2] != '0'){
			$idProd = (int)$parametros[2];
			$Carrinho->verificaAdiciona($idProd);
	}

	if(isset($_SESSION['ordernow_produto'][0])){
		unset($_SESSION['ordernow_produto'][0]);
	}
	if(count($_SESSION['ordernow_produto'])==0){
		unset($_SESSION['valor_frete']);
	}

	if(isset($parametros[1]) && $parametros[1] == 'del' && isset($parametros[2])){
			$idDel = (int)$parametros[2];
			if($Carrinho->deletarProduto($idDel)){
				echo '<script>alert("Produto deletado do carrinho!");location.href="'.PATH.'carrinho"</script>';
			}else{
				echo '<script>alert("Erro ao deletar o produto do carrinho!");location.href="'.PATH.'carrinho"</script>';
			}
	}

	if(isset($_POST['atualizar']) && $Carrinho->qtdProdutos() != 0){
		$produto = $_POST['prod'];
		if($Carrinho->atualizarQuantidades($produto)){
			echo '<script>alert("Quantidade foi atualizada!");location.href="'.PATH.'carrinho"</script>';
		}else{
		    echo '<script>alert("Não foi possível atualizar a quantidade!");location.href="'.PATH.'carrinho"</script>';
		}
	}

	//Frete
	if(isset($_POST['acao']) && $_POST['acao'] == 'Calcular'):
		$frete = $_POST['frete'];
		$_SESSION['frete_type'] = $frete;
		$cep = strip_tags(filter_input(INPUT_POST, 'cep'));
		switch ($frete) {
			case 'sedex':
				$valor = 40010;
				foreach($_SESSION['ordernow_produto'] as $id => $qtd){
					$selecionar_produto = BD::conn()->prepare("SELECT peso FROM `tabela_produtos` WHERE id = ?");
					$selecionar_produto->execute(array($id));
					$fetchProduto = $selecionar_produto->fetchObject();

					$_SESSION['valor_frete_'.$id] = $Carrinho->calculaFrete($valor,85660000, $cep, $fetchProduto->peso);
				}
				break;

			case 'pac':
				$valor = 41106;
				foreach($_SESSION['ordernow_produto'] as $id => $qtd){
					$selecionar_produto = BD::conn()->prepare("SELECT peso FROM `tabela_produtos` WHERE id = ?");
					$selecionar_produto->execute(array($id));
					$fetchProduto = $selecionar_produto->fetchObject();

					$_SESSION['valor_frete_'.$id] = $Carrinho->calculaFrete($valor,85660000, $cep, $fetchProduto->peso);
				}
			break;
		}
	endif;
	

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
 <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Produto | Valores aproximados</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Subtotal</th>
								<th scope="col">Remover</th>
                            </tr>
                        </thead>
                        <tbody>
							<form action="<?php echo PATH.'carrinho/atualizar'; ?>" method="post" enctype="multipart/form-data">
								<?php
									if($Carrinho->qtdProdutos() == 0){
										$total = 0; //Erro na atribuição do total
										echo'<td>
											<div class="media">
												<div class="media-body">
													<p>Sem produtos no seu carrinho.</p>
												</div>
											</div>
										</td><td></td><td></td><td></td><td></td>';
									}else{
										$total = 0;
										foreach($_SESSION['ordernow_produto'] as $id => $quantidade){
											$selecao = BD::conn()->prepare("SELECT * FROM `tabela_produtos` WHERE id = ?");
											$selecao->execute(array($id));
											$fetchProduto = $selecao->fetchObject();
								?>
									<tr>
										<td>
											<div class="media">
												<div class="d-flex">
													<img src="<?php echo PATH;?>img/product/<?php echo $fetchProduto->img_padrao;?>" alt="">
												</div>
												<div class="media-body">
													<p><?php echo $fetchProduto->titulo;?></p>
												</div>
											</div>
										</td>										
										<td>
											<?php echo number_format($fetchProduto->valor_atual, 2,',','.');?>
										</td>
										<td>
											<div class="product_count">
												<input type="number" id="sst" class="input-text qty" Name="prod[<?php echo $id;?>]" value="<?php echo $quantidade;?>">
												<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
													class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
												<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
													class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
											</div>
										</td>

										<td>
											<?php echo number_format($fetchProduto->valor_atual * $quantidade, 2,',','.');?>
										</td>

																				<td>
											 <a class="gray_btn" href="<?php echo PATH.'carrinho/del/'.$id; ?>">X</a>
										</td>

										<?php $total += $fetchProduto->valor_atual * $quantidade;}} ?>
									</tr>
									<tr class="bottom_button">
										<td>
											<button class="gray_btn" value="Atualizar Pedido" id="update" name="atualizar">Atualizar pedido</button>
										</td>
										<td>

										</td>
										<td>

										</td>
										<td>

										</td>
									</tr>
							</form>
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Total Aprox: R$ </h5>
                                </td>
                                <td>
                                    <h5><?php echo (isset($_SESSION['valor_frete'])) ? number_format($total + $_SESSION['valor_frete'],2,',','.') : number_format($total, 2,',','.'); ?></h5>
                                </td>
                            </tr>
                            <tr class="shipping_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" href="#">Continuar pedido</a>
                                        <a class="primary-btn" href="<?php echo PATH.'verificar' ?>">Finalizar pedido</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->
	<?php 
		(isset($_SESSION['valor_frete'])) ? 
			$_SESSION['total_compra'] = number_format($total + $_SESSION['valor_frete'], 2,',','.') : 
			$_SESSION['total_compra'] = number_format($total, 2,',','.'); 
			$_SESSION['total_compra'] = str_replace(",",".", $_SESSION['total_compra']);
	?>