<?php
	if(isset($parametros[1]) && $parametros[1] == 'add' && isset($parametros[2]) && $parametros[2] != '0'){
			$idProd = (int)$parametros[2];
			$Carrinho->verificaAdiciona($idProd);
	}
	if(isset($_SESSION['eFarm_produto'][0])){
		unset($_SESSION['eFarm_produto'][0]);
	}
	if(isset($parametros[1]) && $parametros[1] == 'del' && isset($parametros[2])){
			$idDel = (int)$parametros[2];
			if($Carrinho->deletarProduto($idDel)){
				echo '<script>alert("Produto deletado do carrinho!");location.href="'.PATH.'carrinho"</script>';
			}else{
				echo '<script>alert("Erro ao deletar o produto do carrinho!");location.href="'.PATH.'carrinho"</script>';
			}
	}
	if(isset($parametros[0]) && $parametros[0] == 'verificar' && $_POST['unepe'] == 0){
				echo '<script>alert("Produto deletado do carrinho!");location.href="'.PATH.'carrinho"</script>';
	}
	if(isset($_POST['prodSingle'])){
			$produtoValor = $_POST['prodSingle'];
			if($Carrinho->atualizarQuantidadesSingle($produtoValor)){
				//apenas seta os valores
			}else{
					echo '<script>alert("Não foi possivel adicionar o produto ao carrinho!");location.href="'.PATH.'loja"</script>';
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
	if(isset($_POST['atualizarUnepe'])){
			$_SESSION['unepe'] = $_POST['unepe'];
			if(($_POST['unepe'] != "0") && ($_POST['coordenacao'] != "0")){
				$_SESSION['coordenacao'] = $_POST['coordenacao'];
				$atualizarUnepe = 1;
				echo	'<div class="alert alert-success" role="alert">
								<strong>Ok!</strong> Coordenação e Unepe selecionadas.
							</div>';
			}else{
				$atualizarUnepe = 0;
				echo	'<div class="alert alert-danger" role="alert">
								<strong>Erro!</strong> Coordenação ou Unepe não foi selecionada.
							</div>';
			}
	}
?>
<section class="shopping_cart_area">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart_product_list">
										<?php
												$pegar_ultped = BD::conn()->prepare("SELECT id FROM `tblmvmped` ORDER BY id DESC LIMIT 1");
												$pegar_ultped->execute();
												$ped = $pegar_ultped->fetchObject();
										?>
                    <div class="cart_single_title"><h3>Seu carrinho</h3><span>CUPOM Pedido:  N° <?php echo $ped->id+1; ?></span></div>
                    <div class="table-responsive-md">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">PRODUTO</th>
                                    <th scope="col">VLR. UNIT.</th>
                                    <th scope="col">QUANTIDADE</th>
                                    <th scope="col">VLR. TOTAL</th>
																		<th scope="col">DELETAR</th>
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
              										foreach($_SESSION['eFarm_produto'] as $id => $quantidade){
              											$selecao = BD::conn()->prepare("SELECT * FROM `tblcdsprod` WHERE id = ?");
              											$selecao->execute(array($id));
              											$fetchProduto = $selecao->fetchObject();
              								    ?>
                                  <tr>
                                      <td>
																				  <img  class="imgCard" src="<?php echo PATH;?>img/product/<?php echo $fetchProduto->img_padrao;?>" alt=""/>
                                          <h4><p><?php echo $fetchProduto->titulo; ?></p></h4>
                                      </td>
                                      <td><p><?php echo number_format($fetchProduto->valor_atual, 2,',','.');?></p></td>
                                      <td><input type="text" Name="prod[<?php echo $id;?>]" value="<?php echo $quantidade;?>"></td>
                                      <td><p><?php echo number_format($fetchProduto->valor_atual * $quantidade, 2,',','.');?></p></td>
																			<th scope="row">
																					<a href="<?php echo PATH.'carrinho/del/'.$id; ?>" alt=""><img src="<?php echo PATH; ?>img/icon/close-icon.png"></a>
																			</th>
                                  </tr>
                                  <?php $total += $fetchProduto->valor_atual * $quantidade; }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="total_amount_area">
                    <div class="cart_totals">
                        <div class="cart_total_inner">
                            <ul>
																<li><a href="#"><h5>Coordenação e Unepe:</h5><br>
																		<select class="form-control" name="coordenacao">
																			<option value="0" selected="selected">Selecione a Coordenação</option>
																			<?php
																					$pegar_coordenacoes = BD::conn()->prepare("SELECT * FROM `tblcdscor` ORDER BY id DESC");
																					$pegar_coordenacoes->execute();
																					while($cor = $pegar_coordenacoes->fetchObject()){
																			?>
																					<option value="<?php echo $cor->nome; ?>"><?php echo $cor->nome; ?></option>
																			<?php } ?>
																		</select>
																		<select class="form-control mt-3" name="unepe">
																			<option value="0" selected="selected">Selecione a Unepe</option>
																			<?php
																					$pegar_categorias = BD::conn()->prepare("SELECT * FROM `tblcdsune` ORDER BY id DESC");
																					$pegar_categorias->execute();
																					while($cat = $pegar_categorias->fetchObject()){
																			?>
																				  <option value="<?php echo $cat->nome; ?>"><?php echo $cat->nome; ?></option>
																		  <?php } ?>
																		</select>
																		<br>
						                        <button type="submit" class="btn btn-primary subs_btn" name="atualizarUnepe">SELECIONAR</button></a></li><br>
																		<li><a href="#"><h5>Quantidade dos produtos:</h5><br>
																					<button type="submit" class="btn btn-primary subs_btn" name="atualizar">Atualizar</button>
																				</a>
																		</li>
																	</form>
                            </ul>
                        </div>
                        <a type="submit" class="btn btn-primary update_btn1" href="<?php echo PATH.'loja' ?>"> VOLTAR A LOJA</a>
												<?php if(isset($_POST['atualizarUnepe']) && $atualizarUnepe == 1){  ?>
														  <a type="submit" class="btn btn-primary checkout_btn" href="<?php echo PATH.'verificar' ?>">FINALIZAR O PEDIDO</a>
												<?php }else{
													echo	'<div class="alert alert-warning mt-3" role="alert">
																	<strong>Aviso!</strong> Selecione uma Coordenação e uma Unepe para finalizar o pedido.
																</div>';
												?>
											  <?php } ?>
												<?php 			$_SESSION['total_compra'] = number_format($total, 2,',','.');
																		$_SESSION['total_compra'] = str_replace(",",".", $_SESSION['total_compra']);  ?>
                    </div>
                </div>
            </div>
        </div>
</section>
