<?php
$_SESSION['_token'] = (!isset($_SESSION['_token'])) ? hash('sha512', rand(100, 1000)) : $_SESSION['_token'];
if ($login->isLogado()) {
	header("Location:" . PATH . "finalizar");
} else {
	if (isset($_POST['acao']) && $_POST['acao'] == 'Logar') {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
			"secret" => SECRET_KEY,
			"response" => $_POST["g-recaptcha-response"],
			"remoteip" => $_SERVER["REMOTE_ADDR"]
		)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$recaptcha = json_decode(curl_exec($ch), true);
		curl_close($ch);
		if ($recaptcha["success"] === true) {
			if ($_REQUEST['hash'] == $_SESSION['_token']) {
				$_SESSION['_token'] = hash('sha512', rand(100, 1000));
				$email = strip_tags(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
				$senha = strip_tags(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
				if ($email == '' || $senha == '') {
					session_regenerate_id();
					session_destroy();
					session_start();
				} else {
					if (substr($email, 0, 4) == "prof") {
						$login->setEmail($email);
						$login->setSenha($senha);
						if ($login->logar()) {
							header("Location: " . PATH . "finalizar");
						} else {
							echo '<div class="alert alert-warning" role="alert">
																	<strong>Aviso!</strong> usuário não foi encontrado.
																</div>';
						}
					} else {
						echo '<div class="alert alert-warning" role="alert">
														 <strong>Aviso!</strong> usuário não foi encontrado.
													 </div>';
					}
				}
			}
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
								<h4>Se cadastre agora mesmo!</h4>
								<a class="update_btn" href="<?php echo PATH . 'cadastro'; ?>"><span>Cadastrar</span></a>
								<h5>Ajuda eFarm!</h5>
								<h6>Esqueceu sua senha?</h6>
							</div>
						</div>
						<div class="col-md-6 card" id="card">
							<div class="row checkout_from_area">
								<h2>Login</h2>
								<p>Por favor, informe seus dados:</p>
								<form role="form" action="" enctype="multipart/form-data" method="post" id="contactForm" novalidate="validate">
									<div class="form-group">
										<label for="email">Email <span>*</span></label>
										<input type="email" class="form-control" name="email" required="required">
									</div>
									<div class="form-group">
										<label for="pwd">Senha <span>*</span></label>
										<input type="password" class="form-control" name="senha" required="required">
									</div>
									<div class="form-group">
										<label for="pwd"><span></span></label>
										<div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY ?>"></div>
									</div>
									<h3></h3>
									<div class="forgot_area mt-1">
										<input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
										<button type="submit" class="btn update_btn btn-default" name="acao" value="Logar">Entrar</button><br>
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