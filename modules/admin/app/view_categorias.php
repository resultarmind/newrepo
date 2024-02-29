<?php
session_start();
include_once "config/conection.php";

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login/login.php");
    exit();
}

// Recupere o panel_id do usuário do banco de dados
$username = $_SESSION["username"];
$sqlPanelId = "SELECT panel_id FROM usuarios WHERE username = '$username'";
$resultPanelId = $conn->query($sqlPanelId);

if ($resultPanelId->num_rows > 0) {
    $rowPanelId = $resultPanelId->fetch_assoc();
    $panel_id = $rowPanelId["panel_id"];

    // Busque todos os produtos associados ao panel_id
    $sqlProdutos = "SELECT * FROM categorias WHERE panel_id = '$panel_id'";
    $resultProdutos = $conn->query($sqlProdutos);
    
    if ($resultProdutos->num_rows > 0) {
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Painel de Admin Responsivo - Resultar Mind">
    <meta name="author" content="resultarmind">

    <title>Resultar Mind - Admin</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <!-- vendor css -->
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
    <link href="../lib/rickshaw/rickshaw.min.css" rel="stylesheet">
    <link href="../lib/chartist/chartist.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <!-- Bracket CSS -->
    <link rel="stylesheet" href="../css/bracket.css">
  </head>

  <body>

    <?php include_once 'config/header.php'?>

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.php">Início</a>
          <a class="breadcrumb-item" href="#">Categorias</a>
          <span class="breadcrumb-item active">Visualizar Categorias</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Visualizar Categorias</h4>
        <p class="mg-b-0">Visualize ou edite as categorias existentes.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">


        <a href="add_prod.php" class="btn btn-secondary"><i class="fa-solid fa-left-long"></i> Voltar</a>

        <hr>
        
          
        <table class="table table-bordered">
    <thead class="thead">
        <tr>
            <th>Categoria</th>
            <th>Tamanho</th>
            <th>Ações</th> <!-- Coluna para botões de ação -->
            <!-- Adicione mais colunas conforme necessário -->
        </tr>
    </thead>
    <tbody>
    <?php
while ($produto = $resultProdutos->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $produto["nome_categoria"] . "</td>";
    echo "<td>";

    if ($produto["tamanho_coluna"] == 1) {
        echo "1 Item";
    } elseif ($produto["tamanho_coluna"] == 2) {
        echo "2 Itens";
    } elseif ($produto["tamanho_coluna"] == 3) {
        echo "1 Fileira";
    } else {
        // Caso o valor não seja 1, 2, ou 3, você pode lidar com isso aqui
        echo "Outro valor";
    }
    
    echo "</td>";
    
    // Coluna de ações com botões de excluir e editar
    echo "<td>";
    
    // Link para excluir com SweetAlert
    echo '<a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $produto["id"] . ')">Excluir</a>';
    
    echo '|';
    
    // Link para editar
    echo '<a href="functions/tools/editar_categoria.php?id=' . $produto["id"] . '" class="btn btn-primary btn-sm">Editar</a>';
    
    echo "</td>";

    echo "</tr>";
}
?>

<!-- Adicione este script ao final da sua página ou no cabeçalho -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Esta ação é irreversível!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'functions/tools/excluir_categoria.php?id=' + id;
        }
    });
}
</script>


    </tbody>
</table>


        </div>
      </div>



    <?php include_once 'config/footer.php'?>

    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
    <script src="../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="../lib/moment/moment.js"></script>
    <script src="../lib/jquery-ui/jquery-ui.js"></script>
    <script src="../lib/jquery-switchbutton/jquery.switchButton.js"></script>
    <script src="../lib/peity/jquery.peity.js"></script>
    <script src="../lib/chartist/chartist.js"></script>
    <script src="../lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
    <script src="../lib/d3/d3.js"></script>
    <script src="../lib/rickshaw/rickshaw.min.js"></script>


    <script src="../js/bracket.js"></script>
    <script src="../js/ResizeSensor.js"></script>
    <script src="../js/dashboard.js"></script>
    <script>
      $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1299px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }
      });
    </script>
  </body>
</html>


<?php
    } else {
        echo 'Nenhum produto encontrado.';
    }
} else {
    echo "Erro ao obter o panel_id do usuário.";
}
?>

