<?php

// Inicie a sessão
session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login/login.php"); // Redirecione para a página de login se o usuário não estiver autenticado
    exit();
}

// Inclua seu arquivo de conexão com o banco de dados (substitua 'seu_arquivo_de_conexao.php' pelo nome real do arquivo)
include_once "config/conection.php";

// Recupere o panel_id do usuário do banco de dados
$username = $_SESSION["username"];
$sqlPanelId = "SELECT panel_id FROM usuarios WHERE username = '$username'";
$resultPanelId = $conn->query($sqlPanelId);

// Verifique se a consulta foi bem-sucedida
if ($resultPanelId === false) {
    die("Erro na consulta: " . $conn->error);
}

// Verifique se foi retornado algum resultado
if ($resultPanelId->num_rows > 0) {
    // Obtenha os dados do usuário
    $row = $resultPanelId->fetch_assoc();
    $panelId = $row["panel_id"];

    // Agora, você pode usar $panelId conforme necessário
    echo "Panel ID: " . $panelId;
} else {
    echo "Usuário não encontrado ou sem panel_id.";
}

$panel_id = $panel_id;
// Feche a conexão com o banco de dados

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Meta -->
  <meta name="description" content="Painel de Adiminstração ProntoPraPedir - Desenvolvido pela ResultarMind.">
  <meta name="author" content="resultarmind">

  <title>ProntoPraPedir - Admin Panel</title>

  <!-- vendor css -->
  <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
  <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link href="../lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
  <link href="../lib/rickshaw/rickshaw.min.css" rel="stylesheet">
  <link href="../lib/chartist/chartist.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


  <!-- Adicione essas linhas no head do seu HTML -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">



  <!-- Bracket CSS -->
  <link rel="stylesheet" href="../css/bracket.css">
</head>

<body>

  <?php include_once 'config/header.php'?>

  <!-- ########## START: MAIN PANEL ########## -->
  <div class="br-mainpanel">
    <div class="pd-30">
      <h4 class="tx-gray-800 mg-b-2">Painel Principal</h4>
      <p class="mg-b-0">ProntoPraPedir.</p>
    </div><!-- d-flex -->


    <div class="br-pagebody">

      <div class="row">
        <div class="col-md-3">
          <div class="card bg-teal">
            <div class="card-body text-center">
              <h6 class="tx-white text-center">ADICIONAR PRODUTO</h6>
              <hr>
              <a href="add_prod.php" class="btn btn-LIGHT pd-x-30 pd-y-15 tx-uppercase tx-bold tx-spacing-6 tx-12">Adicionar
                Produto</a>
            </div>

          </div>
        </div>

        <div class="col-md-3">
          <div class="card bg-info">
            <div class="card-body text-center">
              <h6 class="tx-white text-center">RELATÓRIO DE VENDAS</h6>
              <hr>
              <a href="relatorio.php" class="btn btn-LIGHT pd-x-30 pd-y-15 tx-uppercase tx-bold tx-spacing-6 tx-12">Relatórios</a>
            </div>

          </div>
        </div>


        <div class="col-md-3">
          <div class="card bg-indigo">
            <div class="card-body text-center">
              <h6 class="tx-white text-center">EDITAR INFORMAÇÕES</h6>
              <hr>
              <a href="view_infos.php" class="btn btn-LIGHT pd-x-30 pd-y-15 tx-uppercase tx-bold tx-spacing-6 tx-12">Editar</a>
            </div>

          </div>
        </div>

        <div class="col-md-3">
        <div class="card bg-orange">
          <div class="card-body text-center">
            <h6 class="tx-white text-center">RELATÓRIO DE ITENS VENDIDOS</h6>
            <hr>
            <a href="relatorio_itens.php" class="btn btn-LIGHT pd-x-30 pd-y-15 tx-uppercase tx-bold tx-spacing-6 tx-12">Relatórios</a>
                    </div>

          </div>
        </div>


      </div>

    </div>
<style>
    .card-text-destaque{
        color: black;
    }
</style>
    <div class="br-pagebody">
      <div class="br-section-wrapper">


        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h3 class="text-center">PEDIDOS PENDENTES</h3>
                <hr>

                <?php

include_once "config/conection.php";

 
       

// Substitua $panel_id pela variável real que contém o identificador da loja atual

// Consulta ao banco de dados para obter pedidos pendentes relacionados à loja_id
$sqlPedidosPendentes = "SELECT id, nome_cliente, telefone_cliente, metodo_entrega, endereco_entrega, bairro_entrega, numero_entrega, forma_pagamento, observacoes, data_pedido, troco FROM pedidos WHERE status = 'pendente' OR status IS NULL AND loja_id = ? ORDER BY data_pedido DESC";
$stmtPedidosPendentes = $conn->prepare($sqlPedidosPendentes);
$stmtPedidosPendentes->bind_param("i", $panel_id);
$stmtPedidosPendentes->execute();
$resultadoPedidos = $stmtPedidosPendentes->get_result();

if ($resultadoPedidos->num_rows > 0) {
  while ($pedido = $resultadoPedidos->fetch_assoc()) {
      echo "<div class='card mb-3'>";
      echo "<div class='card-body'>";

      echo "<h5 class='card-title'>Pedido #" . $pedido['id'] . "</h5>";
      echo "<p class='card-text'><strong>Cliente:</strong> " . $pedido['nome_cliente'] . "</p>";
      echo "<p class='card-text'><strong>Telefone:</strong> " . $pedido['telefone_cliente'] . "</p>";
      echo "<p class='card-text'><strong>Método de Entrega:</strong> " . $pedido['metodo_entrega'] . "</p>";

      // Exibe os itens adicionais se o método de entrega for 'Entrega'
      if ($pedido['metodo_entrega'] == 'Entrega') {
          echo "<p class='card-text'><strong>Endereço de Entrega:</strong> " . $pedido['endereco_entrega'] . "</p>";
          echo "<p class='card-text'><strong>Bairro de Entrega:</strong> " . $pedido['bairro_entrega'] . "</p>";
          echo "<p class='card-text'><strong>Número de Entrega:</strong> " . $pedido['numero_entrega'] . "</p>";
      }
      echo "<p class='card-text'><strong>Forma de Pagamento:</strong> " . $pedido['forma_pagamento'] . "</p>";


            echo "<p class='card-text'><strong>Observações da entrega:</strong> " . $pedido['observacoes'] . "</p>";
      echo "<p class='card-text'><strong>Data do Pedido:</strong> " . date('d/m/Y H:i:s', strtotime($pedido['data_pedido'])) . "</p>";

      echo "<hr>";

            // Verifica se a forma de pagamento é "Dinheiro"
            if ($pedido['forma_pagamento'] == "Dinheiro") {
                echo "<p class='card-text-destaque'><strong>Troco para:</strong> " . $pedido['troco'] . "</p>";

                echo "<hr>";

            }


      echo "<div class='row'>";
      echo "<div class='col'>";
      echo "<a href='#' class='btn btn-primary mr-2 w-100' data-toggle='modal' data-target='#confirmarPedidoModal{$pedido['id']}'><i class='fas fa-check-circle'></i> <strong>Confirmar Pedido</strong></a>";
      echo "</div>";
      
      echo "<div class='col'>";
      echo "<button type='button' class='btn btn-info mr-2 w-100' data-toggle='modal' data-target='#itensPedidoModal{$pedido['id']}'><i class='fas fa-eye'></i> <strong>Ver Itens do Pedido</strong></button>";
      echo "</div>";
      echo "</div>";
      
      echo "<div class='row mt-3'>";
      echo "<div class='col'>";
      echo "<a href='#' class='btn btn-danger w-100' onclick='confirmarCancelarPedido({$pedido['id']})'><i class='fas fa-times-circle'></i> <strong>Cancelar Pedido</strong></a>";
      echo "</div>";
      echo "<div class='col'>";
      echo "</div>";
      echo "</div>";
      


      echo "</div>";
      echo "</div>";



       // Modal Tempo de Produção
       echo "<div class='modal fade' id='confirmarPedidoModal{$pedido['id']}' tabindex='-1' role='dialog' aria-labelledby='confirmarPedidoModal{$pedido['id']}' aria-hidden='true'>";
       echo "<div class='modal-dialog' role='document'>";
       echo "<div class='modal-content'>";
       echo "<div class='modal-header'>";
       echo "<h5 class='modal-title' id='confirmarPedidoModal{$pedido['id']}'>Tempo Estimado de Produção</h5>";
       echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
       echo "<span aria-hidden='true'>&times;</span>";
       echo "</button>";
       echo "</div>";
       echo "<div class='modal-body'>";
       
       echo "<form action='confirmar_pedido.php' method='post'>";
       echo "<input type='hidden' name='pedido_id' value='{$pedido['id']}'>";
       
       echo "<div class='form-group'>";
       echo "<label for='prioridade'>Prioridade: </label>";
       echo "<select class='form-control' name='prioridade' id='prioridade' required>";
       echo "<option value='Alta'>Alta</option>";
       echo "<option value='Média'>Média</option>";
       echo "<option value='Baixa'>Baixa</option>";
       echo "</select>";
       echo "</div>";
       
       echo "<div class='form-group'>";
       echo "<label for='tempoProducao'>Tempo de Produção: </label>";
       echo "<select class='form-control' name='tempoProducao' id='tempoProducao' required>";
       echo "<option value='15'>15 minutos</option>";
       echo "<option value='30'>30 minutos</option>";
       echo "<option value='45'>45 minutos</option>";
       echo "<option value='60'>1 hora</option>";
       echo "<option value='90'>1 hora e 30 minutos</option>";
       echo "<option value='120'>2 horas</option>";
       echo "<option value='custom'>Outro (especificar abaixo)</option>";
       echo "</select>";
       echo "</div>";
       
       echo "<div class='form-group' id='customTempo' style='display:none;'>";
       echo "<label for='customTempoInput'>Tempo Personalizado (em minutos): </label>";
       echo "<input type='number' class='form-control' name='customTempoInput' id='customTempoInput'>";
       echo "</div>";
       
       echo "<script>
        document.getElementById('tempoProducao').addEventListener('change', function() {
          var customTempo = document.getElementById('customTempo');
          if (this.value === 'custom') {
            customTempo.style.display = 'block';
          } else {
            customTempo.style.display = 'none';
          }
        });
       </script>";
       
       echo "<div class='form-group'>";
       echo "<label for='tempoEntrega'>Tempo de Entrega: </label>";
       echo "<select class='form-control' name='tempoEntrega' id='tempoEntrega' required>";
       echo "<option value='15'>15 minutos</option>";
       echo "<option value='30'>30 minutos</option>";
       echo "<option value='45'>45 minutos</option>";
       echo "<option value='60'>1 hora</option>";
       echo "<option value='90'>1 hora e 30 minutos</option>";
       echo "<option value='120'>2 horas</option>";
       echo "<option value='custom'>Outro (especificar abaixo)</option>";
       echo "</select>";
       echo "</div>";
       
       echo "<div class='form-group' id='customTempoEntrega' style='display:none;'>";
       echo "<label for='customTempoEntregaInput'>Tempo de Entrega Personalizado (em minutos): </label>";
       echo "<input type='number' class='form-control' name='customTempoEntregaInput' id='customTempoEntregaInput'>";
       echo "</div>";
       
       echo "<script>
        document.getElementById('tempoEntrega').addEventListener('change', function() {
          var customTempoEntrega = document.getElementById('customTempoEntrega');
          if (this.value === 'custom') {
            customTempoEntrega.style.display = 'block';
          } else {
            customTempoEntrega.style.display = 'none';
          }
        });
       </script>";
       
       echo "<div class='modal-footer'>";
       echo "<button type='submit' class='btn btn-primary'>Salvar</button>";
       echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>";
       echo "</div>";
       
       echo "</form>";
       
       
       
       echo "</div>";
       echo "</div>";
      
       echo "</div>";
      
      
       echo "</div>";


         // Modal para exibir itens do pedido
         echo "<div class='modal fade' id='itensPedidoModal{$pedido['id']}' tabindex='-1' role='dialog' aria-labelledby='itensPedidoModalLabel{$pedido['id']}' aria-hidden='true'>";
         echo "<div class='modal-dialog modal-lg' role='document' style='max-width: 80%;'>"; // Ajuste o valor de max-width conforme necessário
         echo "<div class='modal-content'>";
         echo "<div class='modal-header'>";
         echo "<h5 class='modal-title' id='itensPedidoModalLabel{$pedido['id']}'>Itens do Pedido #{$pedido['id']}</h5>";
         echo "<button type='button' class='close' data-dismiss='modal' aria-label='Fechar'>";
         echo "<span aria-hidden='true'>&times;</span>";
         echo "</button>";
         echo "</div>";
         echo "<div class='modal-body'>";
         
         // Consulta ao banco de dados para obter os itens associados a este pedido
         $sqlItensPedido = "SELECT nome_item, quantidade, tamanho, complementos, observacao, preco FROM itens_pedido WHERE pedido_id = ?";
         $stmtItensPedido = $conn->prepare($sqlItensPedido);
         $stmtItensPedido->bind_param("i", $pedido['id']);
         $stmtItensPedido->execute();
         $resultItensPedido = $stmtItensPedido->get_result();
 
         if ($resultItensPedido->num_rows > 0) {
          echo "<ul>";
          $firstItem = true; // Flag para verificar se é o primeiro item
      
          while ($itemPedido = $resultItensPedido->fetch_assoc()) {
                          // Adiciona uma linha horizontal após o primeiro item
                          if (!$firstItem) {
                            echo "<hr>";
                        }

              echo "<li>";
              echo "<p><strong>Pedido:</strong> {$itemPedido['nome_item']}</p>";
              echo "<p><strong>Quantidade:</strong> {$itemPedido['quantidade']}</p>";
              echo "<p><strong>Tamanho:</strong> {$itemPedido['tamanho']}</p>";
              echo "<p><strong>Complementos:</strong> {$itemPedido['complementos']}</p>";
              echo "<p><strong>Observação:</strong> {$itemPedido['observacao']}</p>";
              echo "<p><strong>Preço:</strong> R$ {$itemPedido['preco']}</p>";
              echo "</li>";
      

              
              $firstItem = false; // Marca que não é mais o primeiro item após o primeiro loop
          }
          echo "</ul>";
      } else {
          echo "<p>Nenhum item encontrado para este pedido.</p>";
      }

       
echo "</div>";
echo "<div class='modal-footer'>";
echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";



    }
} else {
    echo "<p>Nenhum pedido pendente.</p>";
}





?>
                





              </div>
            </div>

          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h3 class="text-center">PEDIDOS EM PRODUÇÃO</h3>
                <hr>

                <?php

include_once "config/conection.php";

 
       

// Substitua $panel_id pela variável real que contém o identificador da loja atual

// Consulta ao banco de dados para obter pedidos pendentes relacionados à loja_id
$sqlPedidosPendentes = "SELECT id, nome_cliente, telefone_cliente, metodo_entrega, endereco_entrega, bairro_entrega, numero_entrega, forma_pagamento, observacoes, data_pedido, troco FROM pedidos WHERE status = 'producao' AND loja_id = ? ORDER BY data_pedido DESC";
$stmtPedidosPendentes = $conn->prepare($sqlPedidosPendentes);
$stmtPedidosPendentes->bind_param("i", $panel_id);
$stmtPedidosPendentes->execute();
$resultadoPedidos = $stmtPedidosPendentes->get_result();

if ($resultadoPedidos->num_rows > 0) {
  while ($pedido = $resultadoPedidos->fetch_assoc()) {
      echo "<div class='card mb-3'>";
      echo "<div class='card-body'>";

      echo "<h5 class='card-title'>Pedido #" . $pedido['id'] . "</h5>";
      echo "<p class='card-text'><strong>Cliente:</strong> " . $pedido['nome_cliente'] . "</p>";
      echo "<p class='card-text'><strong>Telefone:</strong> " . $pedido['telefone_cliente'] . "</p>";
      echo "<p class='card-text'><strong>Método de Entrega:</strong> " . $pedido['metodo_entrega'] . "</p>";

            // Exibe os itens adicionais se o método de entrega for 'Entrega'
            if ($pedido['metodo_entrega'] == 'Entrega') {
                echo "<p class='card-text'><strong>Endereço de Entrega:</strong> " . $pedido['endereco_entrega'] . "</p>";
                echo "<p class='card-text'><strong>Bairro de Entrega:</strong> " . $pedido['bairro_entrega'] . "</p>";
                echo "<p class='card-text'><strong>Número de Entrega:</strong> " . $pedido['numero_entrega'] . "</p>";
            }

      echo "<p class='card-text'><strong>Forma de Pagamento:</strong> " . $pedido['forma_pagamento'] . "</p>";
      echo "<p class='card-text'><strong>Observações da entrega:</strong> " . $pedido['observacoes'] . "</p>";
      echo "<p class='card-text'><strong>Data do Pedido:</strong> " . date('d/m/Y H:i:s', strtotime($pedido['data_pedido'])) . "</p>";

    echo "<hr>";

                // Verifica se a forma de pagamento é "Dinheiro"
                if ($pedido['forma_pagamento'] == "Dinheiro") {
                    echo "<p class='card-text-destaque'><strong>Troco para:</strong> " . $pedido['troco'] . "</p>";
    
                    echo "<hr>";
    
                }

                
      echo "<div class='row'>";
      echo "<div class='col'>";
          echo "<a href='marcar_pedido_enviado.php?pedido_id=" . $pedido['id'] . "' class='btn btn-success w-100'><i class='fas fa-truck'></i> <strong>Entregar Pedido</strong></a>";
      echo "</div>";
  
      echo "<div class='col'>";
          echo "<button type='button' class='btn btn-info w-100' data-toggle='modal' data-target='#itensPedidoModal{$pedido['id']}'><i class='fas fa-eye'></i> <strong>Ver Itens do Pedido</strong></button>";
      echo "</div>";
  echo "</div>";
  
  echo "<div class='row mt-3'>";
      echo "<div class='col'>";
          echo "<button class='btn btn-primary enviar-whatsapp w-100' data-pedido-id='" . $pedido['id'] . "'><i class='fab fa-whatsapp'></i> <strong>Enviar resumo via WhatsApp</strong></button>";
      echo "</div>";
  
      echo "<div class='col'>";
          echo "<a href='#' class='btn btn-danger w-100' onclick='confirmarCancelarPedido({$pedido['id']})'><i class='fas fa-times-circle'></i> <strong>Cancelar Pedido</strong></a>";
      echo "</div>";
  echo "</div>";
  
  
  


      echo "</div>";
      echo "</div>";


         // Modal para exibir itens do pedido
         echo "<div class='modal fade' id='itensPedidoModal{$pedido['id']}' tabindex='-1' role='dialog' aria-labelledby='itensPedidoModalLabel{$pedido['id']}' aria-hidden='true'>";
         echo "<div class='modal-dialog' role='document' style='max-width: 80%;'>"; // Ajuste o valor de max-width conforme necessário
         echo "<div class='modal-content'>";
         echo "<div class='modal-header'>";
         echo "<h5 class='modal-title' id='itensPedidoModalLabel{$pedido['id']}'>Itens do Pedido #{$pedido['id']}</h5>";
         echo "<button type='button' class='close' data-dismiss='modal' aria-label='Fechar'>";
         echo "<span aria-hidden='true'>&times;</span>";
         echo "</button>";
         echo "</div>";
         echo "<div class='modal-body'>";
         
         $sqlItensPedido = "SELECT nome_item, quantidade, tamanho, complementos, observacao, preco FROM itens_pedido WHERE pedido_id = ?";
$stmtItensPedido = $conn->prepare($sqlItensPedido);
$stmtItensPedido->bind_param("i", $pedido['id']);
$stmtItensPedido->execute();
$resultItensPedido = $stmtItensPedido->get_result();

if ($resultItensPedido->num_rows > 0) {
    echo "<div class='container'>"; // Container para os cards

    while ($itemPedido = $resultItensPedido->fetch_assoc()) {
        echo "<div class='card mt-3'>";
        echo "<div class='card-body'>";
        echo "<p><strong>Pedido:</strong> {$itemPedido['nome_item']}</p>";
        echo "<p><strong>Quantidade:</strong> {$itemPedido['quantidade']}</p>";
        echo "<p><strong>Tamanho:</strong> {$itemPedido['tamanho']}</p>";
        echo "<p><strong>Complementos:</strong> {$itemPedido['complementos']}</p>";
        echo "<p><strong>Observação:</strong> {$itemPedido['observacao']}</p>";
        echo "<p><strong>Preço:</strong> R$ {$itemPedido['preco']}</p>";
        echo "</div>"; // Fim do card
        echo "</div>"; // Fim do card

    }


    // Calcular o valor total e exibir
    $valorTotalPedido = 0;
    $resultItensPedido->data_seek(0); // Reinicia o ponteiro do resultado para o início

    while ($itemPedido = $resultItensPedido->fetch_assoc()) {
        $valorTotalPedido += $itemPedido['preco'];
    }

    echo "<hr>";
    echo "<div class='card'>"; // Fim do card
    echo "<div class='card-body'>"; // Fim do card
    echo "<h4 class='text-center'><strong>Valor Total do Pedido:</strong> R$ " . number_format($valorTotalPedido, 2, ',', '.') . "</h4>";
    echo "</div>"; // Fim do card

    echo "</div>"; // Fim do card

    echo "</div>"; // Fim do container

    
} else {
    echo "<p>Nenhum item encontrado para este pedido.</p>";
}


       
echo "</div>";
echo "<div class='modal-footer'>";
echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";



    }
} else {
    echo "<p>Nenhum pedido pendente.</p>";
}





?>



                <script>
                  document.addEventListener("DOMContentLoaded", function () {
                    const buttonsEnviarWhatsapp = document.querySelectorAll(".enviar-whatsapp");

                    buttonsEnviarWhatsapp.forEach(function (button) {
                      button.addEventListener("click", function () {
                        const pedidoId = this.getAttribute("data-pedido-id");

                        // Make an AJAX request to fetch order details and customer data
                        const xhr = new XMLHttpRequest();
                        xhr.open("GET", "get_order_details.php?pedido_id=" + pedidoId, true);

                        xhr.onreadystatechange = function () {
                          if (xhr.readyState == 4 && xhr.status == 200) {
                            const orderData = JSON.parse(xhr.responseText);

                            var tempo_envio = orderData.tempo_envio;
                            var tempo_producao = orderData.tempo_producao;

                            var previsao = tempo_envio + tempo_producao;


                            // Construct the WhatsApp message with order details
                            let mensagem = `🌐 PedirAgora.com.br
📃 *PEDIDO:* 
👤 *Cliente:* ${orderData.nome_cliente}
*Previsão de entrega:* ${previsao} minutos
----------------------------------------`;

                            // Include "Status" only if it is not empty or null
                            if (orderData.status) {
                              mensagem += `
*Status:* Pedido em Produção`;
                            }

                            // Include "Telefone" only if it is not empty or null
                            if (orderData.telefone_cliente) {
                              mensagem += `
☎️ *Telefone:* ${orderData.telefone_cliente}`;
                            }

                            // Include "Entrega" only if it is not empty or null
                            if (orderData.metodo_entrega) {
                              mensagem += `
🚚 *Entrega:* ${orderData.metodo_entrega}`;
                            }

                            // Include "Endereço" only if it is not empty or null
                            if (orderData.endereco_entrega) {
                              mensagem += `
📍 *Endereço:* ${orderData.endereco_entrega}`;
                            }

                            // Include "Bairro" only if it is not empty or null
                            if (orderData.bairro_entrega) {
                              mensagem += `
🏡 *Bairro:* ${orderData.bairro_entrega}`;
                            }

                            // Include "Número" only if it is not empty or null
                            if (orderData.numero_entrega) {
                              mensagem += `
🔢 *Número:* ${orderData.numero_entrega}`;
                            }

                            mensagem += ``;
                            // Inicialize a variável para armazenar o valor total
                            let valorTotal = 0;

                            // Iterate over each item in the order and add details to the message
                            orderData.itens.forEach(function (item) {
                              // Include the item details only if nome_item and quantidade are not empty or null
                              if (item.nome_item && item.quantidade) {
                                // Remove HTML tags from the complementos field
                                const complementosWithoutTags = item.complementos.replace(/<[^>]*>/g,
                                  '');

                                // Replace "Adicionais" with a line break
                                const complementosWithLineBreak = complementosWithoutTags.replace(
                                  /Adicionais:/g, '\n');

                                mensagem += `
----------------------------------------
🛍️ *Item:* ${item.nome_item}
📏 *Quantidade:* ${item.quantidade}`;

                                // Include "Complementos" only if it is not empty or null
                                if (complementosWithoutTags.trim()) {
                                  mensagem += `
📝 *Complementos:* ${complementosWithLineBreak}`;
                                }

                                // Include "Tamanho" only if it is not empty or null
                                if (item.tamanho) {
                                  mensagem += `
📏 *Tamanho:* ${item.tamanho}`;
                                }

                                mensagem += `
💰 *Preço:* R$ ${item.preco}`;

                                // Adicione o preço do item ao valor total
                                valorTotal += parseFloat(item.preco);
                              }
                            });

                            // Include "Pagamento" only if it is not empty or null
                            if (orderData.forma_pagamento) {
                              mensagem += `
----------------------------------------
💵 *Pagamento:* ${orderData.forma_pagamento}`;
                            }

                            // Include "Valor Total" at the end of the message
                            mensagem += `
----------------------------------------
*Valor Total:* R$ ${valorTotal.toFixed(2)}
----------------------------------------
Obrigado pelo pedido!
Informaremos quando o pedido estiver pronto/sair para entrega.`;



                            // Phone number of the seller (replace with the actual phone number)
                            const numeroVendedor = orderData.telefone_cliente.startsWith('+55') ?
                              orderData.telefone_cliente : '+55' + orderData.telefone_cliente;

                            // Create the WhatsApp URL
                            const whatsappURL =
                              `https://api.whatsapp.com/send?phone=${numeroVendedor}&text=${encodeURIComponent(mensagem)}`;

                            // Open WhatsApp in a new window or tab
                            window.open(whatsappURL, "_blank");
                          }
                        };

                        xhr.send();
                      });
                    });
                  });
                </script>





              </div>
            </div>

          </div>


          <div class="col-md-6 mt-4">
            <div class="card">
              <div class="card-body">
                <h3 class="text-center">PEDIDOS ENVIADOS</h3>
                <hr>

                <?php
include_once "config/conection.php";

// Consulta ao banco de dados para obter pedidos enviados
$sqlPedidosEnviados = "SELECT id, nome_cliente, telefone_cliente, metodo_entrega, endereco_entrega, bairro_entrega, numero_entrega, forma_pagamento, observacoes, data_pedido FROM pedidos WHERE status = 'enviado' AND loja_id = ? ORDER BY data_pedido DESC";
$stmtPedidosEnviados = $conn->prepare($sqlPedidosEnviados);
$stmtPedidosEnviados->bind_param("i", $panel_id);
$stmtPedidosEnviados->execute();
$resultadoPedidosEnviados = $stmtPedidosEnviados->get_result();

if ($resultadoPedidosEnviados->num_rows > 0) {
    while ($pedidoEnviado = $resultadoPedidosEnviados->fetch_assoc()) {
        echo "<div class='card mb-3'>";
        echo "<div class='card-body'>";


        echo "<h5 class='card-title'>Pedido #" . $pedidoEnviado['id'] . "</h5>";
        echo "<p class='card-text'><strong>Cliente:</strong> " . $pedidoEnviado['nome_cliente'] . "</p>";
        echo "<p class='card-text'><strong>Telefone:</strong> " . $pedidoEnviado['telefone_cliente'] . "</p>";
        echo "<p class='card-text'><strong>Método de Entrega:</strong> " . $pedidoEnviado['metodo_entrega'] . "</p>";

              // Exibe os itens adicionais se o método de entrega for 'Entrega'
      if ($pedidoEnviado['metodo_entrega'] == 'Entrega') {
        echo "<p class='card-text'><strong>Endereço de Entrega:</strong> " . $pedidoEnviado['endereco_entrega'] . "</p>";
        echo "<p class='card-text'><strong>Bairro de Entrega:</strong> " . $pedidoEnviado['bairro_entrega'] . "</p>";
        echo "<p class='card-text'><strong>Número de Entrega:</strong> " . $pedidoEnviado['numero_entrega'] . "</p>";
    }

        echo "<p class='card-text'><strong>Forma de Pagamento:</strong> " . $pedidoEnviado['forma_pagamento'] . "</p>";
        echo "<p class='card-text'><strong>Observações da entrega:</strong> " . $pedidoEnviado['observacoes'] . "</p>";
        echo "<p class='card-text'><strong>Data do Pedido:</strong> " . date('d/m/Y H:i:s', strtotime($pedidoEnviado['data_pedido'])) . "</p>";

        // Adicione aqui qualquer outra informação que deseja exibir

        // Botão "Entrega Concluída"
        echo "<hr>";

        echo "<div class='row'>";
        echo "<div class='col'>";
        echo "<a href='marcar_entrega_concluida.php?pedido_id=" . $pedidoEnviado['id'] . "' class='btn btn-success mr-2 w-100'><i class='fas fa-check-circle'></i> <strong>Entrega Concluída</strong></a>";
        echo "</div>";
        
        echo "<div class='col'>";
        echo "<button class='btn btn-primary enviar-whatsapp-enviado mr-2 w-100' data-pedido-id='" . $pedidoEnviado['id'] . "'><i class='fab fa-whatsapp'></i> <strong>Enviar resumo via WhatsApp</strong></button>";
        echo "</div>";
        echo "</div>";
        

        echo "</div>";
        echo "</div>";
    }

} else {
    echo "<p>Nenhum pedido enviado.</p>";
}

$stmtPedidosEnviados->close();
?>

                <script>
                  document.addEventListener("DOMContentLoaded", function () {
                    const buttonsEnviarWhatsapp = document.querySelectorAll(".enviar-whatsapp-enviado");

                    buttonsEnviarWhatsapp.forEach(function (button) {
                      button.addEventListener("click", function () {
                        const pedidoId = this.getAttribute("data-pedido-id");

                        // Make an AJAX request to fetch order details and customer data
                        const xhr = new XMLHttpRequest();
                        xhr.open("GET", "get_order_details.php?pedido_id=" + pedidoId, true);

                        xhr.onreadystatechange = function () {
                          if (xhr.readyState == 4 && xhr.status == 200) {
                            const orderData = JSON.parse(xhr.responseText);

                            var tempo_envio = orderData.tempo_envio;
                            var tempo_producao = orderData.tempo_producao;

                            var previsao = tempo_envio + tempo_producao;


                            // Construct the WhatsApp message with order details
                            let mensagem = `🌐 PedirAgora.com.br
👤 *Cliente:* ${orderData.nome_cliente}`;


                            mensagem += ``;
                            // Inicialize a variável para armazenar o valor total
                            let valorTotal = 0;

                            // Iterate over each item in the order and add details to the message
                            orderData.itens.forEach(function (item) {
                              // Include the item details only if nome_item and quantidade are not empty or null
                              if (item.nome_item && item.quantidade) {
                                // Remove HTML tags from the complementos field
                                const complementosWithoutTags = item.complementos.replace(/<[^>]*>/g,
                                  '');

                                // Replace "Adicionais" with a line break
                                const complementosWithLineBreak = complementosWithoutTags.replace(
                                  /Adicionais:/g, '\n');


                                // Adicione o preço do item ao valor total
                                valorTotal += parseFloat(item.preco);
                              }
                            });

                            // Include "Pagamento" only if it is not empty or null
                            if (orderData.forma_pagamento) {
                              mensagem += `
💵 *Pagamento:* ${orderData.forma_pagamento}`;
                            }

                            // Include "Status" only if it is not empty or null
                            mensagem += `
----------------------------------------
🚚 *Status:* Pedido Enviado`;

                            // Include "Valor Total" at the end of the message
                            mensagem += `
----------------------------------------
*Valor Total:* R$ ${valorTotal.toFixed(2)}
----------------------------------------
Agradecemos por sua escolha! Seu pedido está a caminho e será entregue em breve. `;



                            // Phone number of the seller (replace with the actual phone number)
                            const numeroVendedor = orderData.telefone_cliente.startsWith('+55') ?
                              orderData.telefone_cliente : '+55' + orderData.telefone_cliente;

                            // Create the WhatsApp URL
                            const whatsappURL =
                              `https://api.whatsapp.com/send?phone=${numeroVendedor}&text=${encodeURIComponent(mensagem)}`;

                            // Open WhatsApp in a new window or tab
                            window.open(whatsappURL, "_blank");
                          }
                        };

                        xhr.send();
                      });
                    });
                  });
                </script>



              </div>
            </div>

          </div>

          <div class="col-md-6 mt-4">
            <div class="card">
              <div class="card-body">
                <h3 class="text-center">PEDIDOS CONCLUÍDOS DO DIA</h3>
                <hr>

                <?php
include_once "config/conection.php";

// Obtém a data atual no formato Y-m-d (ano-mês-dia)
$dataAtual = date('Y-m-d');

// Consulta ao banco de dados para obter pedidos finalizados do dia atual
$sqlPedidosFinalizados = "SELECT id, nome_cliente, telefone_cliente, metodo_entrega, endereco_entrega, bairro_entrega, numero_entrega, forma_pagamento, observacoes, data_pedido FROM pedidos WHERE status = 'finalizado' AND DATE(data_pedido) = ? ORDER BY data_pedido DESC";
$stmtPedidosFinalizados = $conn->prepare($sqlPedidosFinalizados);
$stmtPedidosFinalizados->bind_param("s", $dataAtual);
$stmtPedidosFinalizados->execute();
$resultadoPedidosFinalizados = $stmtPedidosFinalizados->get_result();

if ($resultadoPedidosFinalizados->num_rows > 0) {
    while ($pedidoFinalizado = $resultadoPedidosFinalizados->fetch_assoc()) {
        echo "<div class='card mb-3'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Pedido #" . $pedidoFinalizado['id'] . "</h5>";
        echo "<p class='card-text'><strong>Cliente:</strong> " . $pedidoFinalizado['nome_cliente'] . "</p>";
        echo "<p class='card-text'><strong>Telefone:</strong> " . $pedidoFinalizado['telefone_cliente'] . "</p>";
        echo "<p class='card-text'><strong>Método de Entrega:</strong> " . $pedidoFinalizado['metodo_entrega'] . "</p>";

              // Exibe os itens adicionais se o método de entrega for 'Entrega'
      if ($pedidoFinalizado['metodo_entrega'] == 'Entrega') {
        echo "<p class='card-text'><strong>Endereço de Entrega:</strong> " . $pedidoFinalizado['endereco_entrega'] . "</p>";
        echo "<p class='card-text'><strong>Bairro de Entrega:</strong> " . $pedidoFinalizado['bairro_entrega'] . "</p>";
        echo "<p class='card-text'><strong>Número de Entrega:</strong> " . $pedidoFinalizado['numero_entrega'] . "</p>";
    }


        echo "<p class='card-text'><strong>Forma de Pagamento:</strong> " . $pedidoFinalizado['forma_pagamento'] . "</p>";
        echo "<p class='card-text'><strong>Observações:</strong> " . $pedidoFinalizado['observacoes'] . "</p>";
        echo "<p class='card-text'><strong>Data do Pedido:</strong> " . date('d/m/Y H:i:s', strtotime($pedidoFinalizado['data_pedido'])) . "</p>";

        // Consulta ao banco de dados para obter os itens associados a este pedido
        $sqlItensPedido = "SELECT nome_item, quantidade, tamanho, complementos, observacao, preco FROM itens_pedido WHERE pedido_id = ?";
        $stmtItensPedido = $conn->prepare($sqlItensPedido);
        $stmtItensPedido->bind_param("i", $pedidoFinalizado['id']);
        $stmtItensPedido->execute();
        $resultItensPedido = $stmtItensPedido->get_result();

        if ($resultItensPedido->num_rows > 0) {
            echo "<hr>";
            echo "<ul>";
            $valorTotalPedido = 0;

            while ($itemPedido = $resultItensPedido->fetch_assoc()) {
                // Adiciona o preço do item ao valor total do pedido
                $valorTotalPedido += $itemPedido['preco'];
            }
            echo "</ul>";

            // Exibe o valor total do pedido
            echo "<p><strong>Valor Total do Pedido:</strong> R$ " . number_format($valorTotalPedido, 2, ',', '.') . "</p>";
        } else {
            echo "<p class='card-text'>Nenhum item associado a este pedido.</p>";
        }

        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>Nenhum pedido finalizado hoje.</p>";
}

$stmtPedidosFinalizados->close();

        ?>


              </div>
            </div>

          </div>

        </div>



      </div>
    </div>

    <?php include_once 'config/footer.php'?>

  </div><!-- br-mainpanel -->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


  <script>
function confirmarCancelarPedido(pedidoId) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, cancele!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Faz a requisição AJAX para cancelar o pedido
            fetch('cancelar_pedido.php', {
                method: 'POST',
                body: JSON.stringify({ pedidoId: pedidoId }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        'Cancelado!',
                        'O pedido foi cancelado.',
                        'success'
                    ).then(() => {
                        // Atualizar a página após o fechamento do SweetAlert
                        window.location.reload();
                    });
                } else {
                    // Você pode adicionar aqui o tratamento de erros retornados pelo servidor
                }
            })
            .catch(error => {
                console.error('Erro ao cancelar pedido:', error);
            });
        }
    });
}
</script>



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
    $(function () {
      'use strict'

      // FOR DEMO ONLY
      // menu collapsed by default during first page load or refresh with screen
      // having a size between 992px and 1299px. This is intended on this page only
      // for better viewing of widgets demo.
      $(window).resize(function () {
        minimizeMenu();
      });

      minimizeMenu();

      function minimizeMenu() {
        if (window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
          // show only the icons and hide left menu label by default
          $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
          $('body').addClass('collapsed-menu');
          $('.show-sub + .br-menu-sub').slideUp();
        } else if (window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
          $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
          $('body').removeClass('collapsed-menu');
          $('.show-sub + .br-menu-sub').slideDown();
        }
      }
    });
  </script>
</body>

</html>