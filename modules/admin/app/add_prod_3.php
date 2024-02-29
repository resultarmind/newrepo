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

    <form method="post" action="functions/processar_item_3.php" enctype="multipart/form-data">

<input type="hidden" name="panel_id" value="<?php echo $panel_id; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <div class="row align-items-center">
    <div class="col">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title">Escolha os complementos que acompanham o item:</h5>
<p><i class="fa-solid fa-caret-right"></i> Se o item não possui complementos, selecione a opção "Item Sem Complementos" e prossiga para a próxima etapa.</p>
<hr>
<p><i class="fa-solid fa-caret-right"></i> Se o item possui complementos, selecione "Item com Complementos" e escolha os complementos que o acompanharão.</p>
<p><i class="fa-regular fa-circle-right"></i> Antes de continuar, é necessário adicionar complementos. <a href="#" data-toggle="modal" data-target="#myModalComplemento">Clique aqui</a> para adicionar um novo complemento.</p>

              </div>
        </div>
    </div>
</div>
<div class="form-group mt-4">
    <label for="complementoOption">Escolha os complementos que acompanham o item:</label>
    <select class="form-control" id="complementoOption" name="complementoOption" required>
        <option value="no_value" selected disabled>Selecione uma opção</option>
        <option value="sem_complementos">Item Sem Complementos</option>
        <option value="com_complementos">Item Com Complementos</option>
    </select>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tipoItemSelect = document.getElementById("complementoOption");
        var valorItemGroup = document.getElementById("ocultar");

        // Ocultar a div 'ocultar' quando a página é carregada
        valorItemGroup.style.display = "none";

        tipoItemSelect.addEventListener("change", function() {
            if (tipoItemSelect.value === "com_complementos") {
                valorItemGroup.style.display = "block";
            } else {
                valorItemGroup.style.display = "none";
            }
        });
    });
</script>


<div class="ocultar" id="ocultar">
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
        echo '<h4 class="tx-gray-800 mg-b-5 mt-4">Complementos do Item:</h4>';
    

            // Campo de busca
    echo '<div class="form-group mb-3 mt-4 busca-complemento-container">';
    echo '<i class="fa-solid fa-magnifying-glass busca-complemento-icon"></i>';
    echo '<input type="text" class="form-control" id="buscaComplemento" placeholder="Buscar Complemento...">';
    echo '</div>';


        // Checkbox 'Selecionar Todos'
        echo '<div class="form-check mb-3 mt-4">';
        echo '<input class="form-check-input" type="checkbox" value="opcao0" id="checkOpcao0" onclick="toggleCheckboxes(this)">';
        echo '<label class="form-check-label" for="checkOpcao0"><strong>Selecionar Todos</strong></label>';
        echo '</div>';
    
        // Iniciando a primeira row
        echo '<div class="row">';
    
        $contador = 0;
        $maxPorColuna = 5;
    
        while ($complemento = $resultComplementos->fetch_assoc()) {
            if ($contador % $maxPorColuna == 0) {
                // Se atingir o limite, feche a coluna anterior e inicie uma nova
                if ($contador > 0) {
                    echo '</div>'; // Fechando a coluna anterior
                }
                // Iniciar nova coluna
                echo '<div class="col">';
            }
    
            $nomeComplemento = $complemento["nome_complemento"];
            $idCheckbox = "check" . str_replace(" ", "", $nomeComplemento);
            $idQuantidade = "quantidade" . str_replace(" ", "", $nomeComplemento);
        
            
// Dentro do loop while, atualize o código do card e do checkbox
echo '<div class="card mb-2" data-complemento="' . htmlspecialchars($nomeComplemento, ENT_QUOTES) . '">'; // Use o atributo 'data-complemento'
echo '<div class="card-body">';
echo '<div class="d-flex align-items-center">'; // Flexbox para alinhar elementos

// Checkbox para o complemento
echo "<div class='form-check flex-grow-1'>";
echo "<input class='form-check-input' type='checkbox' value='" . htmlspecialchars($nomeComplemento, ENT_QUOTES) . "' id='$idCheckbox' name='complementos[]'>";
echo "<label class='form-check-label mr-3' for='$idCheckbox'>| " . htmlspecialchars($nomeComplemento) . "</label>";
echo '</div>';

// Campo de entrada para a quantidade
echo "<input type='number' class='form-control' id='$idQuantidade' name='quantidade[" . htmlspecialchars($nomeComplemento, ENT_QUOTES) . "]' min='1' style='width: 70px;' disabled>";

echo '</div>'; // Fecha div d-flex
echo '</div>'; // Fecha div card-body
echo '</div>'; // Fecha div card

            
            $contador++;
            
    
            if ($contador % (4 * $maxPorColuna) == 0) {
                echo '</div>'; // Fechando a coluna atual
                echo '</div>'; // Fechando a row atual
                echo '<div class="row">'; // Iniciando uma nova row
            }
        }
    
        // Feche a última coluna e row abertas, se necessário
        echo '</div>'; // Fecha a última coluna
        echo '</div>'; // Fecha a última row
    } else {
        echo 'Nenhum complemento encontrado.';
    }
} else {
    echo "Erro ao obter o panel_id do usuário.";
}
?>

<script>

document.getElementById('buscaComplemento').addEventListener('keyup', function() {
        var busca = this.value.toLowerCase();
        var complementos = document.querySelectorAll('.form-check');

        complementos.forEach(function(complemento) {
            var nome = complemento.textContent.toLowerCase();
            if (nome.includes(busca)) {
                complemento.style.display = '';
            } else {
                complemento.style.display = 'none';
            }
        });
    });



    function toggleCheckboxes(selectAllCheckbox) {
    var checkboxes = document.querySelectorAll('.form-check-input:not(#checkOpcao0)'); // Seleciona todos os checkboxes exceto o 'Selecionar Todos'
    var labelSelectAll = document.querySelector('label[for="checkOpcao0"]'); // Seleciona a label da checkbox 'Selecionar Todos'

    checkboxes.forEach(function (checkbox) {
        checkbox.checked = selectAllCheckbox.checked;
        var quantidadeInputId = 'quantidade' + checkbox.id.substring(5); // Remove 'check' do id
        var quantidadeInput = document.getElementById(quantidadeInputId);

        if (selectAllCheckbox.checked) {
            quantidadeInput.disabled = false;
            quantidadeInput.value = '1';
        } else {
            quantidadeInput.disabled = true;
            quantidadeInput.value = '';
        }
    });

    // Altera o texto da label 'Selecionar Todos'
    if (selectAllCheckbox.checked) {
        labelSelectAll.textContent = 'Desmarcar Todos';
    } else {
        labelSelectAll.textContent = 'Selecionar Todos';
    }
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

    // Habilitar/desabilitar campos de quantidade com base no estado do checkbox
document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var quantidadeInputId = 'quantidade' + this.id.substring(5); // Remove 'check' do id
        var quantidadeInput = document.getElementById(quantidadeInputId);
        quantidadeInput.disabled = !this.checked;

        if (this.checked) {
            quantidadeInput.value = '1'; // Define o valor como 1 quando marcado
        } else {
            quantidadeInput.value = ''; // Limpa o valor quando desmarcado
        }
    });
});
</script>





</div>





    <hr>
  <div class="d-flex align-items-center justify-content-center">
  <button type="submit" class="btn btn-warning p-3"><strong class="mr-1">Prosseguir</strong> <i class="fa-solid fa-forward move-back-and-forth"></i></button>
</div>

  </form>

  </div>

  <style>

.busca-complemento-container {
    position: relative;
}

.busca-complemento-icon {
    position: absolute;
    left: 10px;
    top: 12px;
    color: #ccc;
}

#buscaComplemento {
    padding-left: 30px; /* Ajuste conforme necessário para alinhar o texto com o ícone */
}



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
