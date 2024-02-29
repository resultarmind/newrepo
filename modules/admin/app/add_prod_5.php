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

    <form method="post" action="functions/processar_item_5.php" enctype="multipart/form-data">

<input type="hidden" name="panel_id" value="<?php echo $panel_id; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">




    <div class="row align-items-center">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Escolha as opções para a bebida:</h5>
                <p><i class="fa-solid fa-caret-right"></i> Selecione as opções desejadas para a bebida.</p>
                <hr>

                <div class="row">
                    <div class="col-md-6">
    <div id="opcao_gelado">
        <label>Este item pode ser Quente ou Gelado?:</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="gelado_e_quente" name="gelado_option" value="gelado_e_quente" checked>
            <label class="form-check-label" for="gelado_e_quente">Gelado e Quente</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="somente_gelado" name="gelado_option" value="somente_gelado">
            <label class="form-check-label" for="somente_gelado">Somente Gelado</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="somente_quente" name="gelado_option" value="somente_quente">
            <label class="form-check-label" for="somente_quente">Somente Quente</label>
        </div>
    </div>
</div>

<div class="col-md-6">
<div id="opcao_acucar">
    <label>Este item pode ser servido com:</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="sem_acucar" name="acucar_option[]" value="sem_acucar" checked>
        <label class="form-check-label" for="sem_acucar">Nenhuma das ações</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="com_acucar" name="acucar_option[]" value="com_acucar">
        <label class="form-check-label" for="com_acucar">Com opção de adicionar Açúcar ou não.</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="com_acucar_reduzido" name="acucar_option[]" value="com_acucar_reduzido">
        <label class="form-check-label" for="com_acucar_reduzido">Com opção de Açúcar Reduzido.</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="com_as_duas_opcoes" name="acucar_option[]" value="com_as_duas_opcoes">
        <label class="form-check-label" for="com_as_duas_opcoes">Com as duas Opções</label>
    </div>
</div>

<script>
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="acucar_option[]"]');
    const nenhumaAcaoCheckbox = document.getElementById('sem_acucar');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this === nenhumaAcaoCheckbox && this.checked) {
                // Se "Nenhuma das ações" for marcada, desmarcar todas as outras opções
                checkboxes.forEach(otherCheckbox => {
                    if (otherCheckbox !== nenhumaAcaoCheckbox) {
                        otherCheckbox.checked = false;
                    }
                });
            } else if (this !== nenhumaAcaoCheckbox && nenhumaAcaoCheckbox.checked) {
                // Se qualquer outra opção for marcada quando "Nenhuma das ações" estiver marcada, desmarcar "Nenhuma das ações"
                nenhumaAcaoCheckbox.checked = false;
            }
        });
    });

    document.querySelector('#opcao_acucar').addEventListener('submit', function(event) {
        let selected = false;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selected = true;
            }
        });

        if (!selected) {
            alert('Selecione pelo menos uma opção.');
            event.preventDefault(); // Impede o envio do formulário se nada for selecionado
        }
    });
</script>





                    </div>

<!-- Campos adicionais para valor da bebida quente, valor da bebida gelada e tamanho da bebida -->
<div class="col-md-4">
    <div class="form-group" style="display: block;" id="valor_bebida_gelada">
        <label for="valor_bebida_gelada_input">Valor da Bebida Gelada:</label>
        <input type="text" class="form-control" id="valor_bebida_gelada_input" name="valor_bebida_gelada">
    </div>
    <div class="form-group" style="display: block;" id="valor_bebida_quente">
        <label for="valor_bebida_quente_input">Valor da Bebida Quente:</label>
        <input type="text" class="form-control" id="valor_bebida_quente_input" name="valor_bebida_quente">
    </div>
    <div class="form-group" style="display: block;" id="tamanho_bebida">
        <label for="tamanho_bebida_input">Tamanho da Bebida:</label>
        <input type="text" class="form-control" id="tamanho_bebida_input" name="tamanho_bebida">
    </div>
</div>

<script>
    // Adicione um evento de escuta para os radio buttons
    const radioButtons = document.querySelectorAll('input[type="radio"][name="gelado_option"]');
    const camposGelado = document.getElementById('valor_bebida_gelada');
    const camposQuente = document.getElementById('valor_bebida_quente');
    const camposTamanho = document.getElementById('tamanho_bebida');

    radioButtons.forEach(radioButton => {
        radioButton.addEventListener('change', function() {
            // Oculte todos os campos adicionais primeiro
            camposGelado.style.display = 'none';
            camposQuente.style.display = 'none';
            camposTamanho.style.display = 'none';

            // Verifique qual opção está selecionada
            if (this.value === 'somente_gelado') {
                // Se "Somente Gelado" estiver selecionado, mostre os campos adicionais para gelado
                camposGelado.style.display = 'block';
                camposTamanho.style.display = 'block';
            } else if (this.value === 'somente_quente') {
                // Se "Somente Quente" estiver selecionado, mostre os campos adicionais para quente
                camposQuente.style.display = 'block';
                camposTamanho.style.display = 'block';
            } else {
                // Se "Gelado e Quente" estiver selecionado, mostre os campos adicionais
                camposGelado.style.display = 'block';
                camposQuente.style.display = 'block';
                camposTamanho.style.display = 'block';
            }
        });
    });
</script>

<script>
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="acucar_option[]"]');
    const nenhumaAcaoCheckbox = document.getElementById('sem_acucar');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this === nenhumaAcaoCheckbox && this.checked) {
                // Se "Nenhuma das ações" for marcada, desmarcar todas as outras opções
                checkboxes.forEach(otherCheckbox => {
                    if (otherCheckbox !== nenhumaAcaoCheckbox) {
                        otherCheckbox.checked = false;
                    }
                });
            } else if (this !== nenhumaAcaoCheckbox && nenhumaAcaoCheckbox.checked) {
                // Se qualquer outra opção for marcada quando "Nenhuma das ações" estiver marcada, desmarcar "Nenhuma das ações"
                nenhumaAcaoCheckbox.checked = false;
            }
        });
    });

    document.querySelector('#opcao_acucar').addEventListener('submit', function(event) {
        let selected = false;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selected = true;
            }
        });

        if (!selected) {
            alert('Selecione pelo menos uma opção.');
            event.preventDefault(); // Impede o envio do formulário se nada for selecionado
        }
    });
</script>

</div>




    <hr>
  <div class="d-flex align-items-center justify-content-center">
  <button type="submit" class="btn btn-warning p-3"><strong class="mr-1">Prosseguir</strong> <i class="fa-solid fa-forward move-back-and-forth"></i></button>
</div>

  </form>

  </div>
  </div>
  </div>
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
