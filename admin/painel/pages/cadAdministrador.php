<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'Cadastrar'){
      $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
      $emailLog = strip_tags(filter_input(INPUT_POST, 'emailLog'));
      $senhaLog = strip_tags(filter_input(INPUT_POST, 'senhaLog'));
      $val = new Validacao();
      $val->set($nome    , 'Nome')->obrigatorio();
      $val->set($emailLog, 'Email de Login')->isEmail();
      $val->set($senhaLog, 'Senha de Login')->obrigatorio();
      if(isset($_POST['checkCoordenacao']))
      {
          $checkCoordenacao = $_POST['checkCoordenacao'][0];
      }else{
          $checkCoordenacao = 0;
      }
      if(isset($_POST['checkUnepe']))
      {
          $checkUnepe = $_POST['checkUnepe'][0];
      }else{
          $checkUnepe = 0;
      }
      if(isset($_POST['checkAdministrador']))
      {
          $checkAdministrador = $_POST['checkAdministrador'][0];
      }else{
          $checkAdministrador = 0;
      }
      if(isset($_POST['checkProfessor']))
      {
          $checkProfessor = $_POST['checkProfessor'][0];
      }else{
          $checkProfessor = 0;
      }
      if(isset($_POST['checkCategoria']))
      {
          $checkCategoria = $_POST['checkCategoria'][0];
      }else{
          $checkCategoria = 0;
      }
      if(isset($_POST['checkProduto']))
      {
          $checkProduto = $_POST['checkProduto'][0];
      }else{
          $checkProduto = 0;
      }
      if(isset($_POST['checkPedido']))
      {
          $checkPedido = $_POST['checkPedido'][0];
      }else{
          $checkPedido = 0;
      }
      if(isset($_POST['checkRelatorio']))
      {
          $checkRelatorio = $_POST['checkRelatorio'][0];
      }else{
          $checkRelatorio = 0;
      }
      if(!$val->validar()){
          $erros = $val->getErro();
          echo  '<div class="alert alert-danger" role="alert">
  								<strong>'.$erros[0].'</strong>
  							</div>';
      }else{
          $now = date('Y-m-d');
          $verificarUsuario = BD::conn()->prepare("SELECT id FROM `tblcdsadm` WHERE email = ?");
          $verificarUsuario->execute(array($emailLog));
          if($verificarUsuario->rowCount() > 0){
              echo '<script>alert("Esse email já está cadastrado, escolha outro!");location:href="index.php?pagina=cadAdministrador"</script>';
          }else{
              $dados = array(
                              'nome'   => $nome,
                              'email'  => $emailLog,
                              'senha'  => $senhaLog,
                              'data'   => $now,
                              'opCoo'  => $checkCoordenacao,
                              'opUne'  => $checkUnepe,
                              'opAdm'  => $checkAdministrador,
                              'opProf' => $checkProfessor,
                              'opCat'  => $checkCategoria,
                              'opProd' => $checkProduto,
                              'opPed'  => $checkPedido,
                              'opRel'  => $checkRelatorio
                            );
              if($Site->inserir('tblcdsadm', $dados)){
                 echo '<script>alert("Ok, administrador cadastrado com sucesso!");location:href="index.php?pagina=lisAdministrador"</script>';
              }else{
                 echo '<script>alert("Erro, não foi possivel cadastrar o administrador");location:href="index.php?pagina=lisAdministrador"</script>';
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
          <h4 class="card-title">Cadastro de administrador</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Email:</label>
              <input type="text" class="form-control" name="emailLog" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Senha:</label>
              <input type="text" class="form-control" name="senhaLog" placeholder="Senha">
            </div>
            <label class="card-title mt-5">Liberação de menu</label>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      Menu Coordenações
                    </th>
                    <th>
                      Menu Unepes
                    </th>
                    <th>
                      Menu Administradores
                    </th>
                    <th>
                      Menu Professores
                    </th>
                    <th>
                      Menu Categorias
                    </th>
                    <th>
                      Menu Produtos
                    </th>
                    <th>
                      Menu Pedidos
                    </th>
                    <th>
                      Menu Relatórios
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkCoordenacao[]" value="1">Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkUnepe[]" value="1">Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkAdministrador[]" value="1">Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkProfessor[]" value="1">Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkCategoria[]" value="1">Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkProduto[]" value="1">Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkPedido[]" value="1">Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkRelatorio[]" value="1"> Permitir
                        </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              </div>
            <button type="submit" class="btn btn-gradient-primary mr-2 mt-5" value="Próximo Passo">Cadastrar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Cadastrar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
