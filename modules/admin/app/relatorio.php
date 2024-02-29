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
          <a class="breadcrumb-item" href="#">Relatório</a>
          <span class="breadcrumb-item active">Relatório de Vendas</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Relatório de Vendas</h4>
        <p class="mg-b-0">Veja o relatório de vendas.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">

        <?php
include_once "config/conection.php";


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

// Consulta ao banco de dados para obter todos os pedidos finalizados
$sqlPedidosFinalizados = "SELECT id, nome_cliente, metodo_entrega, data_pedido FROM pedidos WHERE status = 'finalizado' ORDER BY data_pedido DESC";
$resultadoPedidosFinalizados = $conn->query($sqlPedidosFinalizados);

// Inicialização de variáveis
$melhorDia = null;
$piorDia = null;
$totalVendas = 0;
$contagemDias = 0;

if ($resultadoPedidosFinalizados->num_rows > 0) {
    ?>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Pedidos Finalizados</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Entrega</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($pedidoFinalizado = $resultadoPedidosFinalizados->fetch_assoc()) {
                    // Consulta ao banco de dados para obter os itens associados a este pedido
                    $sqlItensPedido = "SELECT preco FROM itens_pedido WHERE pedido_id = ?";
                    $stmtItensPedido = $conn->prepare($sqlItensPedido);
                    $stmtItensPedido->bind_param("i", $pedidoFinalizado['id']);
                    $stmtItensPedido->execute();
                    $resultItensPedido = $stmtItensPedido->get_result();

                    $valorTotalPedido = 0;

                    while ($itemPedido = $resultItensPedido->fetch_assoc()) {
                        // Adiciona o preço do item ao valor total do pedido
                        $valorTotalPedido += $itemPedido['preco'];
                    }

                    // Adiciona o valor total ao total de vendas
                    $totalVendas += $valorTotalPedido;

                    // Incrementa a contagem de dias
                    $contagemDias++;

                    // Verifica se é o melhor dia
                    if ($melhorDia === null || $valorTotalPedido > $melhorDia['valor']) {
                        $melhorDia = [
                            'data' => $pedidoFinalizado['data_pedido'],
                            'valor' => $valorTotalPedido
                        ];
                    }

                    // Verifica se é o pior dia
                    if ($piorDia === null || $valorTotalPedido < $piorDia['valor']) {
                        $piorDia = [
                            'data' => $pedidoFinalizado['data_pedido'],
                            'valor' => $valorTotalPedido
                        ];
                    }

                    echo "<tr>";
                    echo "<td>{$pedidoFinalizado['id']}</td>";
                    echo "<td>" . date('d/m/Y H:i:s', strtotime($pedidoFinalizado['data_pedido'])) . "</td>";
                    echo "<td>{$pedidoFinalizado['nome_cliente']}</td>";
                    echo "<td>{$pedidoFinalizado['metodo_entrega']}</td>";
                    echo "<td>R$ " . number_format($valorTotalPedido, 2, ',', '.') . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        // Calcular o dia médio de vendas
        $diaMedio = ($contagemDias > 0) ? $totalVendas / $contagemDias : 0;
        ?>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="alert alert-success">
                    <strong>Melhor Dia de Vendas:</strong> <?php echo ($melhorDia !== null) ? strftime('%d/%m/%Y', strtotime($melhorDia['data'])) . ' (' . strftime('%A', strtotime($melhorDia['data'])) . ')' : 'N/A'; ?> - Valor: R$ <?php echo ($melhorDia !== null) ? number_format($melhorDia['valor'], 2, ',', '.') : 'N/A'; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-danger">
                    <strong>Pior Dia de Vendas:</strong> <?php echo ($piorDia !== null) ? strftime('%d/%m/%Y', strtotime($piorDia['data'])) . ' (' . strftime('%A', strtotime($piorDia['data'])) . ')' : 'N/A'; ?> - Valor: R$ <?php echo ($piorDia !== null) ? number_format($piorDia['valor'], 2, ',', '.') : 'N/A'; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-info">
                    <strong>Dia Médio de Vendas:</strong> R$ <?php echo number_format($diaMedio, 2, ',', '.'); ?>
                </div>
            </div>
        </div>
    </div>

    <?php
} else {
    echo "<p class='text-center'>Nenhum pedido finalizado registrado.</p>";
}
?>







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
