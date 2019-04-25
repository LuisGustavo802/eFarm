<?php
    $_SESSION['_token'] = ( !isset($_SESSION['_token'])) ? hash('sha512' , rand(100,1000)) : $_SESSION['_token'];
    if(isset($_POST['acao']) && $_POST['acao'] == 'cadProf'){
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
        if($recaptcha["success"] === true){
            if($_REQUEST['hash'] == $_SESSION['_token']){
              $_SESSION['_token'] = hash('sha512' , rand(100,1000));
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
                  if(substr($emailLog, 0, 4) == "prof"){
                      $verificarUsuario = BD::conn()->prepare("SELECT id FROM `tblcdsprof` WHERE email = ?");
                      $verificarUsuario->execute(array($emailLog));
                      if($verificarUsuario->rowCount() > 0){
                          echo '<script>alert("Esse email já está cadastrado, escolha outro!");location:href="'.PATH.'cadastro"</script>';
                      }else{
                          $options = ['cost' => 10,];
                          $now = date('Y-m-d');
                          $dados = array(
                                          'nome'         => $nome,
                                          'email'        => $emailLog,
                                          'senha'        => password_hash($senhaLog, PASSWORD_DEFAULT, $options),
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
                   }else{
                       echo	'<div class="alert alert-danger" role="alert">
                                Não foi possivel realizar o cadastro!
                            </div>';
                   }
               }
             }else{
                 echo	'<div class="alert alert-danger" role="alert">
                          Não foi possivel realizar o cadastro!
                      </div>';
             }
         }else{
             echo	'<div class="alert alert-danger" role="alert">
                      Não foi possivel realizar o cadastro! Verifique se marcou o campo "Não sou um robo"!
                  </div>';
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
                                <h4>Aproveite o sistema agora mesmo!</h4>
                                <a class="btn update_btn btn-default" href="<?php echo PATH.'verificar'; ?>"><span>Entrar</span></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row checkout_from_area">
                               <h2>Cadastro</h2>
                               <p>Por favor, informe seus dados :</p>
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
                                    <div class="form-group">
                                       <label for="pwd"><span></span></label>
                                       <div class="g-recaptcha" data-sitekey="6LdfMJ8UAAAAALD5aUTrIF0b5_7m7gbIdgUGKCZD"></div>
                                    </div>
                                    <h3></h3>
                                    <div class="form-group mt-3">
                                        <label for="pwd"><span></span></label>
                                        <input type="hidden" value="<?php echo $_SESSION['_token']?>" name="hash">
                                        <button type="submit" class="btn update_btn btn-default" id="btnUpdate" name="acao" value="cadProf">Cadastrar-se</button>
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
