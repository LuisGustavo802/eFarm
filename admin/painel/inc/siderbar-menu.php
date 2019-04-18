<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">Conta Admin</span>
          <span class="text-secondary text-small">Verificada</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <?php if($usuarioLogado->opAdm == '1') { ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages1" aria-expanded="false" aria-controls="general-pages1">
        <span class="menu-title">Administradores</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-account-key menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="?pagina=cadAdministrador"> Cadastrar Administrador </a></li>
          <li class="nav-item"> <a class="nav-link" href="?pagina=lisAdministrador"> Listar Administradores </a></li>
        </ul>
        </div>
    </li>
    <?php } ?>
    <?php if($usuarioLogado->opCat == '1') { ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages2" aria-expanded="false" aria-controls="general-pages2">
        <span class="menu-title">Categorias</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-animation menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages2">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="?pagina=cadCategoria"> Cadastrar Categoria </a></li>
          <li class="nav-item"> <a class="nav-link" href="?pagina=lisCategoria"> Listar Categorias </a></li>
        </ul>
        </div>
    </li>
    <?php } ?>
    <?php if($usuarioLogado->opCoo == '1') { ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages3" aria-expanded="false" aria-controls="general-pages3">
        <span class="menu-title">Coordenações</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-library menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages3">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="?pagina=cadCoordenacao"> Cadastrar Coordenação </a></li>
          <li class="nav-item"> <a class="nav-link" href="?pagina=lisCoordenacao"> Listar Coordenações </a></li>
        </ul>
        </div>
    </li>
    <?php } ?>
    <?php if($usuarioLogado->opFor == '1') { ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages4" aria-expanded="false" aria-controls="general-pages4">
        <span class="menu-title">Fornecedores</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-account-switch menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages4">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="?pagina=cadFornecedor"> Cadastrar Fornecedor </a></li>
          <li class="nav-item"> <a class="nav-link" href="?pagina=lisFornecedor"> Listar Fornecedores </a></li>
        </ul>
        </div>
    </li>
    <?php } ?>
    <?php if($usuarioLogado->opPed == '1') { ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages5" aria-expanded="false" aria-controls="general-pages5">
        <span class="menu-title">Pedidos</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-clipboard-text menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages5">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="?pagina=pedidos"> Todos os pedidos </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Pedidos de produto </a></li>
        </ul>
        </div>
    </li>
    <?php } ?>
    <?php if($usuarioLogado->opProd == '1') { ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages6" aria-expanded="false" aria-controls="general-pages6">
        <span class="menu-title">Produtos</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-package-variant menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages6">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="?pagina=cadProdutos"> Cadastrar Produto </a></li>
          <li class="nav-item"> <a class="nav-link" href="?pagina=lisProdutos"> Listar Produtos </a></li>
          <li class="nav-item"> <a class="nav-link" href="?pagina=estProdutos"> Gerenciar Estoque </a></li>
        </ul>
        </div>
    </li>
    <?php } ?>
    <?php if($usuarioLogado->opProf == '1') { ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages7" aria-expanded="false" aria-controls="general-pages7">
        <span class="menu-title">Professores</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-school menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages7">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="?pagina=cadProfessor"> Cadastrar Professor </a></li>
          <li class="nav-item"> <a class="nav-link" href="?pagina=lisProfessor"> Listar Professores </a></li>
        </ul>
        </div>
    </li>
    <?php } ?>
    <?php if($usuarioLogado->opRel == '1') { ?>
     <li class="nav-item">
       <a class="nav-link" data-toggle="collapse" href="#general-pages8" aria-expanded="false" aria-controls="general-pages8">
         <span class="menu-title">Relatórios</span>
         <i class="menu-arrow"></i>
         <i class="mdi mdi-cloud-print menu-icon"></i>
       </a>
       <div class="collapse" id="general-pages8">
         <ul class="nav flex-column sub-menu">
           <li class="nav-item"> <a class="nav-link" href="?pagina=geraRelResumido"> Gerar relatório resumido </a></li>
           <li class="nav-item"> <a class="nav-link" href="?pagina=geraRelCompleto"> Gerar relatório completo </a></li>
         </ul>
         </div>
     </li>
     <?php } ?>
    <?php if($usuarioLogado->opUne == '1') { ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages9" aria-expanded="false" aria-controls="general-pages9">
        <span class="menu-title">Unepes</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-bank menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages9">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="?pagina=cadUnepe"> Cadastrar Unepe </a></li>
          <li class="nav-item"> <a class="nav-link" href="?pagina=lisUnepe"> Listar Unepes </a></li>
        </ul>
        </div>
    </li>
    <?php } ?>
  </ul>
</nav>
