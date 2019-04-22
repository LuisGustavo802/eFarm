<?php
    $id_pedido   = (int)$_GET['pedido_id'];
    $pegar_dados = BD::conn()->prepare("SELECT * FROM `tblmvmped` WHERE id = ?");
    $pegar_dados->execute(array($id_pedido));
    $fetchPedido = $pegar_dados->fetchObject();
    if($fetchPedido->status == 0){
        $status = 'Pendente';
        $btnSts = 'warning';
    }elseif($fetchPedido->status == 1){
        $status = 'Autorizado';
        $btnSts = 'success';
    }elseif($fetchPedido->status == 2){
        $status = 'Recusado';
        $btnSts = 'danger';
    }
    $pegar_prof = BD::conn()->prepare("SELECT * FROM `tblcdsprof` WHERE id = ?");
    $pegar_prof->execute(array($fetchPedido->id_prof));
    $dadosProf  = $pegar_prof->fetchObject();
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Detalhe pedido <?php echo $id_pedido ?></h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      Nome professor
                    </th>
                    <th>
                      Status
                    </th>
                  <tr>
                  <tr>
                  </tr>
                 </thead>
                 <tbody>
                  <tr>
                    <td>
                        <?php echo $dadosProf->nome ?>
                    </td>
                    <td>
                      <label class="badge badge-gradient-<?php echo $btnSts ?>"><?php echo $status ?></label>
                    </td>
                  </tr>
                 <tr>
                   <td></td><td></td>
                 </tr>
                </tbody>
              </table>
              <table class="table">
                <thead>
                  <tr>
                    <th>
                      Produto
                    </th>
                    <th>
                      Valor aprox.
                    </th>
                    <th>
                      Quantidade solicitada
                    </th>
                  </tr>
                 </thead>
                <tbody>
                  <tr>
                    <?php
                        $pegar_produtos = BD::conn()->prepare("SELECT * FROM `tblmvmprodped` WHERE id_pedido = ?");
                        $pegar_produtos->execute(array($fetchPedido->id));
                        while($produto = $pegar_produtos->fetchObject()){
                              $pegar_dados_produto = BD::conn()->prepare("SELECT titulo, valor_atual FROM `tblcdsprod` WHERE id = ?");
                              $pegar_dados_produto->execute(array($produto->id_produto));
                              $fetch = $pegar_dados_produto->fetchObject();
                     ?>
                      <td>
                        <?php echo $fetch->titulo; ?>
                      </td>
                      <td>
                        R$ <?php echo number_format($fetch->valor_atual, 2,',','.'); ?>
                      </td>
                      <td>
                        <?php echo $produto->qtd; ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin">
             <div class="card">
               <div class="card-body">
                 <h4 class="card-title">Alterar quantidade</h4>
                 <div class="form-group">
                   <label>Escolha o produto e informe a nova quantidade</label>
                  <form action="" method="post" enctype="multipart/form-data">
                    <?php
                        $pegar_produtos = BD::conn()->prepare("SELECT * FROM `tblmvmprodped` WHERE id_pedido = ?");
                        $pegar_produtos->execute(array($fetchPedido->id));
                        while($produto = $pegar_produtos->fetchObject()){
                              $pegar_dados_produto = BD::conn()->prepare("SELECT titulo, valor_atual FROM `tblcdsprod` WHERE id = ?");
                              $pegar_dados_produto->execute(array($produto->id_produto));
                              $fetch = $pegar_dados_produto->fetchObject();
                     ?>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="check[]" value="<?php echo $produto->id_produto; ?>">
                        <?php echo $fetch->titulo; ?>
                      </label>
                    </div>
                   <?php } ?>
                   <input type="text" class="form-control form-control-lg" placeholder="Quantidade" aria-label="Username" name="qtd">
                   <button type="submit" class="btn btn-gradient-primary mr-2 mt-4" value="Próximo Passo">Alterar quantidade</button>
                   <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="mudarQtd"/>
                 </form>
                 </div>
               </div>
             </div>
           </div>
           <div class="col-md-6 grid-margin stretch-card">
             <div class="card">
               <div class="card-body">
                 <h4 class="card-title">Alterar status</h4>
                <form action="" method="post" enctype="multipart/form-data">
                 <div class="form-group">
                   <label for="exampleFormControlSelect1">Informe o novo status</label>
                   <select class="form-control form-control-lg" name="status">
                     <option value="" value="selected">Selecione</option>
                     <option value="0">Pendente</option>
                     <option value="1">Pedido</option>
                     <option value="2">Recusado</option>
                   </select>
                 </div>
                 <button type="submit" class="btn btn-gradient-primary mr-2 mt-1" value="Próximo Passo">Alterar status</button>
                 <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="mudarSts"/>
               </form>
               </div>
             </div>
           </div>
        </div>
      </div>
    </div>
<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'mudarSts'):
      $status = $_POST['status'];
      if ($status != ""){
          $atualizar = BD::conn()->prepare("UPDATE `tblmvmped` SET `status` = ? WHERE id = ?");
          $dados = array($status,$id_pedido);
          if($atualizar->execute($dados)){
              echo '<script>alert("Status modificado com sucesso!");location.href="?pagina=detPedidos&pedido_id='.$id_pedido.'"</script>';
          }
      }else{
          $id_pedido   = (int)$_GET['pedido_id'];
          $pegar_dados = BD::conn()->prepare("SELECT * FROM `tblmvmped` WHERE id = ?");
          $pegar_dados->execute(array($id_pedido));
          $fetchPedido = $pegar_dados->fetchObject();
          $status = $fetchPedido->status;
          $atualizar = BD::conn()->prepare("UPDATE `tblmvmped` SET `status` = ? WHERE id = ?");
          $dados = array($status,$id_pedido);
          $atualizar->execute($dados);
          echo '<script>alert("Selecione o novo status!");location.href="?pagina=detPedidos&pedido_id='.$id_pedido.'"</script>';
      }
  endif;
  if(isset($_POST['acao']) && $_POST['acao'] == 'mudarQtd'):
      $newQtd = $_POST['qtd'];
      $prod = $_POST['check'][0];
      if ($newQtd != "" || $prod != ""){
          $atualizar = BD::conn()->prepare("UPDATE `tblmvmprodped` SET `qtd` = ? WHERE id_pedido = ? AND id_produto = ?");
          $dados = array($newQtd,$id_pedido,$prod);
          if($atualizar->execute($dados)){
              echo '<script>alert("Quantidade atualizada com sucesso!");location.href="?pagina=detPedidos&pedido_id='.$id_pedido.'"</script>';
          }
      }else{
          echo '<script>alert("É preciso escolher um produto e informar a nova quantidade para atualizar!");location.href="?pagina=detPedidos&pedido_id='.$id_pedido.'"</script>';
      }
  endif;
?>
