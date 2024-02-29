<?php

session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login/login.php"); // Redirecione para a página de login se o usuário não estiver autenticado
    exit();
}

?>

<?php
    // Obtém o caminho do diretório atual
    $currentPath = dirname($_SERVER['PHP_SELF']);

    // Divide o caminho em partes usando '/'
    $pathParts = explode('/', $currentPath);
    
    // Se o diretório atual não for "app" ou um subdiretório de "app", define o basePath para "./"
    if (!in_array('app', $pathParts)) {
        $basePath = "./";
    } else {
        // Calcula quantos diretórios subir até chegar em "app"
        $levelsUp = count($pathParts) - array_search('app', $pathParts) - 1;
        // Define o basePath para o número correto de "../" para permanecer dentro de "app"
        $basePath = str_repeat("../", $levelsUp);
    }

    // Monta o link com base no basePath
    $linkHref = $basePath . 'index.php';
?>


<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href="<?php echo $linkHref; ?>"><span>[</span>ProntoPraPedir<span>]</span></a></div>
    <div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-15 mg-t-20">Navegação</label>
      <div class="br-sideleft-menu">

<a href="<?php echo $linkHref; ?>" class="br-menu-link active">


          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Início</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->




        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Produtos</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="add_prod.php" class="nav-link">Adicionar Produto</a></li>
          <li class="nav-item"><a href="view_produto.php" class="nav-link">Visualizar / Editar</a></li>
        </ul>

        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Relatórios</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="relatorio.php" class="nav-link">Vendas</a></li>
          <li class="nav-item"><a href="relatorio_itens.php" class="nav-link">Itens Mais Vendidos</a></li>
        </ul>


        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Site</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="view_infos.php" class="nav-link">Alterar Informações</a></li>
        </ul>


      </div><!-- br-sideleft-menu -->




      <br>
    </div><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <div class="br-header">
      <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="input-group hidden-xs-down wd-170 transition">


        </div><!-- input-group -->
      </div><!-- br-header-left -->
      <div class="br-header-right">

      </div><!-- br-header-right -->
    </div><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
