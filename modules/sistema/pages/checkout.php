<?php
include_once "../includes/connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <!-- Adicione os links para os arquivos CSS e JS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../style/style.css">
    <!-- Adicione o link para o arquivo JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/<i class='fa-solid fa-circle-check conf'></i>-icon" href="https://resultarmind.cloud/resultarmind/Acesa.ico">


    <!-- Inclua o jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</head>

<body>

    <?php include_once "../includes/header.php";  ?>







    <div class="container mt-5">

        <div class="divider-title"></div>







        <!-- Script para abrir o modal ao clicar no input -->
        <script>
            function abrirModal() {
                $('#entregaModal').modal('show');
            }

            function atualizarEntrega() {
                const selectedOption = document.querySelector('input[name="entregaOption"]:checked').value;
                document.getElementById('entregaInput').querySelector('p').innerText = selectedOption;
                $('#entregaModal').modal('hide'); // Fechar o modal

                // Armazenar a escolha no LocalStorage
                localStorage.setItem('escolhaEntrega', selectedOption);


                // Recarregar a página
            }

            // Verificar se há uma escolha armazenada e atualizar o input
            const escolhaArmazenada = localStorage.getItem('escolhaEntrega');
            if (escolhaArmazenada) {
                document.getElementById('entregaInput').value = escolhaArmazenada;
            }
        </script>



    </div>


    <div class="divider-title"></div>
    <form id="formPedido" action="processar_pedido.php" method="POST">

        <h4 class="text-center">CONFIRME OS DADOS PARA REALIZAR O PEDIDO</h4>

        <div class="row">
            <div class="col-md-8">
                <div class="pedido">
                    <div class="col-md-12">
                        <div class="card mt-3 mb-3 not-hover">
                            <div class="card-body">
                                <h3 class="text-center title-cat2">PEDIDOS</h3>
                                <div class="divider-title"></div>

                                <div class="row">

                                    <div id="carrinhoCheckout"></div>

                                </div>

                                <div class="divider-title"></div>


                                <div class="col ms-auto">
                                    <div class="valor-final">
                                        <p><strong>VALOR FINAL: <span id="valorFinalSpan">R$ 0,00</span> <i class="fa-solid fa-comment-dollar"></i></strong></p>
                                    </div>
                                </div>

                            </div>
                        </div>




                    </div>
                </div>

                <div class="col-md-6 custom-align-right">
                    <div class="add-item">
                        <a href="../index.php"><strong>ADICIONE MAIS ITENS AO CARRINHO <i class="fa-solid fa-square-plus"></i></strong></a>
                    </div>
                </div>



            </div>

            <div class="col-md-4 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center title-cat2">INFORME SEUS DADOS</h3>
                        <div class="divider-title"></div>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
                        </div>

                        <input type="hidden" id="loja_id" name="loja_id" value="<?php echo $loja_id; ?>">

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone (WhatsApp):</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX" required>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

                        <script>
                            $(document).ready(function() {
                                $("#telefone").mask("(00) 00000-0000");
                            });
                        </script>


                        <div class="mb-3">
                            <label for="metodo-entrega" class="form-label">Método de Entrega:</label>
                            <select class="form-select" id="metodo-entrega" name="metodo-entrega" required>
                                <option value="" selected disabled>Selecione o Método de Entrega</option>
                                <option value="Entrega">Entrega</option>
                                <option value="Retirada em Loja">Retirada em Loja</option>
                            </select>
                        </div>


                        <div id="endereco-campos" style="display: none;">
                            <div class="mb-3">
                                <label for="endereco" class="form-label">Endereço:</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua, Av., Estrada, etc.">
                            </div>

                            <div class="mb-3">
                                <label for="bairro" class="form-label">Bairro:</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Nome do Bairro">
                            </div>

                            <div class="mb-3">
                                <label for="numero" class="form-label">Número:</label>
                                <input type="text" class="form-control" id="numero" name="numero" placeholder="Número da Residência">
                            </div>
                        </div>


                        <div class="mb-3">
        <label for="forma-pagamento" class="form-label">Forma de Pagamento:</label>
        <select class="form-select" id="forma-pagamento" name="forma-pagamento" required onchange="mostrarCamposExtras()">
            <option value="Dinheiro">Dinheiro</option>
            <option value="Cartão">Cartão</option>
            <option value="PIX">Pix</option>
        </select>
    </div>

    <div id="campos-extras"></div>
    <script>
        function mostrarCamposExtras() {
            var formaPagamento = document.getElementById("forma-pagamento").value;
            var camposExtrasDiv = document.getElementById("campos-extras");

            // Limpar campos extras
            camposExtrasDiv.innerHTML = "";

            if (formaPagamento === "Dinheiro") {
                // Criar campo para "Precisa de troco?"
                var precisaTrocoLabel = document.createElement("label");
                precisaTrocoLabel.textContent = "Precisa de troco?";
                camposExtrasDiv.appendChild(precisaTrocoLabel);

                var precisaTrocoSelect = document.createElement("select");
                precisaTrocoSelect.classList.add("form-select");
                precisaTrocoSelect.name = "precisa-troco";
                precisaTrocoSelect.id = "precisa-troco";
                precisaTrocoSelect.addEventListener("change", mostrarOcultarTrocoParaQuanto);
                var opcaoSim = document.createElement("option");
                opcaoSim.textContent = "Sim";
                precisaTrocoSelect.appendChild(opcaoSim);
                var opcaoNao = document.createElement("option");
                opcaoNao.textContent = "Não";
                precisaTrocoSelect.appendChild(opcaoNao);

                camposExtrasDiv.appendChild(precisaTrocoSelect);

                // Criar campo para "Troco para quanto?"
                var trocoParaQuantoLabel = document.createElement("label");
                trocoParaQuantoLabel.textContent = "Troco para quanto?";
                trocoParaQuantoLabel.id = "troco-para-quanto-label";
                camposExtrasDiv.appendChild(trocoParaQuantoLabel);

                var trocoParaQuantoInput = document.createElement("input");
                trocoParaQuantoInput.classList.add("form-control");
                trocoParaQuantoInput.type = "text";
                trocoParaQuantoInput.name = "troco-para-quanto";
                trocoParaQuantoInput.id = "troco-para-quanto-input";
                camposExtrasDiv.appendChild(trocoParaQuantoInput);

                // Adicionar a máscara de real ao campo "Troco para quanto?"
                $("#troco-para-quanto-input").mask("R$ 000,00", { reverse: true });
            }
        }

        function mostrarOcultarTrocoParaQuanto() {
            var precisaTrocoSelect = document.getElementById("precisa-troco");
            var trocoParaQuantoLabel = document.getElementById("troco-para-quanto-label");
            var trocoParaQuantoInput = document.getElementById("troco-para-quanto-input");

            if (precisaTrocoSelect.value === "Sim") {
                trocoParaQuantoLabel.style.display = "block";
                trocoParaQuantoInput.style.display = "block";
            } else {
                trocoParaQuantoLabel.style.display = "none";
                trocoParaQuantoInput.style.display = "none";
            }
        }

        // Chame a função inicialmente para garantir que os campos extras sejam exibidos corretamente ao carregar a página
        mostrarCamposExtras();
    </script>
                        <div id="itensCarrinho">
                            <!-- Campos dos itens do carrinho serão adicionados aqui dinamicamente -->
                        </div>
                        <input type="hidden" id="totalItens" name="totalItens" value="0">



                        <div class="mb-3">
                            <label for="observacoes" class="form-label">Observações:</label>
                            <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Quaisquer observações adicionais..."></textarea>
                        </div>


                        <div class="divider-title"></div>


                        <button type="submit" class="btn btn-edit-finish btn-block">Finalizar Pedido</button>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            carregarItensDoCarrinho();

            $("#formPedido").submit(function(event) {
                $("#carrinhoItensInput").val(JSON.stringify(localStorage.getItem('carrinhoItens') || []));
                adicionarCamposItensAoFormulario();
                localStorage.removeItem('carrinhoItens');
            });

            function adicionarCamposItensAoFormulario() {
                var carrinhoItensSalvos = JSON.parse(localStorage.getItem('carrinhoItens')) || [];
                $("#itensCarrinho").empty();
                $("#totalItens").val(carrinhoItensSalvos.length);
                carrinhoItensSalvos.forEach(function(carrinhoItem, index) {
                    var campoItem = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "item_" + index)
                        .val(JSON.stringify(carrinhoItem));
                    $("#itensCarrinho").append(campoItem);
                });
            }

            function carregarItensDoCarrinho() {
                var carrinhoItensSalvos = localStorage.getItem('carrinhoItens') || [];
                var valorFinal = 0;
                if (typeof carrinhoItensSalvos === 'string') {
                    carrinhoItensSalvos = JSON.parse(carrinhoItensSalvos);
                }
                if (carrinhoItensSalvos.length > 0) {
                    $("#carrinhoCheckout").empty();
                    carrinhoItensSalvos.forEach(function(carrinhoItem, index) {
                        var itemHtml = "<h6 class='card-title'>" + carrinhoItem.itemQuantity + "x " + carrinhoItem.itemName + " - " + carrinhoItem.itemSize + ", (0" + carrinhoItem.itemQuantity + (carrinhoItem.itemQuantity > 1 ? " Unidades" : " Unidade") + ")</h6>";
                        if (carrinhoItem.itemComplementos) {
                            itemHtml += "<div class='card-text text-carrinho'>" + carrinhoItem.itemComplementos + "</div>";
                        }
                        if (carrinhoItem.itemObservation) {
                            itemHtml += "<p class='card-text'><small class='text-muted'>Observação: " + carrinhoItem.itemObservation + "</small></p>";
                        }
                        itemHtml += "<p class='card-text'><strong>R$ " + (carrinhoItem.itemPrice).toFixed(2) + "</strong></p>";
                        itemHtml += "<button class='btn-remover btn-cart ms-auto' type='button' data-item-id='" + carrinhoItem.itemID + "'>Remover</button>";
                        itemHtml += "<hr>";
                        valorFinal += carrinhoItem.itemPrice;
                        $("#carrinhoCheckout").append(itemHtml);
                    });
                    $("#carrinhoCheckout").on("click", ".btn-remover", function() {
                        var itemID = $(this).data("item-id");
                        removerItemDoCarrinho(itemID);
                    });

                    function removerItemDoCarrinho(itemID) {
                        var carrinhoItensSalvos = JSON.parse(localStorage.getItem('carrinhoItens')) || [];
                        var itensAtualizados = carrinhoItensSalvos.filter(function(item) {
                            return item.itemID !== itemID;
                        });
                        localStorage.setItem('carrinhoItens', JSON.stringify(itensAtualizados));
                        carregarItensDoCarrinho(); // Recarregar itens do carrinho
                    }

                } else {
                    $("#carrinhoCheckout").html("<p>O carrinho está vazio.</p>");
                }
                $("#valorFinalSpan").text("R$ " + valorFinal.toFixed(2));
            }

            function removerItemDoCarrinho(itemID) {
                // Implemente a lógica de remoção aqui
                // Lembre-se de atualizar o carrinho e recalcular o total após a remoção
            }
        });
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obter o elemento select
            var metodoEntregaSelect = document.getElementById('metodo-entrega');

            // Obter o elemento div que contém os campos de endereço
            var enderecoCamposDiv = document.getElementById('endereco-campos');

            // Adicionar um ouvinte de evento de mudança ao select
            metodoEntregaSelect.addEventListener('change', function() {
                // Verificar se o valor selecionado é "delivery"
                if (metodoEntregaSelect.value === 'Entrega') {
                    // Se for "delivery", mostrar os campos de endereço
                    enderecoCamposDiv.style.display = 'block';
                } else {
                    // Se não for "delivery", ocultar os campos de endereço
                    enderecoCamposDiv.style.display = 'none';
                }
            });
        });
    </script>


    <?php include_once "../includes/footer.php";  ?>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>