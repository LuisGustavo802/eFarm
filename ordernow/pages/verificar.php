<?php
	if($login->isLogado()){
		header("Location:".PATH."finalizar");
	}else{
		if(isset($_POST['acao']) && $_POST['acao'] == 'Logar');
			 $email = strip_tags(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
			 $senha = strip_tags(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
			 if($email == '' || $senha == ''){
				 		echo '<script>alert("Por favor, preencha o formulário!");location:href="'.PATH.'/verificar"</script>';
			 }else{
				 		$login->setEmail($email);
						$login->setSenha($senha);
						if($login->logar()){
								header("Location: ".PATH."finalizar");
						}else{
								echo '<script>alert("Desculpe, mas o usuário não foi encontrado!");location:href="'.PATH.'/verificar"</script>';
						}
			 }
	}
?>
	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Login/Register</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Login/Register</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="img/login.jpg" alt="">
						<div class="hover">
							<h4>New to our website?</h4>
							<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
							<a class="primary-btn" href="registration.html">Create an Account</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Log in to enter</h3>
						<form class="row login_form" action="" enctype="multipart/form-data" method="post" id="contactForm" novalidate="validate">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="email" name="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="senha" name="senha" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" name="acao" value="Logar" class="primary-btn">Log In</button>
								<a href="#">Forgot Password?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->
