<?php
	if($login->isLogado()){
		header("Location:".PATH."finalizar");
	}else{
		if(isset($_POST['acao']) && $_POST['acao'] == 'Logar');
			 $email = strip_tags(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
			 $senha = strip_tags(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
			 if($email == '' || $senha == ''){
				 		echo '<script>alert("Por favor, preencha o formulário!");location:href="'.PATH.'verificar"</script>';
			 }else{
				 		$login->setEmail($email);
						$login->setSenha($senha);
						if($login->logar()){
								header("Location: ".PATH."finalizar");
						}else{
								echo '<div class="alert alert-warning" role="alert">
												<strong>Aviso!</strong> usuário não foi encontrado.
											</div>';
						}
			 }
	}
?>
<section class="checkout_method_area p_100">
    <div class="container">
        <div class="row">
            <div class="checkout_main_area">
                <div class="checkout_prosses">
                    <div class="row m0">
                        <div class="col-md-6">
                            <div class="checkout_method">
                                <h3>Ainda não é cadastrado?</h3>
                                <h4>Se cadastre agora mesmo:</h4>
																<a class="update_btn" href="<?php echo PATH.'cadastro'; ?>"><span>Cadastrar</span></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row checkout_from_area">
                               <h2>Já é cadastrado ?</h2>
                               <p>Por favor, faça o login :</p>
                                <form role="form" action="" enctype="multipart/form-data" method="post" id="contactForm" novalidate="validate">
                                    <div class="form-group">
                                        <label for="email">Email <span>*</span></label>
                                        <input type="email" class="form-control" name="email"  required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Senha <span>*</span></label>
                                        <input type="password" class="form-control" name="senha"  required="required">
                                    </div>
                                    <h3>* Campos requiridos</h3>
                                    <div class="forgot_area">
                                        <button type="submit" class="btn update_btn btn-default" name="acao" value="Logar">Entrar</button>
                                        <h4>Esqueceu sua senha ?</h4>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
