<?php

include_once "includes/connection.php";
?>

<?php
        include_once "../includes/connection.php";

        $query = "SELECT nome FROM infos WHERE id = $loja_id";

        $result = $conn->query($query);

        if ($result === false) {
            echo "Erro na consulta: " . $conn->error;
        } else {
            $row = $result->fetch_assoc();

            $nome_loja = $row['nome'];

        }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nome_loja ?> - ProntoPraPedir</title>
    <!-- Bootstrap CSS (última versão) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Seu CSS personalizado -->
    <link rel="stylesheet" href="style/style.css">

    <!-- jQuery (última versão) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery Mask Plugin (última versão) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Font Awesome (última versão) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap Bundle JS (inclui Popper) (última versão) -->

    <!-- Favicon (ajuste o caminho conforme necessário) -->
    <link rel="icon" type="image/x-icon" href="https://resultarmind.cloud/resultarmind/Acesa.ico">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>



    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</head>


<body>

    <?php include_once "includes/header.php";  ?>


    <div class="divider-title"></div>

    <div class="container">


        <div class="row">
            <!-- Formulário de busca 
  <div class="col-md-7">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Buscar no cardápio.." name="pesquisa" aria-label="Pesquisar" aria-describedby="button-addon2" value="<?php echo htmlspecialchars($pesquisa); ?>">
      <button class="btn btn-search" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
        </div>
-->






        </div>













        <!--INICIO DO CARD DE 1 FILEIRA-->


        <?php

        $pesquisa = '';
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pesquisa'])) {
            $pesquisa = trim($_GET['pesquisa']);
            // Sanitize e valide a $pesquisa aqui
        }

        // Consulta SQL para obter dados das categorias específicas para a loja_id
        $sql_categorias = "SELECT * FROM categorias WHERE panel_id = $loja_id";
        $result_categorias = $conn->query($sql_categorias);


        // Verifica se há dados
        if ($result_categorias->num_rows > 0) {
            // Abre a div da row uma vez antes do loop
            echo '<div class="row">';

            // Variável para contar o número de colunas na linha
            $numColunasNaLinha = 0;

            // Itera sobre os resultados das categorias
            while ($row_categoria = $result_categorias->fetch_assoc()) {
                $nomeCategoria = $row_categoria['nome_categoria'];
                $tamanhoCategoria = $row_categoria['tamanho_coluna'];

                // Determina a classe do Bootstrap com base no tamanho
                if ($tamanhoCategoria == 1) {
                    $colClass = 'col-md-4';
                    $colCl = 'col-md-12';
                } elseif ($tamanhoCategoria == 2) {
                    $colClass = 'col-md-8'; // Alterado para md-6 para ocupar metade da largura
                    $colCl = 'col-md-6';
                } elseif ($tamanhoCategoria == 3) {
                    $colClass = 'col-md-12';
                    $colCl = 'col-md-6';
                } else {
                    // Tamanho padrão caso não corresponda a nenhum dos valores especificados
                    $colClass = 'col-md-4';
                }

                // Exibe o card dinamicamente
                echo '<div class="' . $colClass . '">';
                echo '<div class="card mt-5 not-hover cat-new">';
                echo '<div class="card-body">';
                echo '<h4 class="text-center title-cat">' . $nomeCategoria . '</h4>';
                echo '<div class="divider-title"></div>';
                echo '<div class="row">';

                // Consulta SQL para obter os itens relacionados à categoria
                // Consulta SQL para obter os itens relacionados à categoria
                $sql_itens = "SELECT i.*, c.complemento_nome, c.quantidade
                FROM itens i
                LEFT JOIN complementos_produtos c ON i.id = c.item_id
                WHERE i.panel_id = $loja_id 
                AND i.coluna = '{$nomeCategoria}'
                AND (i.valorItem IS NOT NULL OR i.tamanho IS NOT NULL OR i.unidade IS NOT NULL)";
  

                if ($pesquisa !== '') {
                    $sql_itens .= " AND (i.nomeItem LIKE '%$pesquisa%' OR i.descricao LIKE '%$pesquisa%')";
                }
                $sql_itens .= " AND i.temPromocao <> 1";

                $result_itens = $conn->query($sql_itens);

                // Exibe os itens relacionados
                if ($result_itens->num_rows > 0) {
                    while ($row = $result_itens->fetch_assoc()) {
                        $titulo = $row['nomeItem'];
                        $descricao = $row['descricao'];
                        $preco = $row['valorItem'];
                        $complemento_nome = $row['complemento_nome'];
                        $quantidade = $row['quantidade'];

                        // Gerar o HTML dinamicamente com as informações do banco de dados
                        echo '<div class="' . $colCl . '">';
                        echo '<div class="card mt-3 open-modal-card" data-item-id="' . $row['id'] . '" data-item-name="' . $row['nomeItem'] . '" data-item-price="' . $dataItemPrice . '" data-item-image="' . '../admin/app/uploads/' . $row['imagem'] . '">';
                        echo '<div class="card-body">';
                        echo '<div class="row">';
                        echo '<div class="col-md-4 d-flex align-items-center justify-content-center">';
                        echo '<div class="overflow-hidden" style="height: 200px; widht: 200px;">';
                        echo '<img src="../admin/app/uploads/' . $row['imagem'] . '" class="card-img-top img-fluid" alt="Imagem do Produto" style="object-fit: cover; object-position: center; min-width: 100%; min-height: 100%;">';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-8 d-flex flex-column">';
                        echo '<h5 class="card-title mobile-pad">' . $titulo . '</h5>';
                        // Caso contrário, exibe a quantidade seguida de 'x' e o nome do complemento
                        $complemento_nome = str_replace("1x ", "", $complemento_nome);
                        echo '<p class="card-text description mt-1">' . $complemento_nome . '</p>';






                        // Exibindo os tamanhos e valores sem os inputs
                        if ($row['unidade'] === 'tamanho_multiplo') {
                            $itemId = $row['id'];
                            $sqlTamanhosMultiplos = "SELECT nome_tamanho, valor_tamanho FROM tamanhos_multiplos WHERE item_id = ?";
                            $stmtTamanhosMultiplos = $conn->prepare($sqlTamanhosMultiplos);
                            $stmtTamanhosMultiplos->bind_param("i", $itemId);
                            $stmtTamanhosMultiplos->execute();
                            $resultTamanhosMultiplos = $stmtTamanhosMultiplos->get_result();

                            // Array para armazenar os valores dos tamanhos
                            $valoresTamanhos = array();
                            $nomesTamanhos = array();

                            // Exibe os tamanhos múltiplos do item
                            while ($tamanhoMultiplo = $resultTamanhosMultiplos->fetch_assoc()) {
                                $valoresTamanhos[] = $tamanhoMultiplo['valor_tamanho'];
                                $nomesTamanhos[] = $tamanhoMultiplo['nome_tamanho'];
                            }

                            $stmtTamanhosMultiplos->close();

// Encontra o menor valor
$menorValor = min($valoresTamanhos);

// Substitui vírgula por ponto se necessário
$menorValor = str_replace(',', '.', $menorValor);

// Exibe a informação de tamanhos disponíveis e menor valor
echo '<p class="card-text text-tamanho">Tamanhos disponíveis: ' . implode(', ', $nomesTamanhos) . '</p>';
echo '<p class="card-text value">A partir de R$ ' . number_format($menorValor, 2) . '</p>';

                        } elseif ($row['tamanho'] === 'medida_multipla') {
                            $itemId = $row['id'];
                            $sqlMedidasMultiplas = "SELECT medida_nome, medida_valor FROM medidas_multiplas WHERE item_id = ?";
                            $stmtMedidasMultiplas = $conn->prepare($sqlMedidasMultiplas);
                            $stmtMedidasMultiplas->bind_param("i", $itemId);
                            $stmtMedidasMultiplas->execute();
                            $resultMedidasMultiplas = $stmtMedidasMultiplas->get_result();

                            // Array para armazenar os valores das medidas
                            $valoresMedidas = array();
                            $nomesMedidas = array();

                            // Exibe as medidas múltiplas do item
                            while ($medidaMultipla = $resultMedidasMultiplas->fetch_assoc()) {
                                $valoresMedidas[] = $medidaMultipla['medida_valor'];
                                $nomesMedidas[] = $medidaMultipla['medida_nome'];
                            }


                            $stmtMedidasMultiplas->close();

// Encontra o menor valor
$menorValor = min($valoresMedidas);

// Substitui vírgula por ponto se necessário
$menorValor = str_replace(',', '.', $menorValor);

// Exibe a informação de tamanhos disponíveis e menor valor
echo '<p class="card-text text-tamanho">Tamanhos disponíveis: ' . implode(', ', $nomesMedidas) . '</p>';
echo '<p class="card-text card-text value">A partir de R$ ' . number_format($menorValor, 2) . '</p>';

                        } elseif ($row['unidade'] !== 'tamanho_multiplo') {

                            // Consulta para obter as informações da tabela 'bebida'
                            $itemId = $row['id'];
                            $sqlBebida = "SELECT * FROM bebida WHERE bebida_id = ?";
                            $stmtBebida = $conn->prepare($sqlBebida);
                            $stmtBebida->bind_param("i", $itemId);
                            $stmtBebida->execute();
                            $resultBebida = $stmtBebida->get_result();

                            if ($resultBebida->num_rows > 0) {
                                $bebidaRow = $resultBebida->fetch_assoc();
                                $quente = $bebidaRow['quente'];
                                $gelada = $bebidaRow['gelada'];
                            } else {
                                // Lidar com o caso em que não há registro correspondente na tabela 'bebida'
                                $quente = "Não disponível";
                                $gelada = "Não disponível";
                            }

                            $stmtBebida->close();

                            // Adicione aqui o código para lidar com a condição diferente de 'medida_multipla'
                            // Exemplo: Exibe a unidade como size-value
                            echo '<div class="size-value">';
                            echo '<p class="card-text text-tamanho">' . (!empty($row['tamanho']) ? $row['tamanho'] : $row['unidade']) . '</p>';

                            $valorItem = $row['valorItem'];
                            $statusBebida = '';

                            if ($valorItem === null) {
                                if ($quente !== null && $gelada !== null) {
                                    // Ambos quente e gelada têm valores
                                    $valorExibido = 'A partir de R$ ' . number_format(min($quente, $gelada), 2);
                                    $statusBebida = 'Gelado ou Quente';
                                } elseif ($quente !== null) {
                                    // Apenas quente tem valor
                                    $valorExibido = 'R$ ' . number_format($quente, 2);
                                    $statusBebida = 'Quente';
                                } elseif ($gelada !== null) {
                                    // Apenas gelada tem valor
                                    $valorExibido = 'R$ ' . number_format($gelada, 2);
                                    $statusBebida = 'Gelado';
                                } else {
                                    // Ambos quente e gelada são nulos
                                    $valorExibido = 'Valor não disponível';
                                }
                            } else {
                                // $valorItem não é nulo
                                $valorExibido = 'R$ ' . number_format($valorItem, 2);
                            }


                            // Após obter $statusBebida, verifique se não está vazio antes de exibir o texto
                            if (!empty($statusBebida)) {
                                echo '<p class="card-text text-tamanho">Disponível: ' . $statusBebida . '</p>';
                            }

                            echo '<p class="card-text value">' . $valorExibido . '</p>';

                            echo '</div>';
                        } elseif ($row['tamanho'] !== 'medida_multipla') {
                            // Adicione aqui o código para lidar com a condição diferente de 'medida_multipla'
                            // Exemplo: Exibe a unidade como size-value
                            echo '<div class="size-value">';
                            echo '<p class="card-text text-tamanho">' . (!empty($row['tamanho']) ? $row['tamanho'] : $row['unidade']) . '</p>';
                            echo '<p class="card-text value">R$ ' . number_format($row['valorItem'], 2) . '</p>';
                            echo '</div>';
                        }
                        echo '</div>'; // Fecha a col-md-8
                        echo '</div>'; // Fecha a row
                        echo '</div>'; // Fecha a card-body
                        echo '</div>'; // Fecha a card
                        echo '</div>'; // Fecha a col-md
                    }
                    echo '</div>';
                } else {
                    echo '<p>Nenhum item encontrado para a categoria ' . $nomeCategoria . '</p>';
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';

                // Incrementa o número de colunas na linha
                $numColunasNaLinha++;

                // Verifica se atingiu dois cards na linha (se tamanho da categoria é 2)
                if ($tamanhoCategoria == 2 && $numColunasNaLinha % 2 == 0) {
                    // Fecha a linha
                    echo '</div><div class="row">';
                }
            }

            // Fecha a div da row ao final do loop
            echo '</div>';
        } else {
            // Se não houver dados
            echo "Nenhum item disponível nessa loja.";
        }

        ?>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title title-modal-pedido" id="exampleModalLabel"><i class="fa-solid fa-bag-shopping"></i> FAZER PEDIDO</h5>
                        <a type="button" class="close edit-fechar" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times close"></i>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <h3 class="text-center text-name-product" id="modalItemName"></h3>

                            <div class="col-md-12">

                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="" id="modalItemImage" class="mx-auto rounded" style="height: 150px; width: 180px;" alt="Produto sem Imagem">
                                </div>

                                <h6 class="" id="modalComplementosItem"></h6>
                                <hr>

                                <div class="row">
                                    <div class="col-md-9">
                                        <h5>Selecione o tamanho:</h5>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="obrigatorio float-right text-center">Obrigatório *</p>
                                    </div>
                                </div>
                                <div class="border rounded p-3">
                                    <div id="modalTamanhos"></div>
                                </div>

                                <hr>
                                <div id="modalComplementos" style="max-height: 300px; overflow-y: auto;"></div> <!-- Adicionando scroll -->



                                <div class="form-group">
                                    <h5 class="mb-0 mt-4">Observação: <span id="#"></span></h5>
                                    <textarea class="form-control" id="observacao" rows="4" placeholder="Insira aqui sua observação"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="border rounded p-1 mobile-custom">
                            <button class="btn btn-sm btn-custom" id="decrement" type="button">-</button>
                            <span id="quantity" class="btn btn-sm btn-custom" data-value="1" data-min="1">1</span>
                            <button class="btn btn-sm btn-custom" id="increment" type="button">+</button>
                        </div>

                        <script>
                            $(document).ready(function() {
                                // Limpar o campo de observação quando o modal é aberto
                                $('#exampleModal').on('show.bs.modal', function(e) {
                                    $('#observacao').val('');
                                });

                                // (Opcional) Limpar o campo de observação quando o modal é fechado
                                $('#exampleModal').on('hide.bs.modal', function(e) {
                                    $('#observacao').val('');
                                });
                            });
                        </script>



                        <script>
                            $(document).ready(function() {
                                var quantitySpan = $("#quantity");
                                var decrementButton = $("#decrement");
                                var incrementButton = $("#increment");
                                var modalComplementos = $("#modalComplementos");

                                decrementButton.on("click", function() {
                                    atualizarQuantidade(-1);
                                });

                                incrementButton.on("click", function() {
                                    atualizarQuantidade(1);
                                });

                                function atualizarQuantidade(valor) {
                                    var currentValue = parseInt(quantitySpan.data("value")) || 1;
                                    var minValue = parseInt(quantitySpan.data("min")) || 1;

                                    if (!isNaN(currentValue)) {
                                        var novaQuantidade = currentValue + valor;
                                        novaQuantidade = Math.max(minValue, novaQuantidade);

                                        quantitySpan.data("value", novaQuantidade);
                                        quantitySpan.text(novaQuantidade);
                                        atualizarTotal();
                                    }
                                }

                                function atualizarTotal() {
                                    var valorSoma = parseFloat($("#result_soma").text()) || 0;
                                    var valorPrecoSelecionado = parseFloat($("#preco-selecionado").text()) || 0;
                                    var quantidade = parseInt(quantitySpan.data("value")) || 1;

                                    var resultado = (valorSoma + valorPrecoSelecionado) * quantidade;

                                    $("#result_totais").text(resultado.toFixed(2));
                                }

                                // Chamar a função de atualização quando spans são modificados
                                $("#result_soma, #preco-selecionado").on("DOMSubtreeModified", function() {
                                    atualizarTotal();
                                });

                                // Limpar o conteúdo da div e reiniciar incrementos quando o modal é fechado
                                $('#exampleModal').on('hidden.bs.modal', function() {
                                    modalComplementos.empty();
                                    // Reinicie outros incrementos se necessário

                                    // Resetar a quantidade e valores relacionados
                                    quantitySpan.data("value", 1);
                                    quantitySpan.text("1");
                                    $("#result_soma, #preco-selecionado, #result_totais").text("0.00");
                                });

                                // Chamar a função de atualização pela primeira vez
                                atualizarTotal();
                            });

                            $(document).ready(function() {
                                // Manipulador de eventos para o botão de fechar
                                $('.edit-fechar').click(function() {
                                    $('#exampleModal').modal('hide');
                                });
                            });
                        </script>




                        <span id="result_soma">0.00</span>
                        <span id="preco-selecionado">0.00</span>


                        <button id="adicionarAoCarrinho" class="btn btn-secondary mobile-custom-1" onclick="adicionarAoCarrinhoERolar()">
                            <i class="fa-solid fa-cart-shopping"></i> Adicionar ao Carrinho
                            <span id="result_totais">0.00</span>
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <script>
            // Ocultar spans com IDs "result_soma" e "preco-selecionado"
            $('#result_soma, #preco-selecionado').hide();
        </script>






        <script>
            $(document).ready(function() {
                $(".open-modal-card").on("click", function(e) {
                    var itemId = $(this).data('item-id');
                    var itemName = $(this).data('item-name');
                    var itemPrice = $(this).data('item-price');
                    var itemImage = $(this).data('item-image');

                    // Atualiza os elementos no modal com os dados obtidos
                    $("#modalItemImage").attr("src", itemImage);
                    $("#modalItemName").text(itemName);

                    // Formata o preço do item como moeda antes de exibi-lo
                    var formattedPrice = parseFloat(itemPrice).toFixed(2);
                    $("#modalItemPrice").text("R$ " + formattedPrice);

                    // Limpa os complementos existentes antes de carregar novos
                    // $("#modalComplementosItem").empty();

                    // Mostra o indicador de carregamento
                    //  $("#modalComplementosItem").html('<div class="loader">Carregando...</div>');




                    // Consulta SQL para obter complementos adicionais associados ao item
                    $.ajax({
                        url: '../admin/app/functions/consulta_produto.php',
                        method: 'POST',
                        data: {
                            itemId: itemId
                        },
                        dataType: 'json',
                        success: function(data) {
                            var complementosHTML2 = '';
                            if (data.length > 0) {
                                complementosHTML2 += '<h5 class="mt-3"></h5><ul class="list-group">';
                                for (var i = 0; i < data.length; i++) {
                                    complementosHTML2 += '<li class="list-group-item">' + data[i].complemento_nome + '</li>';
                                }
                                complementosHTML2 += '</ul>';
                            } else {
                                // Se não tiver complementos, não adiciona nada ao HTML
                            }

                            // Adiciona os complementos ao modal
                            $("#modalComplementosItem").html(complementosHTML2);
                        },
                        error: function(xhr, status, error) {
                            $("#modalComplementosItem").html('<p>Erro ao carregar complementos. <button class="retry-load">Tentar novamente</button></p>');
                        }
                    });



                    // Declara uma variável para armazenar os dados
                    var dadosTamanhos;
                    $.ajax({
                        url: '../admin/app/functions/consulta_tamanhos.php',
                        method: 'POST',
                        data: {
                            itemId: itemId
                        },
                        dataType: 'json',
                        success: function(data) {
                            dadosTamanhos = data;

                            if (data && data.tamanhos.length > 0) {
                                var tamanhoHTML = '<ul class="list-group">';
                                for (var i = 0; i < data.tamanhos.length; i++) {
                                    tamanhoHTML += '<div class="form-check mt-2">';
                                    if (data.isBebida) {
                                        var valores = data.menorValor.split(',');

                                        if (valores[0]) {
                                            tamanhoHTML += '<input class="form-check-input" type="radio" name="tamanho" id="tamanhoQuente' + i + '" value="Quente" data-preco="' + valores[0] + '">';
                                            tamanhoHTML += '<label class="form-check-label" for="tamanhoQuente' + i + '">Quente - ' + parseFloat(valores[0]).toLocaleString('pt-BR', {
                                                style: 'currency',
                                                currency: 'BRL'
                                            }) + '</label><br>';
                                        }

                                        if (valores[1]) {
                                            tamanhoHTML += '<input class="form-check-input" type="radio" name="tamanho" id="tamanhoGelada' + i + '" value="Gelada" data-preco="' + valores[1] + '">';
                                            tamanhoHTML += '<label class="form-check-label" for="tamanhoGelada' + i + '">Gelada - ' + parseFloat(valores[1]).toLocaleString('pt-BR', {
                                                style: 'currency',
                                                currency: 'BRL'
                                            }) + '</label>';
                                        }
                                    } else {
                                        // Sua lógica existente para outros itens
                                        var valorNumerico = parseFloat(data.menorValor[i]);
                                        var valorFormatado = valorNumerico.toLocaleString('pt-BR', {
                                            style: 'currency',
                                            currency: 'BRL'
                                        });
                                        var tamanhos = data.tamanhos[i].split(',');

                                        for (var j = 0; j < tamanhos.length; j++) {
                                            tamanhoHTML += '<input class="form-check-input" type="radio" name="tamanho" id="tamanho' + i + j + '" value="' + tamanhos[j] + '">';
                                            tamanhoHTML += '<label class="form-check-label" for="tamanho' + i + j + '">' + tamanhos[j] + ' - ' + valorFormatado + '</label><br>';
                                        }
                                    }

                                    tamanhoHTML += '</div>';
                                }
                                tamanhoHTML += '</ul>';

                                $("#modalTamanhos").html(tamanhoHTML);
                            }
                        },
                        error: function(xhr, status, error) {}
                    });

                    $("#modalTamanhos").on("change", "input[name='tamanho']", function() {
                        // Obtém o valor do atributo data-preco
                        var valorNumerico = parseFloat($(this).data('preco'));


                        // Verifica se o valor é numérico e não é NaN
                        if (!isNaN(valorNumerico)) {
                            // Formata o valor com duas casas decimais
                            var valorFormatado = valorNumerico.toFixed(2);

                            // Atualiza o preço no modal
                            $("#preco-selecionado").text(valorFormatado);

                            // Atualiza o data-item-price no botão "Adicionar ao Carrinho"
                            $("#adicionarAoCarrinho").data('item-price', valorNumerico);
                        }
                    });


                    // Manipulador de eventos para o clique nos radios de tamanho
                    $("#modalTamanhos").on("change", "input[name='tamanho']", function() { // Obtém o valor associado a este tamanho
                        var valorTamanhoString = $(this).val();


                        // Verifica se a variável dadosTamanhos está definida
                        if (dadosTamanhos) {
                            // Obtém o índice do tamanho selecionado no array de tamanhos
                            var indiceTamanho = dadosTamanhos.tamanhos.indexOf(valorTamanhoString);

                            // Verifica se o tamanho selecionado está presente no array de tamanhos
                            if (indiceTamanho !== -1) {
                                // Obtém o valor associado ao tamanho a partir de menorValor
                                var valorNumerico = parseFloat(dadosTamanhos.menorValor[indiceTamanho]);


                                // Formata o valor com duas casas decimais
                                var valorFormatado = valorNumerico.toFixed(2);

                                // Atualiza o preço exibido no modal
                                if (!isNaN(valorNumerico)) {
                                    // Atualiza o preço no modal
                                    $("#preco-selecionado").text(valorFormatado);

                                    // Atualiza o data-item-price no botão "Adicionar ao Carrinho"
                                    $("#adicionarAoCarrinho").data('item-price', valorNumerico);
                                }
                            } else {

                                // Chamada AJAX para buscar por unidade
                                $.ajax({
                                    url: '../admin/app/functions/consulta_unidades.php',
                                    method: 'POST',
                                    data: {
                                        itemId: itemId
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.unidade) {
                                            // Use o valor da unidade obtido da resposta
                                            var valorUnidade = response.unidade;

                                            // Atualiza o preço no modal
                                            $("#preco-selecionado").text(valorUnidade);

                                            // Atualiza o data-item-price no botão "Adicionar ao Carrinho"
                                            $("#adicionarAoCarrinho").data('item-price', valorUnidade);
                                        } else {
                                            // Trate o caso em que a unidade também não é encontrada
                                        }
                                    },
                                    error: function(xhr, status, error) {}
                                });

                            }

                        } else {}

                        // Função para desmarcar todos os botões de tamanho
                        function desmarcarBotoesTamanho() {
                            $("input[name='tamanho']").prop('checked', false);
                        }

                        // Evento ao abrir o modal
                        $('#exampleModal').on('shown.bs.modal', function() {

                            //  $("#modalComplementos").empty();
                            //   $("#modalComplementosItem").empty();

                            desmarcarBotoesTamanho();
                        });

                        // Evento ao fechar o modal
                        $('#exampleModal').on('hidden.bs.modal', function() {
                            desmarcarBotoesTamanho();
                        });

                        // Evento ao clicar no botão de submissão
                        $("#adicionarAoCarrinho").click(function(e) {
                            // Verifica se algum botão de rádio está marcado
                            var isTamanhoSelected = $("input[name='tamanho']:checked").length > 0;

                            // Se nenhum botão de rádio estiver marcado, impede a submissão e mostra um alerta
                            if (!isTamanhoSelected) {
                                e.preventDefault(); // Impede a submissão do formulário
                                alert("Por favor, selecione pelo menos um tamanho.");
                                return false; // Impede a execução de qualquer código adicional
                            }

                            // Se um tamanho está selecionado, o código continua (aqui você pode adicionar o código para submeter o formulário)
                        });


                    });




                    // Consulta SQL para obter complementos adicionais associados ao item
                    $.ajax({
                        url: '../admin/app/functions/consulta_complementos.php',
                        method: 'POST',
                        data: {
                            itemId: itemId
                        },
                        dataType: 'json',
                        success: function(data) {
                            // Adicionar lógica para processar os dados recebidos e preencher o modal
                            if (data.length > 0) {
                                var complementosHTML = '<h5 class="mt-3">Complementos Adicionais Disponíveis:</h5><ul class="list-group">';
                                for (var i = 0; i < data.length; i++) {
                                    complementosHTML += '<li class="list-group-item">';
                                    complementosHTML += '<div class="custom-control custom-checkbox d-flex justify-content-between align-items-center">';
                                    complementosHTML += '<div class="mr-3">';
                                    complementosHTML += '<input type="checkbox" class="custom-control-input complemento-checkbox" data-nome="' + data[i].complemento_nome + '" data-valor="' + data[i].valor + '" id="complemento' + i + '" hidden>';
                                    complementosHTML += '<label class="custom-control-label" for="complemento' + i + '">' + data[i].complemento_nome + ' + R$ ' + data[i].valor + '</label>';
                                    complementosHTML += '</div>';
                                    complementosHTML += '<div class="d-flex align-items-center ml-3">';
                                    complementosHTML += '<button type="button" class="btn btn-sm btn-custom mr-2 complemento-decrement" data-index="' + i + '">-</button>';
                                    complementosHTML += '<span id="complementoQuantidade' + i + '" class="complemento-quantidade" data-quantidade="0">0</span>';
                                    complementosHTML += '<button type="button" class="btn btn-sm btn-custom ml-2 complemento-increment" data-quantidade="' + i + '" data-index="' + i + '">+</button>';
                                    complementosHTML += '</div>';
                                    complementosHTML += '</div>';
                                    complementosHTML += '</li>';

                                }

                                complementosHTML += '</ul>';

                                // Adiciona os complementos ao modal
                                $("#modalComplementos").html(complementosHTML);
                            }

                            // Função para incrementar a quantidade do complemento
                            function incrementarQuantidadeComplemento(index) {
                                var quantidadeSpan = $("#modalComplementos").find('.complemento-quantidade').eq(index);
                                var quantidade = parseInt(quantidadeSpan.text(), 10) + 1;
                                quantidadeSpan.text(quantidade);

                                var nomeItem = $("#modalComplementos").find('.complemento-checkbox').eq(index).data('nome') || '';
                                var valorItem = parseFloat($("#modalComplementos").find('.complemento-checkbox').eq(index).data('valor')) || 0.0;


                                if (quantidade > 0) {
                                    $("#modalComplementos").find('.complemento-checkbox').eq(index).prop('checked', true);
                                }
                            }

                            // Função para decrementar a quantidade do complemento
                            function decrementarQuantidadeComplemento(index) {
                                var quantidadeSpan = $("#modalComplementos").find('.complemento-quantidade').eq(index);
                                var quantidade = parseInt(quantidadeSpan.text(), 10) - 1;
                                quantidade = Math.max(0, quantidade);
                                quantidadeSpan.text(quantidade);

                                var nomeItem = $("#modalComplementos").find('.complemento-checkbox').eq(index).data('nome') || '';
                                var valorItem = parseFloat($("#modalComplementos").find('.complemento-checkbox').eq(index).data('valor')) || 0.0;

                                if (quantidade === 0) {
                                    $("#modalComplementos").find('.complemento-checkbox').eq(index).prop('checked', false);
                                }
                            }



                            // Função para calcular o total e atualizar o span
                            function atualizarTotal(index) {
                                var total = 0;

                                // Itera sobre os complementos para calcular o total
                                $("#modalComplementos .complemento-checkbox:checked").each(function(i) {
                                    var quantidadeSpan = $("#modalComplementos").find('.complemento-quantidade').eq(i);
                                    var valorItem = parseFloat($(this).data('valor'));
                                    var quantidade = parseInt(quantidadeSpan.text(), 10);
                                    quantidade = Math.max(0, quantidade);
                                    quantidadeSpan.text(quantidade);

                                    total += valorItem * quantidade;
                                });


                                // Atualiza o span com o id "preco-selecionado"
                                $("#result_soma").text(total.toFixed(2));
                            }

                            // Remover eventos de clique antes de adicioná-los novamente
                            $("#modalComplementos").off("click", ".complemento-increment");
                            $("#modalComplementos").off("click", ".complemento-decrement");

                            // Adicionar eventos de clique nos botões de incremento e decremento
                            $("#modalComplementos").on("click", ".complemento-increment", function() {
                                var index = $(this).data("index");
                                incrementarQuantidadeComplemento(index);
                                atualizarTotal();
                            });

                            $("#modalComplementos").on("click", ".complemento-decrement", function() {
                                var index = $(this).data("index");
                                decrementarQuantidadeComplemento(index);
                                atualizarTotal();
                            });

                            // Evento de fechamento do modal
                            $('#exampleModal').on('hidden.bs.modal', function() {
                                // Itera sobre os complementos para redefinir quantidades e desmarcar checkboxes
                                $("#modalComplementos .complemento-checkbox").each(function() {
                                    var index = $(this).data("index");

                                    // Redefine a quantidade para 0
                                    $("#modalComplementos .complemento-quantidade").eq(index).text(0);

                                    // Desmarca o checkbox
                                    $(this).prop('checked', false);
                                });

                                // Atualiza o total
                                atualizarTotal();
                            });





                        },
                        error: function(error) {}
                    });





                    // Manipulador de eventos para o clique nos checkboxes de complementos
                    $("#modalComplementos").on("change", ".complemento-checkbox", function() {
                        // Calcula o preço total dos complementos
                        var totalComplementos = calcularPrecoComplementos();

                        // Adiciona o preço total dos complementos ao preço do item selecionado
                        var valorItem = parseFloat($("#preco-selecionado").text());
                        var novoPreco = valorItem + totalComplementos;

                        // Formata o novo preço com duas casas decimais
                        var novoPrecoFormatado = novoPreco.toFixed(2);

                        // Atualiza o preço total no botão
                        $("#preco-selecionado").text(novoPrecoFormatado);

                        // Atualiza o data-item-price no botão "Adicionar ao Carrinho"
                        $("#adicionarAoCarrinho").data('item-price', novoPreco);
                    });






                    // Encontrar os checkboxes marcados
                    var checkboxesSelecionados = $("#modalComplementos").find('.complemento-checkbox:checked');

                    // Inicializar o preço total
                    var precoTotal = parseFloat(itemPrice);

                    // Iterar sobre os checkboxes selecionados e adicionar seus valores ao preço total
                    checkboxesSelecionados.each(function() {
                        var valorCheckbox = parseFloat($(this).data('item-price'));
                        if (!isNaN(valorCheckbox)) {
                            precoTotal += valorCheckbox;
                        }
                    });

                    // Atualizar o data-item-price no botão "Adicionar ao Carrinho"
                    $("#adicionarAoCarrinho").data('item-price', precoTotal);

                    // Abre o modal
                    $('#exampleModal').modal('show');
                });

            });

            function adicionarAoCarrinhoERolar() {
                var carrinhoModal = $('#carrinhoModal');
                var exampleModal = $('#exampleModal')

                // Adiciona um efeito de tremer no bloco do carrinho
                $('#abrir-menu').addClass('tremor');
                setTimeout(function() {
                    $('#abrir-menu').removeClass('tremor');
                }, 1000); // Tempo em milissegundos, ajuste conforme necessário

                // Rola até o elemento com id "abrir-menu"
                $('html, body').animate({
                    scrollTop: $('#horario').offset().top
                }, 1000); // O valor '1000' representa a duração da animação em milissegundos, ajuste conforme necessário

                // Atualiza a quantidade de itens no carrinho na <p> dentro da div com a classe "cart"
                atualizarQuantidadeItensCarrinho();

                // Fecha o modal após 3 segundos
                setTimeout(function() {
                    exampleModal.modal('hide');
                }, 3000); // 3000 milissegundos = 3 segundos
            }


            function atualizarQuantidadeItensCarrinho() {
                var carrinhoItens = JSON.parse(localStorage.getItem('carrinhoItens')) || [];
                var quantidadeItens = carrinhoItens.length;

                // Atualiza a quantidade de itens no carrinho na <p>
                $('.cart p').text(quantidadeItens);

                // Salva a quantidade no localStorage para persistência
                localStorage.setItem('quantidadeItensCarrinho', quantidadeItens);


            }

            function inicializarQuantidadeItensCarrinho() {
                var quantidadeSalva = localStorage.getItem('quantidadeItensCarrinho');
                if (quantidadeSalva !== null && quantidadeSalva !== "") {
                    $('.cart p').text(quantidadeSalva);
                } else {
                    $('.cart p').text("Carrinho vazio.");
                }
            }


            // Chame a função de inicialização ao carregar a página
            $(document).ready(function() {
                inicializarQuantidadeItensCarrinho();
            });

            // Exemplo de como adicionar um item ao carrinho
            function adicionarItemAoCarrinho() {
                var carrinhoItens = JSON.parse(localStorage.getItem('carrinhoItens')) || [];
                carrinhoItens.push({
                    /* Seu objeto de item aqui */
                });
                localStorage.setItem('carrinhoItens', JSON.stringify(carrinhoItens));

                // Atualiza a quantidade de itens no carrinho
                atualizarQuantidadeItensCarrinho();
            }

        </script>







        <!--FINAL DO CARD DE 1 FILEIRA-->

    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tamanhoSelecionadoSpan = document.getElementById('tamanhoSelecionado');
            var pedidoBtn = document.getElementById('pedidoBtn');
            var tamanhoCheckboxes = document.querySelectorAll('.value-checkbox');

            tamanhoCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var tamanhoSelecionado = Array.from(tamanhoCheckboxes).find(function(checkbox) {
                        return checkbox.checked;
                    });

                    if (tamanhoSelecionado) {
                        tamanhoSelecionadoSpan.textContent = tamanhoSelecionado.nextElementSibling.querySelector('.value-span').textContent;
                        pedidoBtn.removeAttribute('disabled');
                    } else {
                        tamanhoSelecionadoSpan.textContent = '';
                        pedidoBtn.setAttribute('disabled', 'true');
                    }
                });
            });
        });
    </script>


    <!-- CARRINHO DE ITENS -->
    <script>
        function redirecionarParaCheckout() {
            // Implemente a lógica para redirecionar para a página de checkout
            window.location.href = 'pages/checkout.php';
        }
    </script>



    <!-- Modal de Carrinho -->
    <div class="modal fade" id="carrinhoModal" tabindex="-1" role="dialog" aria-labelledby="carrinhoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="carrinhoModalLabel">Seu pedido..</h5>
                    <a type="button" class="close edit-fechar" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
                <div class="modal-body" id="carrinhoModalBody">
                    <!-- Aqui serão exibidos os itens do carrinho -->

                </div>
                <div class="entrega ms-auto">

                    <p class="px-3 text-entrega">Taxa de entrega <span class="gratis">
                            <?php
                            if ($valor_frete === "Grátis") {
                                echo $valor_frete;
                            } else {
                                // Supondo que $valor_frete seja um número, formatá-lo como BRL
                                $valorFormatado = number_format($valor_frete, 2, ',', '.');
                                echo "R$ " . $valorFormatado;
                            }
                            ?>
                        </span>
                        </span> para a cidade de <?php echo $cidade; ?></p>

                </div>
                <div class="entrega ms-auto">

                    <p class="px-3 text-entrega">Taxa de entrega para fora a combinar</p>


                </div>

                <div class="col-md-12 p-3">
                    <div class="valor-final">
                        <p><strong>VALOR FINAL: <span id="valorFinalSpan">R$ 0,00</span> <i class="fa-solid fa-comment-dollar"></i></strong></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-edit-finish btn-block" onclick="redirecionarParaCheckout()">Finalizar Pedido</button>
                </div>

            </div>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            $('.edit-fechar, .edit-fechar i').click(function() {
                $('#carrinhoModal').modal('hide');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            verificarCarrinhoVazio();
            atualizarTotalCarrinho(totalCarrinho, true);


            function verificarCarrinhoVazio() {
                var conteudoCarrinho = $("#carrinhoModalBody").html().trim();

                if (conteudoCarrinho === '') {
                    // Se o carrinho estiver vazio, exibe a mensagem e desativa o botão
                    $("#carrinhoModalBody").html("<p>O carrinho está vazio.</p>");
                    $(".btn-edit-finish").prop('disabled', true);
                } else {
                    // Se o carrinho não estiver vazio, ativa o botão
                    $(".btn-edit-finish").prop('disabled', false);
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var totalCarrinho = 0;
            atualizarQuantidadeItensCarrinho();

            function converterPrecoParaNumero(precoFormatado) {
                return parseFloat(precoFormatado.replace("R$ ", "").replace(",", "."));
            }

            function atualizarTotalCarrinho(precoItem, adicionar) {
                if (adicionar) {
                    totalCarrinho += precoItem;
                } else {
                    totalCarrinho -= precoItem;
                }
                $("#valorFinalSpan").text("R$ " + totalCarrinho.toFixed(2));
            }



    // Adicione a chamada para carregar os itens do carrinho ao iniciar o script
    carregarItensDoCarrinho(JSON.parse(localStorage.getItem('carrinhoItens')) || []);


            $("#adicionarAoCarrinho").on("click", function() {
                var itemName = $("#modalItemName").text();
                var itemSize = $("#modalTamanhos").find("input:checked").val();
                var itemQuantity = $("#quantity").data("value");
                var itemObservation = $("#observacao").val();

                var itemComplementos = "";
                $("#modalComplementos input:checked").each(function(index) {
                    var complementoNome = $(this).data("nome");
                    // Encontra a quantidade correspondente a este complemento
                    var complementoQuantidade = $("#modalComplementos").find('.complemento-quantidade').eq(index).text();
                    itemComplementos += "<p>" + complementoQuantidade + "x " + complementoNome + "</p>";
                });

                var itemPrice = parseFloat($("#result_totais").text()) || 0;

                // Verificar se o preço do item é maior que 0 antes de adicionar ao carrinho
                if (itemPrice > 0) {
                    // Adicione um identificador único para cada item no carrinho
                    var carrinhoItem = {
                        itemID: generateUniqueID(),
                        itemName: itemName,
                        itemSize: itemSize,
                        itemQuantity: itemQuantity,
                        itemObservation: itemObservation,
                        itemComplementos: itemComplementos,
                        itemPrice: itemPrice
                    };

                    salvarItemNoCarrinho(carrinhoItem);
                    exibirItemNoCarrinho(carrinhoItem);
                    fecharModalPedido();

                    // Mensagem de sucesso utilizando SweetAlert
                    Swal.fire({
                        title: "Item Adicionado",
                        text: "O item foi adicionado ao carrinho com sucesso!",
                        icon: "success",
                        button: "OK",
                    });
                } else {
                    // Alerta utilizando SweetAlert
                    Swal.fire({
                        title: "Ação Não Realizada",
                        text: "Você precisa adicionar um tamanho para adicionar o item ao carrinho.",
                        icon: "error",
                        button: "OK",
                    });
                }
            });



            function generateUniqueID() {
                return '_' + Math.random().toString(36).substr(2, 9);
            }

            function salvarItemNoCarrinho(carrinhoItem) {
                var carrinhoItensSalvos = JSON.parse(localStorage.getItem('carrinhoItens')) || [];

                // Encontrar um item existente que corresponda ao item atual em nome, tamanho e complementos
                var itemExistente = carrinhoItensSalvos.find(function(item) {
                    return item.itemName === carrinhoItem.itemName &&
                        item.itemSize === carrinhoItem.itemSize &&
                        item.itemComplementos === carrinhoItem.itemComplementos;
                });

                if (itemExistente) {
                    // Aumentar a quantidade do item existente e atualizar o preço
                    itemExistente.itemQuantity += carrinhoItem.itemQuantity;
                    itemExistente.itemPrice += carrinhoItem.itemPrice;
                } else {
                    // Se não houver um item correspondente, adicione um novo
                    carrinhoItensSalvos.push(carrinhoItem);
                }

                // Atualizar o localStorage
                localStorage.setItem('carrinhoItens', JSON.stringify(carrinhoItensSalvos));
            }




            function exibirItemNoCarrinho(carrinhoItem) {
                var cartItemHtml = "<h6 class='card-title'>" + carrinhoItem.itemQuantity + "x " + carrinhoItem.itemName + " - " + carrinhoItem.itemSize + ", (0" + carrinhoItem.itemQuantity + (carrinhoItem.itemQuantity > 1 ? " Unidades" : " Unidade") + ")</h6>";
                if (carrinhoItem.itemComplementos) {
                    cartItemHtml += "<div class='card-text text-carrinho'>" + carrinhoItem.itemComplementos + "</div>";
                }
                if (carrinhoItem.itemObservation) {
                    cartItemHtml += "<p class='card-text'><small class='text-muted'>Observação: " + carrinhoItem.itemObservation + "</small></p>";
                }
                cartItemHtml += "<p class='card-text'><strong>R$ " + (carrinhoItem.itemPrice).toFixed(2) + "</strong></p>";
                cartItemHtml += "<button class='btn-remover btn-cart ms-auto' data-item-id='" + carrinhoItem.itemID + "'>Remover</button>";
                cartItemHtml += "<hr>";
                $("#carrinhoModalBody").append(cartItemHtml);
                atualizarQuantidadeItensCarrinho();
                atribuirManipuladoresDeEventosRemover();
            }



            function atribuirManipuladoresDeEventosRemover() {
                $(".btn-remover").unbind().click(function() {
                    var itemID = $(this).data("item-id");
                    removerItemDoCarrinho(itemID);
                });
            }

            function obterPrecoItemPorID(itemID) {
                var carrinhoItensSalvos = JSON.parse(localStorage.getItem('carrinhoItens')) || [];
                var itemEncontrado = carrinhoItensSalvos.find(function(item) {
                    return item.itemID === itemID;
                });
                return itemEncontrado ? itemEncontrado.itemPrice : 0;
            }

            function removerItemDoCarrinho(itemID) {
    var precoItem = obterPrecoItemPorID(itemID);
    var carrinhoItensSalvos = JSON.parse(localStorage.getItem('carrinhoItens')) || [];
    var carrinhoItensFiltrados = carrinhoItensSalvos.filter(function(item) {
        return item.itemID !== itemID;
    });

    localStorage.setItem('carrinhoItens', JSON.stringify(carrinhoItensFiltrados));

    // Define uma variável no sessionStorage para indicar que um item foi removido
    sessionStorage.setItem('itemRemovido', 'true');

    // Recarrega a página para refletir as mudanças
    location.reload();
}

// Verifica se o sessionStorage indica que um item foi removido
$(document).ready(function() {
    var itemRemovido = sessionStorage.getItem('itemRemovido');

    if (itemRemovido === "true") {
        // Abre o modal
        $('#carrinhoModal').modal('show');

        // Limpa a variável no sessionStorage após abrir o modal
        sessionStorage.removeItem('itemRemovido');
    }
});





            function carregarItensDoCarrinho(itens) {
                // Limpe o corpo do carrinho antes de adicionar os itens
                $("#carrinhoModalBody").empty();

                // Adicione os itens do carrinho ao modal
                itens.forEach(function(carrinhoItem) {
                    exibirItemNoCarrinho(carrinhoItem);
                });

                // Recalcular o total do carrinho após carregar todos os itens
                var totalCarrinho = 0;
                itens.forEach(function(carrinhoItem) {
                    totalCarrinho += carrinhoItem.itemPrice; // Multiplicando pelo quantidade de itens
                });

                // Atualizar o total do carrinho após carregar todos os itens
                atualizarTotalCarrinho(totalCarrinho, true);
            }


            function fecharModalPedido() {
                $("#modalPedido").modal("hide");
            }
        });
    </script>


    </div>
    <div class="divider-title"></div>


    <?php include_once "includes/footer.php";  ?>










</body>

</html>