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
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages7" aria-expanded="false" aria-controls="general-pages7">
        <span class="menu-title">Meu perfil</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-school menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages7">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="?pagina=editProfessor"> Editar perfil </a></li>
        </ul>
        </div>
    </li>
    <?php if($usuarioLogado->opRel == '1') { ?>
     <li class="nav-item">
       <a class="nav-link" data-toggle="collapse" href="#general-pages8" aria-expanded="false" aria-controls="general-pages8">
         <span class="menu-title">Relatórios</span>
         <i class="menu-arrow"></i>
         <i class="mdi mdi-cloud-print menu-icon"></i>
       </a>
       <div class="collapse" id="general-pages8">
         <ul class="nav flex-column sub-menu">
           <li class="nav-item"> <a class="nav-link" href="?pagina=geraRelResumido"> Relatório Resumido </a></li>
           <li class="nav-item"> <a class="nav-link" href="?pagina=geraRelCompleto"> Relatório Completo </a></li>
         </ul>
         </div>
     </li>
     <?php } ?>
  </ul>
</nav>
