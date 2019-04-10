<?php
if(isset($_POST['acao']) && $_POST['acao'] == 'Cadastrar'):
     include_once "inc/slug.php";
     $img_padrao  = $_FILES['img_padrao'];
     $titulo      = strip_tags(filter_input(INPUT_POST, 'titulo'));
     $slug        = slugify($titulo);
     $categoria   = $_POST['categoria'];
     $valAnterior = $_POST['valAnterior'];
     $valAtual    = $_POST['valAtual'];
     $descricao   = htmlentities($_POST['descricao'], ENT_QUOTES);
     $peso        = strip_tags(filter_input(INPUT_POST, 'peso'));
     $qtdEstoque  = strip_tags(filter_input(INPUT_POST, 'qtdEstoque'));
     $verificar_slug = BD::conn()->prepare("SELECT id FROM `tblcdsprod` WHERE slug = ?");
     $verificar_slug->execute(array($slug));
     if($verificar_slug->rowCount() > 0){
        $slug .= $verificar_slug->rowCount();
     }
     $validacao->set($titulo, 'Titulo')->obrigatorio();
     $validacao->set($categoria, 'Categoria')->obrigatorio();
     $validacao->set($valAtual, 'Valor Atual')->obrigatorio();
     $validacao->set($descricao, 'Descrição')->obrigatorio();
     $validacao->set($peso, 'Peso')->obrigatorio();
     $validacao->set($qtdEstoque, 'Quantidade em estoque')->obrigatorio();
     if(!$validacao->validar()){
        $erro = $validacao->getErro();
        echo '<div class="alert alert-danger" role="alert">
								<strong>Erro!</strong> '.$erro[0].'
							</div>';
     }elseif($img_padrao['error'] == '4'){
        echo '<div class="alert alert-warning" role="alert">
								<strong>Informe a imagem</strong>
							</div>';
     }else{
        $nomeImg = md5(uniqid(rand(), true)).$img_padrao['name'];
        $Site->upload($img_padrao['tmp_name'], $img_padrao['name'], $nomeImg, '350', '../../img/product/');
        $now = date('Y-m-d');
        $dados = array(  'img_padrao'      => $nomeImg,
                          'titulo'         => $titulo,
                          'slug'           => $slug,
                          'categoria'      => $categoria,
                          'subcategoria'   => 'VER SUBCATEGORIA',
                          'valor_anterior' => $valAnterior,
                          'valor_atual'    => $valAtual,
                          'descricao'      => $descricao,
                          'peso'           => $peso,
                          'estoque'        => $qtdEstoque,
                          'data'           => $now,
                          'views'          => 0
                        );
        if($Site->inserir('tblcdsprod', $dados)){
           $_SESSION['ultimoId'] = BD::conn()->lastInsertId();
           echo  ' <div class="card">
                     <div class="card-body">
                        <div class="card bg-gradient-success card-img-holder text-white">
                           <div class="card-body">
                             <h4 class="font-weight-normal mb-3">Ok, produto cadastrado corretamente!</h4>
                           </div>
                         </div>
                     </div>
                   </div>';
        }else{
          echo  ' <div class="card">
                    <div class="card-body">
                       <div class="card bg-gradient-danger card-img-holder text-white">
                          <div class="card-body">
                            <h4 class="font-weight-normal mb-3">Erro, não foi possivel cadastrar o produto!</h4>
                          </div>
                        </div>
                    </div>
                  </div>';
        }
     }
endif;
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Cadastro de Produto:</h4>
          <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Imagem Padrão:</label>
              <div class="input-group col-xs-12">
                <span class="input-group-append">
                  <input class="file-upload-browse btn btn-gradient-primary" type="file" name="img_padrao" value="Procurar"></input>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputName1">Titulo do produto:</label>
              <input type="text" class="form-control" name="titulo" placeholder="Titulo">
            </div>
            <div class="form-group">
              <label for="exampleSelectGender">Escolha a categoria:</label>
                <select class="form-control" name="categoria">
                  <option value="" selected="selected">Selecione</option>
                  <?php
                      $pegar_categorias = BD::conn()->prepare("SELECT * FROM `tblcdscat` ORDER BY id DESC");
                      $pegar_categorias->execute();
                      while($cat = $pegar_categorias->fetchObject()){
                  ?>
                  <option value="<?php echo $cat->slug; ?>" selected="selected"><?php echo $cat->titulo; ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Valor Anterior:</label>
              <input type="text" class="form-control" name="valAnterior" placeholder="Valor anterior">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Valor Atual:</label>
              <input type="text" class="form-control" name="valAtual" placeholder="Valor atual">
            </div>
            <div class="form-group">
              <label for="exampleTextarea1">Descrição do produto:</label>
              <textarea class="form-control" name="descricao" rows="5"  placeholder="Descrição"></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail3">Peso do produto:</label>
              <input type="text" class="form-control" name="peso" placeholder="Peso">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail3">Quantidade em estoque:</label>
              <input type="text" class="form-control" name="qtdEstoque" placeholder="Estoque">
            </div>
            <button type="submit" class="btn btn-gradient-primary mr-2" value="Próximo Passo">Cadastrar</button>
            <input type="hidden" class="btn btn-gradient-primary mr-2" name="acao" value="Cadastrar"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
