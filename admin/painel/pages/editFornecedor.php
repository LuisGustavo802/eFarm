<?php
  $idFornecedor = (int)$_GET['fornecedor'];
  $pegar_dados_fornecedor = BD::conn()->prepare("SELECT * FROM `tblcdsfor` WHERE id = ?");
  $pegar_dados_fornecedor->execute(array($idFornecedor));
  $dadosFor = $pegar_dados_fornecedor->fetchObject();
  if(isset($_POST['acao']) && $_POST['acao'] == 'Editar'){
      $nome        = strip_tags(filter_input(INPUT_POST, 'nome'));
      $cnpj        = strip_tags(filter_input(INPUT_POST, 'cnpj'));
      $cpf         = strip_tags(filter_input(INPUT_POST, 'cpf'));
      $email       = strip_tags(filter_input(INPUT_POST, 'email'));
      $telefone    = strip_tags(filter_input(INPUT_POST, 'telefone'));
      $endereco    = strip_tags(filter_input(INPUT_POST, 'endereco'));
      $bairro      = strip_tags(filter_input(INPUT_POST, 'bairro'));
      $complemento = strip_tags(filter_input(INPUT_POST, 'complemento'));
      $cidade      = strip_tags(filter_input(INPUT_POST, 'cidade'));
      $val = new Validacao();
      $val->set($nome    , 'Nome')->obrigatorio();
      $val->set($email, 'Email de Login')->isEmail();
      if(!$val->validar()){
          $erros = $val->getErro();
          echo  '<div class="alert alert-danger" role="alert">
  								<strong>'.$erros[0].'</strong>
  							</div>';
      }else{
          $verificarUsuario = BD::conn()->prepare("SELECT id FROM `tblcdsfor` WHERE nome = ? and cnpj = ? and cpf = ? and email = ? and telefone = ?
                                                                                and endereco = ? and bairro = ? and complemento = ? and cidade = ?");
          $verificarUsuario->execute(array($nome,$cnpj,$cpf,$email,$telefone,$endereco,$bairro,$complemento,$cidade));
          if($verificarUsuario->rowCount() > 0){
              echo '<script>alert("Esse fornecedor já está cadastrado!");location:href="'.PATH.'cadastro"</script>';
          }else{
            $update = BD::conn()->prepare("UPDATE `tblcdsfor` SET nome = ? , cnpj = ? , cpf = ? , email = ? , telefone = ?,
                                                              endereco = ? , bairro = ? , complemento = ? , cidade = ? WHERE id = ?");
            $dados = array($nome,$cnpj,$cpf,$email,$telefone,$endereco,$bairro,$complemento,$cidade,$idFornecedor);
            if($update->execute($dados)){
               header("Location: index.php?pagina=lisFornecedor");
            }else{
               echo '<script>alert("Erro, não foi possivel editar o fornecedor");location:href="index.php?pagina=lisFornecedor"</script>';
            }
          }
      }
 }
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Cadastro de Fornecedor</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo utf8_encode($dadosFor->nome); ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputName1">CNPJ:</label>
              <input type="text" class="form-control" name="cnpj" placeholder="CNPJ" value="<?php echo $dadosFor->cnpj ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputName1">CPF:</label>
              <input type="text" class="form-control" name="cpf" placeholder="CPF" value="<?php echo $dadosFor->cpf ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Email:</label>
              <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $dadosFor->email ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Telefone:</label>
              <input type="text" class="form-control" name="telefone" placeholder="Telefone" value="<?php echo $dadosFor->telefone ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Endereço:</label>
              <input type="text" class="form-control" name="endereco" placeholder="Endereço" value="<?php echo utf8_encode($dadosFor->endereco); ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Bairro:</label>
              <input type="text" class="form-control" name="bairro" placeholder="Bairro" value="<?php echo utf8_encode($dadosFor->bairro); ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Complemento:</label>
              <input type="text" class="form-control" name="complemento" placeholder="Complemento" value="<?php echo utf8_encode($dadosFor->complemento); ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Cidade:</label>
              <input type="text" class="form-control" name="cidade" placeholder="Cidade" value="<?php echo utf8_encode($dadosFor->cidade); ?>">
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2 mt-3" value="Próximo Passo">Editar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Editar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
