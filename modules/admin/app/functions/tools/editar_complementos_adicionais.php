<?php
session_start();
include_once "../../config/conection.php";

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: ../../login/login.php");
    exit();
}

// Recupere o panel_id do usuário do banco de dados
$username = $_SESSION["username"];
$sqlPanelId = "SELECT panel_id FROM usuarios WHERE username = '$username'";
$resultPanelId = $conn->query($sqlPanelId);

if ($resultPanelId->num_rows > 0) {
    $rowPanelId = $resultPanelId->fetch_assoc();
    $panel_id = $rowPanelId["panel_id"];

    // Verifique se o id do complemento foi passado na URL
    if (isset($_GET["id"])) {
        $complemento_id = $_GET["id"];

        // Query para obter os detalhes do complemento com base no panel_id e no id do complemento
        $sql = "SELECT * FROM complementos_adicionais WHERE panel_id = $panel_id AND id = $complemento_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $produto = $result->fetch_assoc();
            // Agora você pode usar $produto para acessar os detalhes do complemento
        } else {
            echo "Complemento não encontrado.";
            exit();
        }
    } else {
        echo "ID do complemento não fornecido.";
        exit();
    }
} else {
    echo "Panel ID do usuário não encontrado.";
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
    <link href="../../../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../../../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../../../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../../../lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
    <link href="../../../lib/rickshaw/rickshaw.min.css" rel="stylesheet">
    <link href="../../../lib/chartist/chartist.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <!-- Bracket CSS -->
    <link rel="stylesheet" href="../../../css/bracket.css">
  </head>

  <body>

    <?php include_once '../../config/header.php'?>

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.php">Início</a>
          <a class="breadcrumb-item" href="#">Complementos</a>
          <span class="breadcrumb-item active">Editar Complementos</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Editar Complementos</h4>
        <p class="mg-b-0">Edite o Complemento selecionado.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">

        <form action="atualizar_complemento_adicional.php" method="post" class="mt-4">
    <!-- Adicione os campos do formulário com os valores atuais da complemento -->
    <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

    <div class="form-group">
        <label for="nome_complemento">Nome do complemento adicional:</label>
        <input type="text" name="nome_complemento" class="form-control" value="<?php echo $produto['nome_complemento']; ?>" required>
    </div>

<div class="form-group">
    <label for="valor">Valor do complemento adicional:</label>
    <div class="input-group">

    <input type="text" name="valor" class="form-control" value="<?php echo $produto['valor']; ?>" required>
      </div>
</div>



    <!-- Adicione outros campos conforme necessário -->

    <button type="submit" class="btn btn-primary">Atualizar</button>

    <!-- Adicione o botão de voltar -->
    <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
</form>





        </div>
      </div>



    <?php include_once 'config/footer.php'?>

    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="../../../lib/jquery/jquery.js"></script>
    <script src="../../../lib/popper.js/popper.js"></script>
    <script src="../../../lib/bootstrap/bootstrap.js"></script>
    <script src="../../../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="../../../lib/moment/moment.js"></script>
    <script src="../../../lib/jquery-ui/jquery-ui.js"></script>
    <script src="../../../lib/jquery-switchbutton/jquery.switchButton.js"></script>
    <script src="../../../lib/peity/jquery.peity.js"></script>
    <script src="../../../lib/chartist/chartist.js"></script>
    <script src="../../../lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
    <script src="../../../lib/d3/d3.js"></script>
    <script src="../../../lib/rickshaw/rickshaw.min.js"></script>


    <script src="../../js/bracket.js"></script>
    <script src="../../js/ResizeSensor.js"></script>
    <script src="../../js/dashboard.js"></script>
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

