<?php
$idProfessor = $usuarioLogado->id;
$pegar_dados_professor = BD::conn()->prepare("SELECT * FROM `tblcdsprof` WHERE id = ?");
$pegar_dados_professor->execute(array($idProfessor));
$dadosProf = $pegar_dados_professor->fetchObject();
if (isset($_POST['acao']) && $_POST['acao'] == 'Editar') {
  $nome     = strip_tags(filter_input(INPUT_POST, 'nome'));
  $senhaLog = strip_tags(filter_input(INPUT_POST, 'senhaLog'));
  $val = new Validacao();
  $val->set($nome, 'Nome')->obrigatorio();
  $val->set($senhaLog, 'Senha de Login')->obrigatorio();
  if (!$val->validar()) {
    $erros = $val->getErro();
    echo  '<div class="alert alert-danger" role="alert">
  								<strong>' . $erros[0] . '</strong>
  							</div>';
  } else {
    $verificarProf = BD::conn()->prepare("SELECT id FROM `tblcdsprof` WHERE nome = ? and email = ? and senha = ?");
    $verificarProf->execute(array($nome, $usuarioLogado->email, $senhaLog));
    if ($verificarProf->rowCount() > 0) {
      echo '<script>alert("Já existe um professor com esses dados!");location:href="index.php"</script>';
    } else {
      if (substr($usuarioLogado->email, 0, 4) == "prof") {
        $options = ['cost' => 10,];
        $update = BD::conn()->prepare("UPDATE `tblcdsprof` SET nome = ?, senha = ?, tipo_usuario = ? where id = ?");
        $dados = array($nome, password_hash($senhaLog, PASSWORD_DEFAULT, $options), '0', $idProfessor);
        if ($update->execute($dados)) {
          echo '<script>alert("Ok, dados atualizados com sucesso!");location:href="index.php"</script>';
        }
      } else {
        echo '<script>alert("Erro, não foi possivel editar os seus dados!");location:href="index.php"</script>';
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
          <h4 class="card-title">Edição de professor</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputName1">Nome:</label>
              <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $dadosProf->nome; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Senha:</label>
              <input type="password" class="form-control" name="senhaLog" placeholder="Senha" value="<?php echo $dadosProf->senha; ?>">
            </div>
            <button type="submit" class="btn btn-gradient-primary mt-5 mr-2" value="Próximo Passo">Editar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Editar" />
          </form>
        </div>
      </div>
    </div>
  </div>
</div>