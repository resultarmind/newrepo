<div class="card">
          <div class="card-body">
            <form id="formMedida" action="functions/processar_medida.php" method="post">
              <h4 class="tx-gray-800 mg-b-5">Adicionar Unidade de Medida:</h4>
              <div class="form-group">
                <label for="novaMedida">Nova Unidade de Medida:</label>
                <input type="text" class="form-control" id="novaMedida" name="novaMedida" placeholder="Digite a medida (700ml..)">
              </div>
              <button type="button" class="btn btn-success" onclick="enviarFormularioMedida()">Adicionar Medida</button>
              <a href="view_medidas.php" class="btn btn-info">Ver/Editar Medidas</a>
            </form>
            <script>
              function enviarFormularioMedida() {
                // Encontrar o formulário com o ID categoriaForm e enviá-lo
                document.getElementById("formMedida").submit();
              }
            </script>
          </div>
        </div>