<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'Cadastrar'){
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
              $dados = array(
                              'nome'         => $nome,
                              'cnpj'         => $cnpj,
                              'cpf'          => $cpf,
                              'email'        => $email,
                              'telefone'     => $telefone,
                              'endereco'     => $endereco,
                              'bairro'       => $bairro,
                              'complemento'  => $complemento,
                              'cidade'       => $cidade
                            );
              if($Site->inserir('tblcdsfor', $dados)){
                  echo '<script>alert("Ok, fornecedor cadastrado com sucesso!");location:href="index.php?pagina=lisFornecedor"</script>';
              }else{
                  echo '<script>alert("Erro, não foi possivel cadastrar esse fornecedor!");location:href="index.php?pagina=lisFornecedor"</script>';
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
              <input type="text" class="form-control" name="nome" placeholder="Nome">
            </div>
            <div class="form-group">
              <label for="exampleInputName1">CNPJ:</label>
              <input type="text" class="form-control" name="cnpj" placeholder="CNPJ">
            </div>
            <div class="form-group">
              <label for="exampleInputName1">CPF:</label>
              <input type="text" class="form-control" name="cpf" placeholder="CPF">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Email:</label>
              <input type="text" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Telefone:</label>
              <input type="text" class="form-control" name="telefone" placeholder="Telefone">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Endereço:</label>
              <input type="text" class="form-control" name="endereco" placeholder="Endereço">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Bairro:</label>
              <input type="text" class="form-control" name="bairro" placeholder="Bairro">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Complemento:</label>
              <input type="text" class="form-control" name="complemento" placeholder="Complemento">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Cidade:</label>
              <input type="text" class="form-control" name="cidade" placeholder="Cidade">
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2 mt-3" value="Próximo Passo">Cadastrar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Cadastrar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
