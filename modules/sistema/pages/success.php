<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido realizado com sucesso!</title>
    <!-- Adicione os links para os arquivos CSS e JS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../style/style.css">
    <!-- Adicione o link para o arquivo JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/<i class='fa-solid fa-circle-check conf'></i>-icon" href="https://resultarmind.cloud/resultarmind/Acesa.ico">




</head>

<body>




    <?php include_once "../includes/header.php"; ?>


    <div class="divider-title"></div>

    </div>



    <div class="container">


            <h4 class="text-center mb-5">Acompanhe seu Pedido <i class="fa-solid fa-basket-shopping"></i></h4>

            <div class="divider-title"></div>


            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                    </div>

                    <style>
    /* Estilos para dispositivos móveis */
    @media only screen and (max-width: 767px) {
        .edit-mobile {
            text-align: center !important; /* Altera o alinhamento para o centro em dispositivos móveis */
        }
    }

    /* Estilos para dispositivos desktop */
    @media only screen and (min-width: 768px) {
        .edit-mobile{
            text-align: right !important; /* Mantém o alinhamento à direita em dispositivos desktop */
        }
    }
</style>

<div class="col-md-6 edit-mobile">
    <?php
    // Verifique se o ID do pedido está presente na URL
    if (isset($_GET['pedido_id'])) {
        $pedidoId = $_GET['pedido_id'];

        // Consulte o banco de dados para obter o tempo de produção
        include_once "../includes/connection.php"; // Certifique-se de incluir seu arquivo de conexão

        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        $sqlProducao = "SELECT tempo_producao FROM pedidos WHERE id = ?";
        $stmtProducao = $conn->prepare($sqlProducao);
        $stmtProducao->bind_param("i", $pedidoId);
        $stmtProducao->execute();
        $stmtProducao->bind_result($tempoProducao);

        if ($stmtProducao->fetch()) {
            if ($tempoProducao !== null && $tempoProducao !== "") {
                echo "<p><strong>TEMPO ESTIMADO DE PRODUÇÃO:</strong> {$tempoProducao} minutos</p>";
            } else {
                echo "<p>Aguarde a confirmação do pedido para obter o tempo estimado de produção.</p>";
            }
        } else {
            echo "Aguarde o pedido ser confirmado.";
        }

        $stmtProducao->close();
    } else {
        // Se o ID do pedido não estiver presente, redirecione para alguma página de erro ou tratamento adequada
        header("Location: erro.php");
        exit;
    }
    ?>
</div>


                </div>



                <style>
                    .progress {
                        width: 100%;
                        background-color: #ddd;
                    }

                    .progress-bar {
                        width: 0%;
                        height: 20px;
                        background-color: blue;
                        text-align: center;
                        line-height: 30px;
                        color: white;
                    }
                </style>
                <!-- Barra de Progresso -->
                <div class="progress">
                    <div class="progress-bar" id="progressBar">
                        0:00
                    </div>
                </div>






                <div class="mt-3 edit-mobile">

                    <script>
                        // Obtém a data e hora atual do navegador
                        var dataHoraAtual = new Date();

                        // Obtém os componentes da data
                        var dia = dataHoraAtual.getDate();
                        var mes = dataHoraAtual.getMonth() + 1; // Os meses são baseados em zero (janeiro é 0), então adicionamos 1
                        var ano = dataHoraAtual.getFullYear();

                        // Obtém os componentes do horário
                        var hora = dataHoraAtual.getHours();
                        var minuto = dataHoraAtual.getMinutes();
                        var segundo = dataHoraAtual.getSeconds();

                        // Formata os componentes da data e hora para exibição (adicionando zeros à esquerda, se necessário)
                        var dataFormatada = (dia < 10 ? '0' : '') + dia + '/' + (mes < 10 ? '0' : '') + mes + '/' + ano;
                        var horarioFormatado = (hora < 10 ? '0' : '') + hora + ':' + (minuto < 10 ? '0' : '') + minuto + ':' + (segundo < 10 ? '0' : '') + segundo;

                    </script>

                    <?php
                    if (isset($_GET['pedido_id'])) {
                        $pedidoId = $_GET['pedido_id'];
                        include_once "../includes/connection.php";
                        if ($conn->connect_error) {
                            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
                        }

                        $sql = "SELECT tempo_envio, data_pedido, tempo_producao FROM pedidos WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $pedidoId);
                        $stmt->execute();
                        $stmt->bind_result($tempoEnvio, $dataPedido, $tempoProducao);
                        $encontrado = $stmt->fetch();
                        $stmt->close();

                        if ($encontrado) {
                            // Calcula a diferença entre o tempo atual e o tempo do pedido
                            $agora = time();
                            $dataPedidoTimestamp = strtotime(str_replace('-', '/', $dataPedido));
                            $diferenca = floor(($agora + $dataPedidoTimestamp) / 60); // Diferença em minutos

                            // Calcula o tempo total considerando tempo de envio e produção
                            $tempoTotal = $tempoProducao + $tempoEnvio;

                            echo "<script>
            const tempoTotal = {$tempoTotal};
            let diferencaTempo = {$diferenca};
        </script>";

                            echo "<p><strong>TEMPO ESTIMADO DE ENVIO:</strong> {$tempoEnvio} minutos</p>";

                        } else {
                            echo "<p>Pedido não encontrado.</p>";
                            exit; // Se o pedido não for encontrado, encerre o script
                        }
                    } else {
                        header("Location: erro.php");
                        exit;
                    }
                    ?>






<style>
    #progressBar {
        background-color: #3498db; /* Cor inicial da barra */
        transition: width 1s linear; /* Transição suave ao alterar a largura */
    }
</style>

<script>
    const progressBar = document.getElementById('progressBar');
    const dataPedido = new Date("<?php echo date('Y-m-d H:i:s', strtotime($dataPedido)); ?>");
        // Defina o tempo total desejado em segundos
    const tempoTotalSegundos = 30 * 60; // Exemplo de tempo total em segundos (30 minutos * 60 segundos)

    const atualizarBarra = () => {
        const agora = new Date(); // Obtém a data e hora atuais

        // Calcula a diferença de tempo em segundos entre a data atual e o momento do pedido
        const diferencaTempo = Math.floor((agora - dataPedido) / 1000);

        if (tempoTotalSegundos > 0) {
            if (diferencaTempo >= tempoTotalSegundos) {
                progressBar.style.width = '100%';
                progressBar.innerHTML = '<strong>Completo!</strong>';
            } else {
                let width = (diferencaTempo / tempoTotalSegundos) * 100; // Calcula a porcentagem de progresso
                progressBar.style.width = width + '%';

                let segundosPassados = diferencaTempo;
                let horas = Math.floor(segundosPassados / 3600); // Calcula as horas decorridas
                let minutos = Math.floor((segundosPassados % 3600) / 60); // Calcula os minutos decorridos
                let segundos = segundosPassados % 60; // Calcula os segundos decorridos
                progressBar.innerHTML = '<strong>' + horas + ':' + (minutos < 10 ? '0' : '') + minutos + ':' + (segundos < 10 ? '0' : '') + segundos + '</strong>';
                
                // Define a cor da barra de acordo com o progresso
                if (width <= 50) {
                    progressBar.style.backgroundColor = '#3498db'; // Azul
                } else {
                    progressBar.style.backgroundColor = '#0c7934'; // Verde
                }
            }
        } else {
            progressBar.style.width = '0%';
            progressBar.textContent = 'Aguardando tempo de envio e produção';
        }
    };

    setInterval(atualizarBarra, 1000);
    atualizarBarra();
</script>






                </div>


                <div class="mt-2 edit-mobile">
                    <?php
                    // Verifique se o ID do pedido está presente na URL
                    if (isset($_GET['pedido_id'])) {
                        $pedidoId = $_GET['pedido_id'];

                        // Consulte o banco de dados para obter o tempo de produção e tempo de entrega
                        include_once "../includes/connection.php"; // Certifique-se de incluir seu arquivo de conexão

                        if ($conn->connect_error) {
                            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
                        }

                        $sqlTempos = "SELECT tempo_producao, tempo_envio FROM pedidos WHERE id = ?";
                        $stmtTempos = $conn->prepare($sqlTempos);
                        $stmtTempos->bind_param("i", $pedidoId);
                        $stmtTempos->execute();
                        $stmtTempos->bind_result($tempoProducao, $tempoEntrega);

                        if ($stmtTempos->fetch()) {
                            // Calcula as horas e minutos separadamente
                            $tempoTotalMinutos = $tempoProducao + $tempoEntrega;
                            $tempoTotalHoras = floor($tempoTotalMinutos / 60);
                            $tempoTotalMinutosRestantes = $tempoTotalMinutos % 60;

                            echo "<p><strong>TEMPO TOTAL:</strong> ";

                            if ($tempoTotalHoras > 0) {
                                echo "{$tempoTotalHoras} ";

                                if ($tempoTotalHoras === 1) {
                                    echo "hora";
                                } else {
                                    echo "horas";
                                }

                                if ($tempoTotalMinutosRestantes > 0) {
                                    echo " e {$tempoTotalMinutosRestantes} minutos";
                                }
                            } elseif ($tempoTotalMinutosRestantes > 0) {
                                // Se o tempo total de horas for zero, exiba apenas os minutos
                                echo "{$tempoTotalMinutosRestantes} minutos";
                            } else {
                                // Se o tempo total de horas e minutos for zero, você pode adicionar uma mensagem apropriada aqui.
                                echo "Tempo total indefinido";
                            }

                            echo "</p>";
                        } else {
                            echo "Aguarde o pedido ser confirmado.";
                        }

                        $stmtTempos->close();
                    } else {
                        // Se o ID do pedido não estiver presente, redirecione para alguma página de erro ou tratamento adequada
                        header("Location: erro.php");
                        exit;
                    }
                    ?>



                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


            <?php
            // Verifique se o ID do pedido está presente na URL
            if (isset($_GET['pedido_id'])) {
                $pedidoId = $_GET['pedido_id'];

                // Consulte o banco de dados para obter informações do pedido, incluindo o status
                include_once "../includes/connection.php";

                $sqlStatus = "SELECT status FROM pedidos WHERE id = ?";
                $stmtStatus = $conn->prepare($sqlStatus);
                $stmtStatus->bind_param("i", $pedidoId);
                $stmtStatus->execute();
                $stmtStatus->bind_result($status);
                $stmtStatus->fetch();
                $stmtStatus->close();

                // Determinar o texto com base no status
                $textoPedidoRecebido = "";

                switch ($status) {
                    case "producao":
                        $textoPedidoRecebido = "Pedido em Produção";
                        break;
                    case "enviado":
                        $textoPedidoRecebido = "Pedido Enviado";
                        break;
                    case "finalizado":
                        $textoPedidoRecebido = "Pedido Finalizado";
                        break;
                    default:
                        $textoPedidoRecebido = "Pedido Recebido";
                        break;
                }

                // Exibir o texto com base no status
                echo "<p class='text-center mt-3 product blinking'><strong>{$textoPedidoRecebido}</strong></p>";

                // Restante do seu código...
            } else {
                // Se o ID do pedido não estiver presente, redirecione para alguma página de erro ou tratamento adequada
                header("Location: erro.php");
                exit;
            }
            ?>

            <div class="row text-center mt-4 p-5">
                <div class="col-md-3">
                    <i class="fa-solid fa-clipboard icon-confirm"></i>
                    <p class="text-confirmed"><strong>Pedido Recebido</strong></p>
                </div>

                <?php
                // Verifique se o ID do pedido está presente na URL
                if (isset($_GET['pedido_id'])) {
                    $pedidoId = $_GET['pedido_id'];

                    // Consulte o banco de dados para obter informações do pedido, incluindo o status
                    include_once "../includes/connection.php";

                    $sqlStatus = "SELECT status FROM pedidos WHERE id = ?";
                    $stmtStatus = $conn->prepare($sqlStatus);
                    $stmtStatus->bind_param("i", $pedidoId);
                    $stmtStatus->execute();
                    $stmtStatus->bind_result($status);
                    $stmtStatus->fetch();
                    $stmtStatus->close();

                    // Determinar a classe e o ícone com base no status
                    $iconClass = "fa-solid fa-spinner icon-falt";
                    $paragraphClass = "";

                    if ($status === "producao") {
                        $iconClass .= " fa-spin icon-confirm"; // Adicionando a classe fa-spin apenas quando o status é "producao"
                        $paragraphClass = "text-confirmed";
                    } elseif ($status === "enviado" || $status === "finalizado") {
                        $iconClass = "fa-solid fa-check icon-confirm";
                        $paragraphClass = "text-confirmed";
                    }

                    // Exibir o ícone e o parágrafo com as classes determinadas
                    echo "<div class='col-md-3'>";
                    echo "<i class='$iconClass'></i>";
                    echo "<p class='$paragraphClass'><strong>Pedido em Produção</strong></p>";
                    echo "</div>";

                    // Restante do seu código...
                } else {
                    // Se o ID do pedido não estiver presente, redirecione para alguma página de erro ou tratamento adequada
                    header("Location: erro.php");
                    exit;
                }
                ?>


                <?php
                // Verifique se o ID do pedido está presente na URL
                if (isset($_GET['pedido_id'])) {
                    $pedidoId = $_GET['pedido_id'];

                    // Consulte o banco de dados para obter informações do pedido, incluindo o status
                    include_once "../includes/connection.php";

                    $sqlStatus = "SELECT status FROM pedidos WHERE id = ?";
                    $stmtStatus = $conn->prepare($sqlStatus);
                    $stmtStatus->bind_param("i", $pedidoId);
                    $stmtStatus->execute();
                    $stmtStatus->bind_result($status);
                    $stmtStatus->fetch();
                    $stmtStatus->close();

                    // Determinar a classe e o ícone com base no status
                    $iconClass = "fa-solid fa-circle-check  icon-falt";
                    $paragraphClass = "";

                    if ($status === "enviado" || $status === "finalizado") {
                        $iconClass = "fa-solid fa-circle-check  icon-confirm";
                        $paragraphClass = "text-confirmed";
                    }

                    // Exibir o ícone e o parágrafo com as classes determinadas
                    echo "<div class='col-md-3'>";
                    echo "<i class='fa-solid $iconClass'></i>";
                    echo "<p class='$paragraphClass'><strong>Pedido Pronto</strong></p>";
                    echo "</div>";

                    // Restante do seu código...
                } else {
                    // Se o ID do pedido não estiver presente, redirecione para alguma página de erro ou tratamento adequada
                    header("Location: erro.php");
                    exit;
                }
                ?>


                <?php
                // Verifique se o ID do pedido está presente na URL
                if (isset($_GET['pedido_id'])) {
                    $pedidoId = $_GET['pedido_id'];

                    // Consulte o banco de dados para obter informações do pedido, incluindo o status
                    include_once "../includes/connection.php";

                    $sqlStatus = "SELECT status FROM pedidos WHERE id = ?";
                    $stmtStatus = $conn->prepare($sqlStatus);
                    $stmtStatus->bind_param("i", $pedidoId);
                    $stmtStatus->execute();
                    $stmtStatus->bind_result($status);
                    $stmtStatus->fetch();
                    $stmtStatus->close();

                    // Determinar a classe e o ícone com base no status
                    $iconClass = "fa-solid fa-paper-plane icon-falt";
                    $paragraphClass = "";

                    if ($status === "enviado" || $status === "finalizado") {
                        $iconClass = "fa-solid fa-paper-plane icon-confirm";
                        $paragraphClass = "text-confirmed";
                    }

                    // Exibir o ícone e o parágrafo com as classes determinadas
                    echo "<div class='col-md-3'>";
                    echo "<i class='fa-solid $iconClass'></i>";
                    echo "<p class='$paragraphClass'><strong>Pedido Enviado</strong></p>";
                    echo "</div>";

                    // Restante do seu código...
                } else {
                    // Se o ID do pedido não estiver presente, redirecione para alguma página de erro ou tratamento adequada
                    header("Location: erro.php");
                    exit;
                }
                ?>

            </div>

            <div class="pedido">
                        <div class="card mt-3 mb-3 not-hover">
                            <div class="card-body">
                                <h3 class="text-center title-cat2">RESUMO DO PEDIDO</h3>
                                <div class="divider-title"></div>

                                <div class="row">

                                <?php

include_once "config/conection.php";

 
       

// Substitua $panel_id pela variável real que contém o identificador da loja atual

// Verifica se o parâmetro pedido_id está presente na URL
if (isset($_GET['pedido_id'])) {
    // Obtém o pedido_id da URL
    $pedido_id = $_GET['pedido_id'];

    // Consulta ao banco de dados para obter pedidos pendentes relacionados à loja_id
    $sqlPedidosPendentes = "SELECT id, nome_cliente, telefone_cliente, metodo_entrega, endereco_entrega, bairro_entrega, numero_entrega, forma_pagamento, observacoes, data_pedido FROM pedidos WHERE loja_id = ? AND id = ? ORDER BY data_pedido DESC";

    $stmtPedidosPendentes = $conn->prepare($sqlPedidosPendentes);
    $stmtPedidosPendentes->bind_param("ii", $panel_id, $pedido_id); // Se o ID do pedido for um inteiro, use "i" para bind_param
    $stmtPedidosPendentes->execute();
    $resultadoPedidos = $stmtPedidosPendentes->get_result();

    // Restante do código para processar os resultados...
} else {
    // Lógica para lidar com a ausência do parâmetro pedido_id na URL
    echo "ID do pedido não fornecido na URL";
}


if ($resultadoPedidos->num_rows > 0) {
  while ($pedido = $resultadoPedidos->fetch_assoc()) {


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

    echo "<div class='col text-center'>";
    echo "<button type='button' class='btn btn-info mr-2' style='width: 100%; margin-left: auto; margin-right: auto;' data-toggle='modal' data-target='#itensPedidoModal{$pedido['id']}'><i class='fas fa-eye'></i> <strong>Ver Itens do Pedido</strong></button>";
    echo "</div>";
    

    echo "<div class='row mt-3'>";

      echo "<div class='col'>";
      echo "</div>";
      echo "</div>";
      




        echo "<div class='modal fade' id='itensPedidoModal{$pedido['id']}' tabindex='-1' role='dialog' aria-labelledby='itensPedidoModalLabel{$pedido['id']}' aria-hidden='true'>";

        echo "<div class='modal-dialog' role='document'>";
echo "<div class='modal-content'>";
echo "<div class='modal-header'>";
echo "<h5 class='modal-title' id='itensPedidoModalLabel{$pedido['id']}'>Itens do Pedido #{$pedido['id']}</h5>";
echo "<a type='button' class='close' data-dismiss='modal' aria-label='Fechar'>";
echo "<span aria-hidden='true'><i class='fas fa-times'></i></span>";
echo "</a>";
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

                                <div class="divider-title"></div>


                                <div class="col ms-auto">
                                    <div class="valor-final">
                                        <p><strong>VALOR FINAL: <span id="valorFinalSpan"><?php echo  "R$ " . number_format($valorTotalPedido, 2, ',', '.') . "" ?></span> <i class="fa-solid fa-comment-dollar"></i></strong></p>
                                    </div>
                                </div>

                            </div>
                        </div>




                </div>


 




        <style>
            @media (max-width: 767px) {
                .col-md-12.text-end {
                    text-align: center;
                    /* Altere para a propriedade de alinhamento desejada */
                }
            }
        </style>

        <div class="col-md-12 text-end mt-5 mb-5 edit-mobile">
            <a href="../index.php" class="btn btn-secondary new">
                <i class="fa-solid fa-square-plus"></i> Fazer Novo Pedido
            </a>
        </div>



    </div>



    </div>




    <?php include_once "../includes/footer.php";  ?>









    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>