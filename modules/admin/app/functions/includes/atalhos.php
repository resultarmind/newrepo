<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <div class="br-section-wrapper2">
          
        <div class="row justify-content-center">
  
  <div class="mr-2">
            <button class="btn btn-LIGHT pd-x-30 pd-y-15 tx-uppercase tx-bold tx-spacing-3 tx-12" data-toggle="modal" data-target="#myModalComplemento">ADICIONAR COMPLEMENTO <i class="fa-regular fa-share-from-square"></i></button>

</div>

<!-- Modal para Complemento -->
<div class="modal fade" id="myModalComplemento" tabindex="-1" role="dialog" aria-labelledby="myModalLabelComplemento">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabelComplemento">Adicionar Complemento:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formComplemento1" action="functions/salvar_complemento.php" method="post">
                    <div class="form-group">
                        <label for="novoComplemento1">Novo Complemento:</label>
                        <input type="text" class="form-control" id="novoComplemento1" name="novoComplemento" placeholder="Digite o nome do complemento">
                    </div>
                    <button type="button" class="btn btn-success" onclick="enviarComplemento('formComplemento1')">Adicionar Complemento</button>
                    <a href="view_complementos.php" class="btn btn-info">Ver/Editar Complementos</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function enviarComplemento(formId) {
        // Encontrar o formulário com o ID especificado e enviá-lo
        document.getElementById(formId).submit();
    }
</script>



<div class="mr-2">
            <button class="btn btn-LIGHT pd-x-30 pd-y-15 tx-uppercase tx-bold tx-spacing-3 tx-12" data-toggle="modal" data-target="#myModalMedida">ADICIONAR UNIDADE DE MEDIDA <i class="fa-regular fa-share-from-square"></i></button>

</div>

<!-- Modal para Unidade de Medida -->
<div class="modal fade" id="myModalMedida" tabindex="-1" role="dialog" aria-labelledby="myModalLabelMedida">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabelMedida">Adicionar Unidade de Medida:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMedida" action="functions/processar_medida.php" method="post">
                    <div class="form-group">
                        <label for="novaMedida">Nova Unidade de Medida:</label>
                        <input type="text" class="form-control" id="novaMedida" name="novaMedida" placeholder="Digite a medida (700ml..)">
                    </div>
                    <button type="button" class="btn btn-success" onclick="enviarFormularioMedida()">Adicionar Medida</button>
                    <a href="view_medidas.php" class="btn btn-info">Ver/Editar Medidas</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function enviarFormularioMedida() {
        // Encontrar o formulário com o ID formMedida e enviá-lo
        document.getElementById("formMedida").submit();
    }
</script>



    <div class="mr-2">
            <button class="btn btn-LIGHT pd-x-30 pd-y-15 tx-uppercase tx-bold tx-spacing-3 tx-12" data-toggle="modal" data-target="#myModal">ADICIONAR UNIDADE DE TAMANHO <i class="fa-regular fa-share-from-square"></i></button>

</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Adicionar Unidade de Tamanho:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="formTamanho" action="functions/processar_tamanho.php" method="post">
    <div class="form-group">
    <input type="hidden" name="pagina_anterior" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">

        <label for="novoTamanho">Nova Unidade de Tamanho:</label>
        <input type="text" class="form-control" id="novoTamanho" name="novoTamanho" placeholder="Digite o tamanho (Grande, pequeno..)">
        <input type="hidden" name="panel_id" value="<?php echo $panel_id; ?>">
    </div>
    <button type="button" class="btn btn-success" onclick="enviarFormularioTamanho()">Adicionar Tamanho</button>
    <a href="view_tamanhos.php" class="btn btn-info">Ver/Editar Tamanhos</a>
</form>

<script>
    function enviarFormularioTamanho() {
        var novoTamanhoInput = document.getElementById("novoTamanho");
        var novoTamanhoValue = novoTamanhoInput.value;

        // Verifica se o valor contém caracteres especiais ou espaços
        if (/[\[\]\(\)\s]/.test(novoTamanhoValue)) {
            alert("O campo 'Nova Unidade de Tamanho' não pode conter espaços, (, ), [, ou ]");
            return;
        }

        // Se não contiver caracteres especiais, envie o formulário
        document.getElementById("formTamanho").submit();
    }
</script>

            </div>
        </div>
    </div>
</div>



  <div class="mr-2">
            <button class="btn btn-LIGHT pd-x-30 pd-y-15 tx-uppercase tx-bold tx-spacing-3 tx-12" data-toggle="modal" data-target="#myModalComplementoAdicional">ADICIONAR COMPLEMENTO (ADICIONAL) <i class="fa-regular fa-share-from-square"></i></button>
</div>

<!-- Modal para Complemento Adicional -->
<!-- Modal para Complemento Adicional -->
<div class="modal fade" id="myModalComplementoAdicional" tabindex="-1" role="dialog" aria-labelledby="myModalLabelComplementoAdicional">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabelComplementoAdicional">Adicionar Complemento (Adicional):</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formComplemento2" action="functions/salvar_complemento_add.php" method="post">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="novoComplemento">Novo Complemento:</label>
                                <input type="text" class="form-control" id="novoComplemento" name="novoComplemento" placeholder="Digite o nome do complemento">
                            </div>
                            <div class="col">
                                <label for="valorComplementoAdd">Valor do Complemento:</label>
                                <input type="text" class="form-control" id="valorComplementoAdd" name="valorComplementoAdd" placeholder="Digite o valor do complemento" required>
                            </div>
                        </div>
                    </div>
                    <!-- Alterado o tipo do botão para type="button" -->
                    <button type="button" class="btn btn-success" onclick="enviarComplemento2('formComplemento2')">Adicionar Complemento</button>
                    <a href="view_complementos_adicionais.php" class="btn btn-info">Ver/Editar Complementos</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function enviarComplemento2(formId) {
        // Obtém o valor do campo valorComplementoAdd
        var valorComplementoAdd = document.getElementById('valorComplementoAdd').value;

        // Verifica se o campo está vazio ou não é um número válido
        if (valorComplementoAdd.trim() === '' || isNaN(parseFloat(valorComplementoAdd))) {
            // Exibe uma mensagem de erro
            alert('Por favor, insira um valor válido para o complemento.');
            return; // Impede o envio do formulário
        }

        // Se tudo estiver correto, envia o formulário
        document.getElementById(formId).submit();
    }
</script>




<div class="mr-2">
            <button class="btn btn-LIGHT pd-x-30 pd-y-15 tx-uppercase tx-bold tx-spacing-3 tx-12" data-toggle="modal" data-target="#myModalCategoria">CRIAR CATEGORIA <i class="fa-regular fa-share-from-square"></i></button>

</div>

<!-- Modal para Criação de Categoria -->
<div class="modal fade" id="myModalCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabelCategoria">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabelCategoria">Criar Nova Categoria</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="categoriaForm" action="functions/salvar_categoria.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="categoriaModal">Nome da Categoria:</label>
                            <input type="text" class="form-control" id="categoriaModal" name="categoria" placeholder="Digite o nome da categoria">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tamanhoModal">Tamanho da Coluna:</label>
                            <select class="form-control" id="tamanhoModal" name="tamanho">
                                <option value="1">1 Item</option>
                                <option value="2">2 Itens</option>
                                <option value="3">1 Fileira</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success" onclick="enviarFormulario()">Enviar</button>
                    <a href="view_categorias.php" class="btn btn-info">Ver/Editar Categorias</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function enviarFormulario() {
        // Encontrar o formulário com o ID categoriaForm e enviá-lo
        document.getElementById("categoriaForm").submit();
    }
</script>



  </div>
        </div>
      </div>
