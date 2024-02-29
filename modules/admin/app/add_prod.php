<?php

session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login/login.php"); // Redirecione para a página de login se o usuário não estiver autenticado
    exit();
}

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

  <style>

@keyframes moveBackAndForth {
    0% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(5px); /* Altere a distância desejada */
    }
    100% {
        transform: translateX(0);
    }
}

.move-back-and-forth {
    animation: moveBackAndForth 2s linear infinite;
}

button{
    cursor: pointer;
}

  </style>



    <?php include_once 'config/header.php'?>



    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.php">Início</a>
          <a class="breadcrumb-item" href="#">Produtos</a>
          <span class="breadcrumb-item active">Adicionar Produto</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Adicionar Produto</h4>
        <p class="mg-b-0">Adicione um novo produto através do formulário abaixo.</p>
      </div>

      <div id="elementToHighlight">

    <?php include_once"functions/includes/atalhos.php"; ?>
    </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">

    <h4 class="tx-gray-800 mg-b-5 mb-4">Insira o novo item:</h4>

    <form method="post" action="functions/processar_item.php" enctype="multipart/form-data">
          <?php

include_once "config/conection.php"; // Certifique-se de incluir corretamente o arquivo de conexão

session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login/login.php"); // Redirecione para a página de login se o usuário não estiver autenticado
    exit();
}

// Recupere o panel_id do usuário do banco de dados
$username = $_SESSION["username"];

$sqlPanelID = "SELECT panel_id FROM usuarios WHERE username = '$username'";
$resultPanelID = $conn->query($sqlPanelID);

if ($resultPanelID->num_rows > 0) {
    $rowPanelID = $resultPanelID->fetch_assoc();
    $panel_id = $rowPanelID["panel_id"];

    // Consulta para obter as categorias com base no panel_id
    $sqlCategorias = "SELECT id, nome_categoria FROM categorias WHERE panel_id = $panel_id";
    $resultCategorias = $conn->query($sqlCategorias);

    // Verifique se há categorias disponíveis
    if ($resultCategorias->num_rows > 0) {
        // Array para armazenar as opções do menu suspenso
        $opcoesColuna = array();

// Preencha o array com as opções
while ($rowCategoria = $resultCategorias->fetch_assoc()) {
  $opcoesColuna[] = '<option value="' . $rowCategoria['nome_categoria'] . '">' . $rowCategoria['nome_categoria'] . '</option>';
}

// Exiba o menu suspenso
echo '<div class="form-group">';
echo '<label for="coluna">Selecione a Coluna:</label>';
echo '<select class="form-control" id="coluna" name="coluna" Required>';

// Imprima as opções
foreach ($opcoesColuna as $opcao) {
  echo $opcao;
}

echo '</select>';
echo '</div>';
    } else {
        // Lidar com a situação em que não há categorias disponíveis
        echo "Nenhuma categoria encontrada.";
    }
} else {
    // Lidar com a situação em que o panel_id não foi encontrado
    echo "Erro ao obter o panel_id do usuário.";
}

// Feche a conexão com o banco de dados

?>

<div class="form-group">
  <label for="nomeItem">Nome do Item:</label>
  <input type="text" class="form-control" id="nomeItem" name="nomeItem" placeholder="Digite o nome do item" Required>
</div>


<div class="form-group">
        <label for="imagemItem">Imagem do Item:</label>
        <input type="file" class="form-control" id="imagemItem" name="imagemItem" Required>
    </div>

    <hr>
  <div class="d-flex align-items-center justify-content-center">
  <button type="submit" class="btn btn-warning p-3"><strong class="mr-1">Prosseguir</strong> <i class="fa-solid fa-forward move-back-and-forth"></i></button>
</div>

  </form>

  </div>




</div>






<script>
    function enviarComplemento(formComplemento1) {
        var form = document.getElementById(formComplemento1);

        if (form) {
            form.submit();
        } else {
            console.error("Formulário não encontrado com o ID:", formComplemento1);
        }
    }

    function enviarComplemento2(formComplemento2) {
        var form = document.getElementById(formComplemento2);

        if (form) {
            form.submit();
        } else {
            console.error("Formulário não encontrado com o ID:", formComplemento2);
        }
    }

</script>




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
