<?php
    if(isset($_POST['acao']) && $_POST['acao'] == 'cadProf'){
        $nome     = strip_tags(filter_input(INPUT_POST, 'nome'));
        $emailLog = strip_tags(filter_input(INPUT_POST, 'emailLog'));
        $senhaLog = strip_tags(filter_input(INPUT_POST, 'senhaLog'));

        $val = new Validacao();
        $val->set($nome    , 'Nome')->obrigatorio();
        $val->set($emailLog, 'Email de Login')->isEmail();
        $val->set($senhaLog, 'Senha de Login')->obrigatorio();

        if(!$val->validar()){
            $erros = $val->getErro();
            echo  '<div class="alert alert-danger" role="alert">
    								<strong>'.$erros[0].'</strong>
    							</div>';
        }else{
            $verificarUsuario = BD::conn()->prepare("SELECT id FROM `tblcdsprof` WHERE email = ?");
            $verificarUsuario->execute(array($emailLog));
            if($verificarUsuario->rowCount() > 0){
                echo '<script>alert("Esse email já está cadastrado, escolha outro!");location:href="'.PATH.'cadastro"</script>';
            }else{
                $now = date('Y-m-d');
                $dados = array(
                                'nome'         => $nome,
                                'email'        => $emailLog,
                                'senha'        => $senhaLog,
                                'data'         => $now,
                                'tipo_usuario' => 0
                              );
                if($Site->inserir('tblcdsprof', $dados)){
                    echo	'<div class="alert alert-success" role="alert">
            							     Cadastro efetuado!
            							</div>';
          			}else{
            				echo	'<div class="alert alert-danger" role="alert">
            								   Não foi possivel realizar o cadastro!
            							</div>';
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
                                <h3>Já é cadastrado?</h3>
                                <h4>Aproveite o sistema agora mesmo:</h4>
                                <a class="update_btn" href="<?php echo PATH.'verificar'; ?>"><span>Entrar</span></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row checkout_from_area">
                               <h2>Já é cadastrado ?</h2>
                               <p>Por favor, faça o login :</p>
                                <form role="form" action="" enctype="multipart/form-data" method="post" id="contactForm1" novalidate="validate">
                                    <div class="form-group">
                                        <label for="text">Nome <span>*</span></label>
                                        <input type="text" class="form-control" name="nome"  required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span>*</span></label>
                                        <input type="email" class="form-control" name="emailLog"  required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Senha <span>*</span></label>
                                        <input type="password" class="form-control" name="senhaLog"  required="required">
                                    </div>
                                    <h3>* Campos requiridos</h3>
                                    <div class="forgot_area">
                                        <button type="submit" class="btn update_btn btn-default" name="acao" value="cadProf">Cadastrar</button>
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
<!--================End Categories Banner Area =================-->
