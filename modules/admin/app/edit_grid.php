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
          <a class="breadcrumb-item" href="#">Grid</a>
          <span class="breadcrumb-item active">Ordenar Categorias</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Ordenar Categorias</h4>
        <p class="mg-b-0">Mova as categorias como preferir.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">

        <style>
    .sortable-list {
      list-style-type: none;
      padding: 0;
    }

    .sortable-item {
      margin: 5px;
      padding: 10px;
      border: 1px solid #ccc;
      background-color: #f9f9f9;
      cursor: grab;
    }

    .sortable-list,
    .connected-list {
      min-height: 50px;
      border: 1px solid #ccc;
      margin-bottom: 10px;
    }

    #saveBtn {
      margin-top: 10px;
    }
  </style>

<div class="container">
  <div class="row">
  <div class="col-md-12 mb-5">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Categorias Únicas (Topo)</h5>
          <ul class="sortable-list connected-list" id="sortable-top">
            <!-- Categorias vazias para permitir movimento entre as listas -->
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Categorias Esquerda</h5>
          <ul class="sortable-list connected-list" id="sortable-left">
            <li class="sortable-item">Categoria 1</li>
            <li class="sortable-item">Categoria 2</li>
            <li class="sortable-item">Categoria 3</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Categorias Direita</h5>
          <ul class="sortable-list connected-list" id="sortable-right">
            <!-- Categorias vazias para permitir movimento entre as listas -->
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-12 mt-5">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Categorias Únicas (Baixo)</h5>
          <ul class="sortable-list connected-list" id="sortable-baixo">
            <!-- Categorias vazias para permitir movimento entre as listas -->
          </ul>
        </div>
      </div>
    </div>

  </div>
  <button id="saveBtn" class="btn btn-primary">Salvar Ordenação</button>
</div>

<script>
  $(function() {
    $(".connected-list").sortable({
      connectWith: ".connected-list",
      cursor: "grab"
    });

    $(".sortable-list, .connected-list").disableSelection();

    $("#saveBtn").on("click", function() {
      // Obter a ordem atual das categorias na lista da esquerda
      var orderLeft = $("#sortable-left").sortable("toArray");

      // Obter a ordem atual das categorias na lista da direita
      var orderRight = $("#sortable-right").sortable("toArray");

      // Você pode agora enviar 'orderLeft' e 'orderRight' para o servidor ou salvá-los localmente
      console.log("Ordem à esquerda:", orderLeft);
      console.log("Ordem à direita:", orderRight);
    });
  });
</script>

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
