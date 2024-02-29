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


    <?php include_once"functions/includes/atalhos.php"; ?>


      <div class="br-pagebody">
        <div class="br-section-wrapper">

    <h4 class="tx-gray-800 mg-b-5">Insira o novo item:</h4>

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
echo '<select class="form-control" id="coluna" name="coluna">';

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
  <input type="text" class="form-control" id="nomeItem" name="nomeItem" placeholder="Digite o nome do item">
</div>


<div class="form-group">
        <label for="imagemItem">Imagem do Item:</label>
        <input type="file" class="form-control" id="imagemItem" name="imagemItem">
    </div>

<div class="row">
    <div class="col-md-2">
    <div class="form-group">
  <label for="valorItem">Valor:</label>
  <input type="number" step="0.01" class="form-control" id="valorItem" name="valorItem" placeholder="Digite o valor do item">
</div>
</div>

<div class="col">
<div class="alert alert-danger mt-3" role="alert">
            <i class="fa-solid fa-circle-info"></i> <strong>| Caso o produto apresente diversos valores, por favor, deixe o campo em branco e insira o respectivo valor na seção de "Tamanhos Múltiplos" ou "Medidas Múltiplas".
            </strong></div>
            </div>
            </div>


            <!--
<div class="card mb-4 mt-4">
  <div class="card-body">
<div class="form-group">
<div class="form-check">
<label for="temPromocao"><strong>Item Promocional?</strong></label>
  <select class="form-select" id="temPromocao" name="temPromocao" onchange="toggleCamposPromocao()">
    <option value="0">Não</option>
    <option value="1">Sim</option>

  </select>



    <div class="alert alert-secondary mt-3" role="alert">
    <i class="fa-solid fa-circle-info"></i> | Marque o campo a cima se o item está em promoção.
</div>

  </div>
  <div class="form-group mt-3" id="camposPromocao" style="display: none;">
    <label for="valorPromocao">Valor na Promoção:</label>
    <input type="text" class="form-control" id="valorPromocao" name="valorPromocao" placeholder="Digite o valor na promoção">

    <label for="tempoPromocao">Tempo de Promoção:</label>
    <div class="input-group">
      <input type="number" class="form-control" id="tempoPromocao" name="tempoPromocao" placeholder="Digite o tempo de promoção">
      <select class="form-control" id="unidadeTempoPromocao" name="unidadeTempoPromocao">
  <option value="">Selecione a unidade de tempo</option>
  <option value="dias">Dias</option>
  <option value="horas">Horas</option>
  <option value="semanas">Semanas</option>
  <option value="meses">Meses</option>
</select>

    </div>
  </div>
</div>

</div>
</div>
-->

<div class="form-group">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
  <?php
session_start();
include_once "config/conection.php";

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login/login.php");
    exit();
}

// Recupere o panel_id do usuário do banco de dados
$username = $_SESSION["username"];
$sql = "SELECT panel_id FROM usuarios WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $panel_id = $row["panel_id"];

    // Busque os complementos associados ao panel_id
    $sqlComplementos = "SELECT nome_complemento FROM complementos WHERE panel_id = '$panel_id'";
    $resultComplementos = $conn->query($sqlComplementos);

    if ($resultComplementos->num_rows > 0) {
        echo '<h4 class="tx-gray-800 mg-b-5">Complementos do Item:</h4>';

        echo '<div class="alert alert-info mt-3" role="alert">';
        echo ' <i class="fa-solid fa-circle-info"></i> | Esses complementos acompanham o item.';
        echo '</div>';

        echo '<div class="form-check">';
        echo '<input class="form-check-input" type="checkbox" value="opcao0" id="checkOpcao0" onclick="toggleCheckboxes(this)">';
        echo '<label class="form-check-label" for="checkOpcao0">Selecionar Todos</label>';
        echo '</div>';

        while ($complemento = $resultComplementos->fetch_assoc()) {
          $nomeComplemento = $complemento["nome_complemento"];
          $idCheckbox = "check" . str_replace(" ", "", $nomeComplemento);
          echo '<div class="form-check">';
          echo "<input class='form-check-input' type='checkbox' value='$nomeComplemento' id='$idCheckbox' name='complementos[]'>";
          echo "<label class='form-check-label' for='$idCheckbox'>$nomeComplemento</label>";
          echo '</div>';
      }
      

    } else {
        echo 'Nenhum complemento encontrado.';
    }
} else {
    echo "Erro ao obter o panel_id do usuário.";
}
?>

<script>
    function toggleCheckboxes(selectAllCheckbox) {
        var checkboxes = selectAllCheckbox.parentNode.parentNode.querySelectorAll('.form-check-input');

        checkboxes.forEach(function (checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }

    function checkSelectAll(panel_id) {
        var checkboxes = document.querySelectorAll('.form-check-input');
        var selectAllCheckbox = document.getElementById('checkOpcao0');
        var allChecked = true;

        checkboxes.forEach(function (checkbox) {
            if (checkbox.getAttribute('panel_id') === panel_id && !checkbox.checked) {
                allChecked = false;
            }
        });

        selectAllCheckbox.checked = allChecked;
    }
</script>
    </div>

    </div>
            </div>

    <div class="col-md-6">
            <div class="card">
              <div class="card-body">
            <?php
    include_once "config/conection.php";
    
    // Verifique se o usuário está autenticado
    if (!isset($_SESSION["username"])) {
        header("Location: login/login.php");
        exit();
    }
    
    // Recupere o panel_id do usuário do banco de dados
    $username = $_SESSION["username"];
    $sql = "SELECT panel_id FROM usuarios WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $panel_id = $row["panel_id"];
    
        // Busque os complementos associados ao panel_id
        $sqlComplementos = "SELECT nome_complemento, valor FROM complementos_adicionais WHERE panel_id = '$panel_id'";
        $resultComplementos = $conn->query($sqlComplementos);
        
        if ($resultComplementos->num_rows > 0) {
            echo '<h4 class="tx-gray-800 mg-b-5">Complementos Adicionais do Item:</h4>';

            
            echo '<div class="alert alert-info mt-3" role="alert">';
            echo ' <i class="fa-solid fa-circle-info"></i> | Esses extras podem ser incluídos ao solicitar o item.';
            echo '</div>';

            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" value="opcao0" id="checkOpcao0Adicionais" onclick="toggleCheckboxes(this)">';
            echo '<label class="form-check-label" for="checkOpcao0Adicionais">Selecionar Todos</label>';
            echo '</div>';
        
// Enquanto houver complementos adicionais
while ($complemento = $resultComplementos->fetch_assoc()) {
    $valor = $complemento["valor"];
    $nomeComplemento = $complemento["nome_complemento"];
    $idCheckbox = "check" . str_replace(" ", "", $nomeComplemento);
    
    echo '<div class="form-check">';
    echo "<input class='form-check-input' type='checkbox' value='$nomeComplemento|$valor' id='$idCheckbox' onclick='checkSelectAllAdicionais(\"$panel_id\")'>";
    echo "<label class='form-check-label' for='$idCheckbox'>$nomeComplemento | $valor R$</label>";
    echo '</div>';
    
    // Adicione campos de input separados para o nome e valor de cada complemento adicional
    echo "<input type='hidden' name='complementos_adicionais_nome[]' value='$nomeComplemento' id='hidden_nome_$idCheckbox'>";
    echo "<input type='hidden' name='complementos_adicionais_valor[]' value='$valor' id='hidden_valor_$idCheckbox'>";
}

            
            
        
        
    
        } else {
            echo 'Nenhum complemento adicional encontrado.';
        }
    } else {
        echo "Erro ao obter o panel_id do usuário.";
    }
    ?>
    
    <script>
        function toggleCheckboxes(selectAllCheckbox) {
            var checkboxes = selectAllCheckbox.parentNode.parentNode.querySelectorAll('.form-check-input');
    
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }
    
        function checkSelectAllAdicionais(panel_id) {
    var checkboxes = document.querySelectorAll('.form-check-input');
    var complementosAdicionais = [];

    checkboxes.forEach(function (checkbox) {
        if (checkbox.getAttribute('panel_id') === panel_id && checkbox.checked) {
            complementosAdicionais.push(checkbox.value);
        }
    });

    // Atualize os campos de input ocultos com os complementos adicionais selecionados
    complementosAdicionais.forEach(function (complemento) {
        var [nomeComplemento, valorComplemento] = complemento.split('|');
        document.getElementById('hidden_nome_' + nomeComplemento).value = nomeComplemento;
        document.getElementById('hidden_valor_' + nomeComplemento).value = valorComplemento;
    });

    var selectAllCheckbox = document.getElementById('checkOpcao0Adicionais');
    selectAllCheckbox.checked = complementosAdicionais.length === checkboxes.length;
}


    </script>
    
    

        </div>
            </div>

    </div>

</div>

<script>
  function toggleCamposPromocao() {
    var camposPromocao = document.getElementById('camposPromocao');
    camposPromocao.style.display = camposPromocao.style.display === 'none' ? 'block' : 'none';
  }
</script>



    <hr>

    <div class="row">
    <div class="col-md-6">
    <div class="card">
        <div class="card-body">
    <h4 class="tx-gray-800 mg-b-5">Tamanhos:</h4>

    <div class="alert alert-info mt-3" role="alert">
        <i class="fa-solid fa-circle-info"></i> | Ao selecionar a opção "Tamanhos Múltiplos", você tem a possibilidade de incluir vários tamanhos, cada um com valores distintos, para o mesmo item adicionado.
    </div>
    
        <?php
        session_start();
        include_once "config/conection.php";

        // Verifique se o usuário está autenticado
        if (!isset($_SESSION["username"])) {
            header("Location: login/login.php");
            exit();
        }

        // Recupere o panel_id do usuário do banco de dados
        $username = $_SESSION["username"];
        $sqlPanel = "SELECT panel_id FROM usuarios WHERE username = '$username'";
        $resultPanel = $conn->query($sqlPanel);

        if ($resultPanel->num_rows > 0) {
            $rowPanel = $resultPanel->fetch_assoc();
            $panel_id = $rowPanel["panel_id"];

            // Busque os tamanhos associados ao panel_id
            $sqlTamanhos = "SELECT nome_tamanho FROM tamanhos WHERE panel_id = '$panel_id'";
            $resultTamanhos = $conn->query($sqlTamanhos);
        } else {
            // Lidar com a situação em que o panel_id não foi encontrado
            echo "Erro ao obter o panel_id do usuário.";
            exit();
        }
        ?>

        

            <div id="tamanhoItem">
            <label for="tamanhoItem" id="tamanhoItem">Tamanho do Item:</label>
            <select class="form-control" id="tamanhoItem" name="tamanhoItem" onchange="toggleTamanhoField()">
                <option value="">Sem Tamanho</option>
                <?php
                // Exibir as opções de tamanhos
                while ($rowTamanho = $resultTamanhos->fetch_assoc()) {
                    $nomeTamanho = $rowTamanho["nome_tamanho"];
                    echo "<option value='$nomeTamanho'>$nomeTamanho</option>";
                }
                ?>
            </select>
            </div>




    <div class="" id="valor_tamanho_field" style="display: none;">
        <label for="valor_tamanho">Valor do Tamanho:</label>
        <input type="text" class="form-control" id="valor_tamanho" name="valor_tamanho">
    </div>

    <input type="hidden" id="tamanhos_selecionados" name="tamanhos_selecionados" value="">

    <div id="tamanhos_field" class="mt-4">
        <label for="tamanhos_multiplas">Tamanhos Múltiplos?</label>
        <input type="checkbox" id="tamanhos_multiplas" name="tamanhos_multiplas" onchange="toggleTamanhoField()">
    </div>
    <script>
function toggleTamanhoField() {
    var tamanhoMultiplasCheckbox = document.getElementById("tamanhos_multiplas");
    var valorTamanhoField = document.getElementById("valor_tamanho_field");
    var tamanhosField = document.getElementById("tamanhos_field");
    var tamanhoItem = document.getElementById("tamanhoItem");

    // Se a caixa de seleção de tamanhos múltiplos estiver marcada
    if (tamanhoMultiplasCheckbox.checked) {
        valorTamanhoField.style.display = "none";
        tamanhoItem.style.display = "none";

        // Exibe o checkbox de tamanhos múltiplos
        tamanhosField.innerHTML = '<label for="tamanhos_multiplas">Tamanhos Múltiplos?</label>' +
            '<input type="checkbox" id="tamanhos_multiplas" name="tamanhos_multiplas" checked="checked" onchange="toggleTamanhoField()">';

        // Cria um contêiner para os checkboxes
        var checkboxesContainer = document.createElement("div");

        // Busca todos os tamanhos disponíveis no BD e cria checkboxes para cada um
        <?php
        $resultTamanhos = $conn->query($sqlTamanhos);
        while ($rowTamanho = $resultTamanhos->fetch_assoc()) {
            $nomeTamanho = $rowTamanho["nome_tamanho"];
            echo "var checkbox = document.createElement('label');
                  checkbox.innerHTML = '<input type=\"checkbox\" class=\"tamanho_checkbox\" name=\"tamanhos[]\" value=\"$nomeTamanho\"> $nomeTamanho';
                  checkboxesContainer.appendChild(checkbox);";
        }
        ?>

        // Adiciona o contêiner ao tamanhosField
        tamanhosField.appendChild(checkboxesContainer);

        // Adiciona um ouvinte de eventos para as checkboxes de tamanhos
        var tamanhoCheckboxes = document.getElementsByClassName("tamanho_checkbox");
        for (var i = 0; i < tamanhoCheckboxes.length; i++) {
            tamanhoCheckboxes[i].addEventListener("change", updateValorTamanhoField);
        }
    } else {
        // Restaura o campo "Tamanho do Item"
        tamanhosField.innerHTML = '<label for="tamanhos_multiplas">Tamanhos Múltiplos?</label>' +
            '<input type="checkbox" id="tamanhos_multiplas" name="tamanhos_multiplas" onchange="toggleTamanhoField()">';

        // Exibe o campo "Tamanho do Item" e oculta o campo "Valor do Tamanho"
        tamanhoItem.style.display = "block";
        valorTamanhoField.style.display = "none";
    }

    // Atualiza o campo "Valor do Tamanho" inicialmente
    updateValorTamanhoField();
}

function updateValorTamanhoField() {
    // Atualiza o campo "Valor do Tamanho" com base nas checkboxes de tamanhos selecionados
    var tamanhoCheckboxes = document.getElementsByClassName("tamanho_checkbox");
    var valorTamanhoField = document.getElementById("valor_tamanho_field");

    // Limpa o conteúdo atual de valorTamanhoField
    valorTamanhoField.innerHTML = "";

    var selectedTamanhos = [];
    for (var i = 0; i < tamanhoCheckboxes.length; i++) {
        if (tamanhoCheckboxes[i].checked) {
            selectedTamanhos.push(tamanhoCheckboxes[i].value);

            // Cria um campo de entrada para cada tamanho selecionado
            valorTamanhoField.innerHTML += '<label for="valor_' + tamanhoCheckboxes[i].value + '">Valor para ' + tamanhoCheckboxes[i].value + ':</label>' +
                '<input type="text" class="form-control" id="valor_' + tamanhoCheckboxes[i].value + '" name="valor_' + tamanhoCheckboxes[i].value + '"><br>';
        }
    }

    // Se houver tamanhos selecionados, exiba o campo "Valor do Tamanho", caso contrário, oculte-o
    if (selectedTamanhos.length > 0) {
        valorTamanhoField.style.display = "block";
    } else {
        valorTamanhoField.style.display = "none";
    }
}

</script>

</div>
</div>
</div>


<?php
session_start();
include_once "config/conection.php";

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login/login.php");
    exit();
}

// Recupere o panel_id do usuário do banco de dados
$username = $_SESSION["username"];
$sqlPanel = "SELECT panel_id FROM usuarios WHERE username = '$username'";
$resultPanel = $conn->query($sqlPanel);

if ($resultPanel->num_rows > 0) {
    $rowPanel = $resultPanel->fetch_assoc();
    $panel_id = $rowPanel["panel_id"];

    // Busque as unidades de medida associadas ao panel_id
    $sqlUnidades = "SELECT nome_medida FROM medidas WHERE panel_id = '$panel_id'";
    $resultUnidades = $conn->query($sqlUnidades);
} else {
    // Lidar com a situação em que o panel_id não foi encontrado
    echo "Erro ao obter o panel_id do usuário.";
    exit();
}
?>
<div class="col-md-6">
<div class="card">
<div class="card-body">
<h4 class="tx-gray-800 mb-3">Medidas:</h4>


<div class="alert alert-info mt-3" role="alert">
            <i class="fa-solid fa-circle-info"></i> | Ao selecionar a opção "Medidas Múltiplas", você tem a possibilidade de incluir diversos tamanhos, cada um com valores distintos, para o mesmo item adicionado.
            </div>

<div id="unidades_field">
    <label for="unidade">Unidade de Medida Única:</label>
    <select class="form-control" id="unidade" name="unidade">
        <option value="">Sem Unidade</option>
        <?php
        // Exibir as opções de unidades de medida
        while ($rowUnidade = $resultUnidades->fetch_assoc()) {
            $nomeMedida = $rowUnidade["nome_medida"];
            echo "<option value='$nomeMedida'>$nomeMedida</option>";
        }
        ?>
    </select>
</div>

    
<div class="mt-4">
    <label for="medida_multipla">Medidas múltiplas? </label>
    <input type="checkbox" id="medida_multipla" name="medida_multipla" onchange="toggleMedidaField()">
</div>


<div class="" id="valor_medida_field" style="display: none;">
    <label for="valor_medida">Valor da Medida:</label>
    <input type="text" class="form-control" id="valor_medida" name="valor_medida">
</div>

<script>
function toggleMedidaField() {
    var medidaMultiplaCheckbox = document.getElementById("medida_multipla");
    var valorMedidaField = document.getElementById("valor_medida_field");
    var unidadesField = document.getElementById("unidades_field");

    // Se a caixa de seleção de medida múltipla estiver marcada
    if (medidaMultiplaCheckbox.checked) {
        valorMedidaField.style.display = "none";

        // Limpa o conteúdo atual de unidadesField
        unidadesField.innerHTML = "";

        // Busca todas as medidas disponíveis no BD e cria checkboxes para cada uma
        <?php
        $resultUnidades = $conn->query($sqlUnidades);
        while ($rowUnidade = $resultUnidades->fetch_assoc()) {
            $nomeMedida = $rowUnidade["nome_medida"];
            echo "unidadesField.innerHTML += '<label><input type=\"checkbox\" class=\"medida_checkbox\" name=\"medidas[]\" value=\"$nomeMedida\"> $nomeMedida</label><br>';";
        }
        ?>

        // Adiciona um ouvinte de eventos para as checkboxes de medidas
        var medidaCheckboxes = document.getElementsByClassName("medida_checkbox");
        for (var i = 0; i < medidaCheckboxes.length; i++) {
            medidaCheckboxes[i].addEventListener("change", updateValorMedidaField);
        }
    } else {
        // Restaura o campo "Unidade de Medida"
        unidadesField.innerHTML = '<label for="unidade">Unidade de Medida Única:</label>' +
                                  '<select class="form-control" id="unidade" name="unidade">' +
                                  '<option value="">Sem Unidade</option>' +
                                  <?php
                                  // Exibir as opções de unidades de medida
                                  $resultUnidades = $conn->query($sqlUnidades);
                                  while ($rowUnidade = $resultUnidades->fetch_assoc()) {
                                      $nomeMedida = $rowUnidade["nome_medida"];
                                      echo "'<option value=\"$nomeMedida\">$nomeMedida</option>' +";
                                  }
                                  ?>
                                  '</select>';

        // Exibe o campo "Unidade de Medida" e oculta o campo "Valor da Medida"
        unidadesField.style.display = "block";
        valorMedidaField.style.display = "none";
    }

    // Atualiza o campo "Valor da Medida" inicialmente
    updateValorMedidaField();
}

function updateValorMedidaField() {
    // Atualiza o campo "Valor da Medida" com base nas checkboxes de medidas selecionadas
    var medidaCheckboxes = document.getElementsByClassName("medida_checkbox");
    var valorMedidaField = document.getElementById("valor_medida_field");

    // Limpa o conteúdo atual de valorMedidaField
    valorMedidaField.innerHTML = "";

    var selectedMedidas = [];
    for (var i = 0; i < medidaCheckboxes.length; i++) {
        if (medidaCheckboxes[i].checked) {
            selectedMedidas.push(medidaCheckboxes[i].value);

            // Cria um campo de entrada para cada medida selecionada
            valorMedidaField.innerHTML += '<label for="valor_' + medidaCheckboxes[i].value + '">Valor para ' + medidaCheckboxes[i].value + ':</label>' +
                                          '<input type="text" class="form-control" id="valor_' + medidaCheckboxes[i].value + '" name="valor_' + medidaCheckboxes[i].value + '"><br>';
        }
    }

    // Se houver medidas selecionadas, exiba o campo "Valor da Medida", caso contrário, oculte-o
    if (selectedMedidas.length > 0) {
        valorMedidaField.style.display = "block";
    } else {
        valorMedidaField.style.display = "none";
    }
}

</script>


</div>
</div>
</div>

</div>
  </div>

  <hr>
  <div class="d-flex align-items-center justify-content-center">
    <button type="submit" class="btn btn-warning">Adicionar Item</button>
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
