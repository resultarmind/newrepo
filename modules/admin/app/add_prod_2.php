<?php

session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login/login.php"); // Redirecione para a página de login se o usuário não estiver autenticado
    exit();
}


$panel_id = isset($_GET["panel_id"]) ? $_GET["panel_id"] : null;
$id = isset($_GET["id"]) ? $_GET["id"] : null;

if ($panel_id !== null && $id !== null) {
    // Use $panel_id e $id conforme necessário
} else {
    // Lide com a situação em que os parâmetros não foram passados corretamente
    echo "Parâmetros ausentes ou inválidos.";
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

      
    <h4 class="tx-gray-800 mg-b-5 mb-4">Continue a inserção do item:</h4>

    <form method="post" action="functions/processar_item_2.php" enctype="multipart/form-data">

<input type="hidden" name="panel_id" value="<?php echo $panel_id; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <div class="row align-items-center">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Escolha o Tipo de Item:</h5>
                <p><i class="fa-solid fa-caret-right"></i> Se o item é um produto único e não possui variações de medidas ou tamanhos, escolha (Item Simples).</p>
               <hr>
                <p><i class="fa-solid fa-caret-right"></i> Se o item está relacionado a uma medida específica e você deseja adicionar múltiplos valores para essa medida, ou valores simples escolha "Item com Medida".</p>
<p><i class="fa-regular fa-circle-right"></i> Antes de prosseguir, é necessário adicionar uma unidade de medida. <a href="#" data-toggle="modal" data-target="#myModalMedida">Clique aqui</a> para adicionar uma unidade de medida.</p>
<hr>

                <p><i class="fa-solid fa-caret-right"></i> Se o item está relacionado a um tamanho específico e você deseja adicionar múltiplos valores para esse tamanho, escolha (Item com Tamanho).</p>
                <p><i class="fa-regular fa-circle-right"></i> Antes de continuar, você precisa adicionar um tamanho. <a href="#" data-toggle="modal" data-target="#myModal">Clique aqui</a> para adicionar um tamanho.</p>

              </div>
        </div>
    </div>
</div>

<div class="form-group mt-3">
    <label for="tipoItem">Tipo de Item:</label>
    <select class="form-control" id="tipoItem" name="tipoItem" onchange="desmarcarCheckboxes(); reiniciarCampos();">
        <option selected>Selecione uma Opção</option>
        <option value="item_simples">Item Simples</option>
        <option value="item_com_medida">Item com Medida</option>
        <option value="item_com_tamanho">Item com Tamanho</option>
        <option value="bebida">Bebida</option>
    </select>
</div>

<script>
    function desmarcarCheckboxes() {
        // Obter todas as checkboxes da página
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        
        // Desmarcar todas as checkboxes
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = false;
        });
    }
</script>



<div class="form-group" id="valorItemGroup" style="display: none;">
    <label for="valorItem">Valor do Item:</label>
    <input type="text" class="form-control" id="valorItem" name="valorItem">
</div>


<!-- TAMANHOS -->
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

    // Busque as unidades de tamanho associadas ao panel_id
    $sqlTamanhos = "SELECT nome_tamanho FROM tamanhos WHERE panel_id = '$panel_id'";
    $resultTamanhos = $conn->query($sqlTamanhos);
} else {
    // Lidar com a situação em que o panel_id não foi encontrado
    echo "Erro ao obter o panel_id do usuário.";
    exit();
}
?>

<div id="tamanho_field" style="display: none;">
    <label for="tamanho">Tamanho Único:</label>
    <select class="form-control" id="tamanho" name="tamanho">
        <option value="">Selecione um tamanho.</option>
        <?php
        // Exibir as opções de tamanhos
        while ($rowTamanho = $resultTamanhos->fetch_assoc()) {
            $nomeTamanho = $rowTamanho["nome_tamanho"];
            echo "<option value='$nomeTamanho'>$nomeTamanho</option>";
        }
        ?>
    </select>
</div>

<div class="mt-3" id="valor_tamanho_unica" style="display: none;">
    <label for="valor_tamanho_unica">Valor do Tamanho:</label>
    <input type="text" class="form-control" id="valor_tamanho_unica" name="valor_tamanho_unica">
</div>

    
<div class="mt-4" id="multiplos_tamanhos" style="display: none;">
    <label for="tamanho_multipla">Tamanhos múltiplos? </label>
    <input type="checkbox" id="tamanho_multipla" name="tamanho_multipla" onchange="toggleTamanhoField()">
</div>



<div class="" id="valor_tamanho_field" style="display: none;">
    <label for="valor_tamanho">Valor do Tamanho:</label>
    <input type="text" class="form-control" id="valor_tamanho" name="valor_tamanho">
</div>

<script>
function toggleTamanhoField() {
    var tamanhoMultiplaCheckbox = document.getElementById("tamanho_multipla");
    var valorTamanhoField = document.getElementById("valor_tamanho_field");
    var valorTamanhoField2 = document.getElementById("valor_tamanho_unica");
    var unidadesField = document.getElementById("tamanho_field");

    // Se a caixa de seleção de tamanho múltiplo estiver marcada
    if (tamanhoMultiplaCheckbox.checked) {
        valorTamanhoField.style.display = "none";
        valorTamanhoField2.style.display = "none";

        // Limpa o conteúdo atual de unidadesField
        unidadesField.innerHTML = "";

        // Busca todos os tamanhos disponíveis no BD e cria checkboxes para cada um
        <?php
        $resultTamanhos = $conn->query($sqlTamanhos);
        while ($rowTamanho = $resultTamanhos->fetch_assoc()) {
            $nomeTamanho = $rowTamanho["nome_tamanho"];
            echo "unidadesField.innerHTML += '<label><input type=\"checkbox\" class=\"tamanho_checkbox\" name=\"tamanhos[]\" value=\"$nomeTamanho\"> $nomeTamanho</label><br>';";
        }
        ?>

        // Adiciona um ouvinte de eventos para as checkboxes de tamanhos
        var tamanhoCheckboxes = document.getElementsByClassName("tamanho_checkbox");
        for (var i = 0; i < tamanhoCheckboxes.length; i++) {
            tamanhoCheckboxes[i].addEventListener("change", updateValorTamanhoField);
        }
    } else {
        // Restaura o campo "Tamanho"
        unidadesField.innerHTML = '<label for="tamanho">Tamanho Único:</label>' +
                                  '<select class="form-control" id="tamanho" name="tamanho">' +
                                  '<option value="">Sem Tamanho</option>' +
                                  <?php
                                  // Exibir as opções de tamanhos
                                  $resultTamanhos = $conn->query($sqlTamanhos);
                                  while ($rowTamanho = $resultTamanhos->fetch_assoc()) {
                                      $nomeTamanho = $rowTamanho["nome_tamanho"];
                                      echo "'<option value=\"$nomeTamanho\">$nomeTamanho</option>' +";
                                  }
                                  ?>
                                  '</select>';

        // Exibe o campo "Tamanho" e oculta o campo "Valor do Tamanho"
        unidadesField.style.display = "block";
        valorTamanhoField.style.display = "none";
        valorTamanhoField2.style.display = "block";
    }

    // Atualiza o campo "Valor do Tamanho" inicialmente
    updateValorTamanhoField();
}

function updateValorTamanhoField() {
    // Atualiza o campo "Valor do Tamanho" com base nas checkboxes de tamanhos selecionados
    var tamanhoCheckboxes = document.getElementsByClassName("tamanho_checkbox");
    var valorTamanhoField = document.getElementById("valor_tamanho_field");
    var valorTamanhoField2 = document.getElementById("valor_tamanho_unica");

    // Limpa o conteúdo atual de valorTamanhoField
    valorTamanhoField.innerHTML = "";



    var selectedTamanhos = [];
for (var i = 0; i < tamanhoCheckboxes.length; i++) {
    if (tamanhoCheckboxes[i].checked) {
        selectedTamanhos.push(tamanhoCheckboxes[i].value);

        // Cria um campo de entrada para cada tamanho selecionado
        valorTamanhoField.innerHTML += '<label for="valor_' + tamanhoCheckboxes[i].value + '" id="label_' + tamanhoCheckboxes[i].value + '">Valor para ' + tamanhoCheckboxes[i].value + ':</label>' +
                                      '<input type="text" class="form-control tamanho-field" id="valor_' + tamanhoCheckboxes[i].value + '" name="valor_' + tamanhoCheckboxes[i].value + '"><br>';

    }
}

// Função para ocultar os campos de entrada e as labels associadas
function ocultarCamposTamanho() {
    var tamanhoFields = document.getElementsByClassName('tamanho-field');
    for (var i = 0; i < tamanhoFields.length; i++) {
        tamanhoFields[i].style.display = 'none'; // Oculta o campo de entrada
        // Obtém o id da label associada
        var labelId = tamanhoFields[i].id.replace('valor_', 'label_');
        var labelElement = document.getElementById(labelId);
        if (labelElement) {
            labelElement.style.display = 'none'; // Oculta a label associada
        }
    }
}


// Chamada da função ao trocar o valor do select
document.getElementById('tipoItem').addEventListener('change', function() {
    ocultarCamposTamanho();
});

    // Se houver tamanhos selecionados, exiba o campo "Valor do Tamanho", caso contrário, oculte-o
    if (tamanhoCheckboxes.length > 0) {
        valorTamanhoField.style.display = "block";
        valorTamanhoField2.style.display = "none";
    } else {
        valorTamanhoField.style.display = "block";
        valorTamanhoField2.style.display = "block";
    }
}
</script>



<!-- MEDIDAS -->
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

<div id="unidades_field" style="display: none;">
    <label for="unidade">Unidade de Medida Única:</label>
    <select class="form-control" id="unidade" name="unidade">
        <option value="">Selecione uma únidade de medida.</option>
        <?php
        // Exibir as opções de unidades de medida
        while ($rowUnidade = $resultUnidades->fetch_assoc()) {
            $nomeMedida = $rowUnidade["nome_medida"];
            echo "<option value='$nomeMedida'>$nomeMedida</option>";
        }
        ?>
    </select>
</div>

<div class="mt-3" id="valor_medida_unica" style="display: none;">
    <label for="valor_medida_unica">Valor da Medida:</label>
    <input type="text" class="form-control" id="valor_medida_unica" name="valor_medida_unica">
</div>

    
<div class="mt-4" id="multiplos_medidas" style="display: none;">
    <label for="medida_multipla">Medidas múltiplas? </label>
    <input type="checkbox" id="medida_multipla" name="medida_multipla" onchange="toggleMedidaField()">
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tipoItemSelect = document.getElementById("tipoItem");
        var valorItemGroup = document.getElementById("valor_medida_unica");
        var valorItemGroup2 = document.getElementById("unidades_field");
        var valorItemGroup3 = document.getElementById("multiplos_medidas");


        tipoItemSelect.addEventListener("change", function() {
            if (tipoItemSelect.value === "item_com_medida") {
                valorItemGroup.style.display = "block";
                valorItemGroup2.style.display = "block";
                valorItemGroup3.style.display = "block";

            } else {
                valorItemGroup.style.display = "none";
                valorItemGroup2.style.display = "none";
                valorItemGroup3.style.display = "none";
            }
        });
    });
</script>




<div class="" id="valor_medida_field" style="display: none;">
    <label for="valor_medida">Valor da Medida:</label>
    <input type="text" class="form-control" id="valor_medida" name="valor_medida">
</div>

<script>
function toggleMedidaField() {
    var medidaMultiplaCheckbox = document.getElementById("medida_multipla");
    var valorMedidaField = document.getElementById("valor_medida_field");
    var valorMedidaField2 = document.getElementById("valor_medida_unica");
    var unidadesField = document.getElementById("unidades_field");


    

    // Se a caixa de seleção de medida múltipla estiver marcada
    if (medidaMultiplaCheckbox.checked) {
        valorMedidaField.style.display = "none";
        valorMedidaField2.style.display = "none";

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
        valorMedidaField2.style.display = "block";

    }

    // Atualiza o campo "Valor da Medida" inicialmente
    updateValorMedidaField();
}

function updateValorMedidaField() {
    // Atualiza o campo "Valor da Medida" com base nas checkboxes de medidas selecionadas
    var medidaCheckboxes = document.getElementsByClassName("medida_checkbox");
    var valorMedidaField = document.getElementById("valor_medida_field");
    var valorMedidaField2 = document.getElementById("valor_medida_unica");

    // Limpa o conteúdo atual de valorMedidaField
    valorMedidaField.innerHTML = "";

    var selectedMedidas = [];
for (var i = 0; i < medidaCheckboxes.length; i++) {
    if (medidaCheckboxes[i].checked) {
        selectedMedidas.push(medidaCheckboxes[i].value);

        // Cria um campo de entrada para cada medida selecionada
        valorMedidaField.innerHTML += '<label for="valor_' + medidaCheckboxes[i].value + '" id="label_medida_' + medidaCheckboxes[i].value + '">Valor para ' + medidaCheckboxes[i].value + ':</label>' +
                                      '<input type="text" class="form-control medida-field" id="valor_' + medidaCheckboxes[i].value + '" name="valor_' + medidaCheckboxes[i].value + '"><br>';
    }
}

// Função para ocultar os campos de entrada e as labels associadas aos itens de medida
function ocultarCamposMedida() {
    var medidaFields = document.getElementsByClassName('medida-field');
    for (var i = 0; i < medidaFields.length; i++) {
        medidaFields[i].style.display = 'none'; // Oculta o campo de entrada
        // Obtém o id da label associada
        var labelId = medidaFields[i].id.replace('valor_', 'label_medida_');
        var labelElement = document.getElementById(labelId);
        if (labelElement) {
            labelElement.style.display = 'none'; // Oculta a label associada
        }
    }
}

// Chamada da função ao trocar o valor do select
document.getElementById('tipoItem').addEventListener('change', function() {
    ocultarCamposMedida();
});

    // Se houver medidas selecionadas, exiba o campo "Valor da Medida", caso contrário, oculte-o
    if (medidaCheckboxes.length > 0) {
        valorMedidaField.style.display = "block";
        valorMedidaField2.style.display = "none";


    } else {
        valorMedidaField.style.display = "none";
        valorMedidaField2.style.display = "block";

    }
}

</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tipoItemSelect = document.getElementById("tipoItem");
        var valorItemGroup = document.getElementById("valorItemGroup");

        tipoItemSelect.addEventListener("change", function() {
            if (tipoItemSelect.value === "item_simples") {
                valorItemGroup.style.display = "block";
            } else {
                valorItemGroup.style.display = "none";
            }
        });
    });
</script>



    <hr>
  <div class="d-flex align-items-center justify-content-center">
  <button type="submit" class="btn btn-warning p-3"><strong class="mr-1">Prosseguir</strong> <i class="fa-solid fa-forward move-back-and-forth"></i></button>
</div>

  </form>

  </div>

  <style>
@keyframes moveBackAndForth {
    0% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(5px); /* Altere a distância desejada */
    }
    100% {
        transform: translateX(0);
    }
}

.move-back-and-forth {
    animation: moveBackAndForth 2s linear infinite;
}

button{
    cursor: pointer;
}

  </style>





</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tipoItemSelect = document.getElementById("tipoItem");
        var valorItemGroup = document.getElementById("valor_tamanho_unica");
        var valorItemGroup2 = document.getElementById("tamanho_field");
        var valorItemGroup3 = document.getElementById("multiplos_tamanhos");

        tipoItemSelect.addEventListener("change", function() {
            if (tipoItemSelect.value === "item_com_tamanho") {
                valorItemGroup.style.display = "block";
                valorItemGroup2.style.display = "block";
                valorItemGroup3.style.display = "block";
            } else {
                valorItemGroup.style.display = "none";
                valorItemGroup2.style.display = "none";
                valorItemGroup3.style.display = "none";
            }
        });
    });
</script>


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
