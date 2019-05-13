<?php
  $idAdministrador = (int)$_GET['administrador'];
  $pegar_dados_administrador = BD::conn()->prepare("SELECT * FROM `tblcdsadm` WHERE id = ?");
  $pegar_dados_administrador->execute(array($idAdministrador));
  $dadosAdm = $pegar_dados_administrador->fetchObject();
  if(isset($_POST['acao']) && $_POST['acao'] == 'Editar'){
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
      if(isset($_POST['checkOrcamento']))
      {
          $checkOrcamento = $_POST['checkOrcamento'][0];
      }else{
          $checkOrcamento = 0;
      }
      if(isset($_POST['checkUnepe']))
      {
          $checkUnepe = $_POST['checkUnepe'][0];
      }else{
          $checkUnepe = 0;
      }
      if(isset($_POST['checkFornecedor']))
      {
          $checkFornecedor = $_POST['checkFornecedor'][0];
      }else{
          $checkFornecedor = 0;
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
          $data = date('Y-m-d');
          $verificarAdm = BD::conn()->prepare("SELECT id FROM `tblcdsadm` WHERE nome = ? and email = ? and senha = ? and data = ? and opCoo = ? and opUne = ? and opFor = ? and opAdm = ? and
                                              opProf = ? and opCat = ? and opProd = ? and opPed = ? and opRel = ? and opOrc = ?");
          $verificarAdm->execute(array($nome,$emailLog,$senhaLog,$data,$checkCoordenacao,$checkUnepe,$checkFornecedor,$checkAdministrador,$checkProfessor,$checkCategoria,
                                       $checkProduto,$checkPedido,$checkRelatorio,$checkOrcamento)); //select sem senha criptografa.
          if($verificarAdm->rowCount() > 0){
              echo '<script>alert("Não é possivel editar sem alguma alteração!");location:href="index.php?pagina=lisAdministrador"</script>';
          }else{
              $update = BD::conn()->prepare("UPDATE `tblcdsadm` SET nome = ? , email = ? , senha = ? , data = ? , opCoo = ? , opUne = ? , opFor = ? ,opAdm = ?,
                                            opProf = ? , opCat = ? , opProd = ? , opPed = ? , opRel = ?, opOrc = ? WHERE id = ?");
              $dados = array($nome,$emailLog,$senhaLog,$data,$checkCoordenacao,$checkUnepe,$checkFornecedor,$checkAdministrador,$checkProfessor,$checkCategoria,
                                            $checkProduto,$checkPedido,$checkRelatorio,$checkOrcamento,$idAdministrador);
              if($update->execute($dados)){
                 header("Location: index.php?pagina=lisAdministrador");
              }else{
                 echo '<script>alert("Erro, não foi possivel editar o administrador");location:href="index.php?pagina=lisAdministrador"</script>';
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
              <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $dadosAdm->nome; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Email:</label>
              <input type="text" class="form-control" name="emailLog" placeholder="Email" value="<?php echo $dadosAdm->email; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Senha:</label>
              <input type="password" class="form-control" name="senhaLog" placeholder="Senha" value="<?php echo $dadosAdm->senha; ?>">
            </div>
            <label class="card-title mt-5">Liberação de menu</label>
            <?php
            if ($dadosAdm->opCoo == 1){
                $checkCoo = 'checked';
            }else{
                $checkCoo = 'nochecked';
            }
            if ($dadosAdm->opUne == 1){
                $checkUne = 'checked';
            }else{
                $checkUne = 'nochecked';
            }
            if ($dadosAdm->opFor == 1){
                $checkFor = 'checked';
            }else{
                $checkFor = 'nochecked';
            }
            if ($dadosAdm->opAdm == 1){
                $checkAdm = 'checked';
            }else{
                $checkAdm = 'nochecked';
            }
            if ($dadosAdm->opProf == 1){
                $checkProf = 'checked';
            }else{
                $checkProf = 'nochecked';
            }
            if ($dadosAdm->opCat == 1){
                $checkCat = 'checked';
            }else{
                $checkCat = 'nochecked';
            }
            if ($dadosAdm->opProd == 1){
                $checkProd = 'checked';
            }else{
                $checkProd = 'nochecked';
            }
            if ($dadosAdm->opPed == 1){
                $checkPed = 'checked';
            }else{
                $checkPed = 'nochecked';
            }
            if ($dadosAdm->opRel == 1){
                $checkRel = 'checked';
            }else{
                $checkRel = 'nochecked';
            }
            if ($dadosAdm->opOrc == 1){
                $checkOrc = 'checked';
            }else{
                $checkOrc = 'nochecked';
            }
            ?>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      Menu Administradores
                    </th>
                    <th>
                      Menu Categorias
                    </th>
                    <th>
                      Menu Coordenações
                    </th>
                    <th>
                      Menu Fornecedores
                    </th>
                    <th>
                      Menu Orçamentos
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkAdministrador[]" value="1" <?php echo $checkAdm ?>>Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkCategoria[]" value="1" <?php echo $checkCat ?>>Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkCoordenacao[]" value="1" <?php echo $checkCoo ?>>Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkFornecedor[]" value="1" <?php echo $checkFor ?>>Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkOrcamento[]" value="1" <?php echo $checkOrc ?>>Permitir
                        </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      Menu Pedidos
                    </th>
                    <th>
                      Menu Produtos
                    </th>
                    <th>
                      Menu Professores
                    </th>
                    <th>
                      Menu Relatórios
                    </th>
                    <th>
                      Menu Unepes
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkPedido[]" value="1" <?php echo $checkPed ?>>Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkProduto[]" value="1" <?php echo $checkProd ?>>Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkProfessor[]" value="1" <?php echo $checkProf ?>>Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkRelatorio[]" value="1" <?php echo $checkRel ?>> Permitir
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="checkUnepe[]" value="1" <?php echo $checkUne ?>>Permitir
                        </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2 mt-5" value="Próximo Passo">Editar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Editar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
