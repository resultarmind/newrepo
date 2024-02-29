<?php

session_start();
include_once "config/conection.php"; // Certifique-se de incluir corretamente o arquivo de conexão

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login/login.php"); // Redirecione para a página de login se o usuário não estiver autenticado
    exit();
}

// Recupere o panel_id do usuário do banco de dados
$username = $_SESSION["username"];

$sql = "SELECT panel_id FROM usuarios WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $panel_id = $row["panel_id"];
} else {
    // Lidar com a situação em que o panel_id não foi encontrado
    echo "Erro ao obter o panel_id do usuário.";
}

// Agora $id_user contém o panel_id do usuário

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- vendor css -->
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
    <link href="../lib/rickshaw/rickshaw.min.css" rel="stylesheet">
    <link href="../lib/chartist/chartist.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bracket CSS -->
    


</head>
<!-- Script para aplicar as máscaras -->

    <link rel="stylesheet" href="../css/bracket.css">
  </head>

  <body>

    <?php include_once 'config/header.php'?>

    <script type="text/javascript">
    window.onload = function() {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('info') === 'incomplete') {
            Swal.fire({
                title: 'Bem-vindo!',
                text: 'Bem-vindo ao Sistema de Pedidos Online da Resultar Mind! Para começar, por favor, complete as informações da sua loja. Isso nos ajudará a oferecer a melhor experiência para você e seus clientes!',
                icon: 'info',
                confirmButtonText: 'Ok'
            });
        }
    };
</script>



    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.php">Início</a>
          <a class="breadcrumb-item" href="#">Site</a>
          <span class="breadcrumb-item active">Informações do Site</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Informações do Site</h4>
        <p class="mg-b-0">Edite as imagens principais e altere as informações de contato.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">


        <?php
include_once "config/conection.php";

// Consulta para obter os dados do banco de dados para o ID 1
$sql = "SELECT * FROM infos WHERE id = $panel_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Atribuir os valores aos campos do formulário
    $banner = $row['banner'];
    $logo = $row['logo'];
    $logoFooter = $row['logoFooter'];
    $nome = $row['nome'];
    $telefone = $row['telefone'];
    $whatsapp = $row['whatsapp'];
    $cnpj = $row['cnpj'];
    $cidade = $row['cidade'];
    $estado = $row['estado'];
    $instagram = $row['instagram'];
    $telegram = $row['telegram'];
    $num = $row['num'];
    $bairro = $row['bairro'];
    $endereco = $row['endereco'];
    $cep = $row['cep'];
    $freteRegiao = $row['frete_regiao'];
    $valorFreteDoBanco = $row['valor_frete'];


    // Certifique-se de adicionar os campos de imagem se estiverem disponíveis no banco de dados

    // Consulta para obter os horários da tabela horarios
    $sqlHorarios = "SELECT * FROM horarios WHERE id = $panel_id";
    $resultHorarios = $conn->query($sqlHorarios);

    if ($resultHorarios->num_rows > 0) {
        $rowHorarios = $resultHorarios->fetch_assoc();

        // Adicionar os valores dos horários
        $segundaAbertura = $rowHorarios['abertura_segunda'];
        $segundaFechamento = $rowHorarios['fechamento_segunda'];
        $tercaAbertura = $rowHorarios['abertura_terca'];
        $tercaFechamento = $rowHorarios['fechamento_terca'];
        $quartaAbertura = $rowHorarios['abertura_quarta'];
        $quartaFechamento = $rowHorarios['fechamento_quarta'];
        $quintaAbertura = $rowHorarios['abertura_quinta'];
        $quintaFechamento = $rowHorarios['fechamento_quinta'];
        $sextaAbertura = $rowHorarios['abertura_sexta'];
        $sextaFechamento = $rowHorarios['fechamento_sexta'];
        $sabadoAbertura = $rowHorarios['abertura_sabado'];
        $sabadoFechamento = $rowHorarios['fechamento_sabado'];
        $domingoAbertura = $rowHorarios['abertura_domingo'];
        $domingoFechamento = $rowHorarios['fechamento_domingo'];
    } else {
        echo "Nenhum resultado encontrado na tabela 'horarios'.";
    }
} else {
    echo "Nenhum resultado encontrado na tabela 'infos'.";
}

?>




        <form action="functions/save_info.php" method="post" enctype="multipart/form-data">
                    <div class="row">
            <div class="col-md-4">


<div class="form-group">
    <label for="banner">Alterar Banner:</label>
    <input type="file" class="form-control" id="banner" name="banner">
    <div class="card text-center">
      <div class="card-body">
        
    <img src="uploads/<?php echo $banner; ?>" alt="" style="height: 150px; width: 150px;">
    
    </div>
    </div>
</div>



    </div>
    <div class="col-md-4">

    <div class="form-group">
      <label for="logo">Alterar Logo:</label>
      <input type="file" class="form-control" id="logo" name="logo">
      <div class="card text-center">
      <div class="card-body">
        
    <img src="uploads/<?php echo $logo; ?>" alt="" style="height: 150px; width: 150px;">
    
    </div>
    </div>
        </div>

    </div>
    <div class="col-md-4">

    <div class="form-group">
      <label for="logoFooter">Alterar Logo do Rodapé:</label>
      <input type="file" class="form-control" id="logoFooter" name="logoFooter">
      <div class="card text-center">
      <div class="card-body">
        
      <img src="uploads/<?php echo $logoFooter; ?>" alt="" style="height: 150px; width: 150px;">
    
    </div>
    </div>
        </div>

    </div>

    </div>

    <div class="col-md-12">
    <div class="form-group">
      <label for="nome">Nome do estabelecimento:</label>
      <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome da Empresa" value="<?php echo $nome; ?>">
    </div>
    </div>
    <hr>

    <div class="row">
    <div class="col">
        
    <div class="form-group">
    <label for="telefone">Número de Telefone:</label>
    <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Digite o número de telefone +00 (00) 0 0000-0000" value="<?php echo $telefone; ?>" maxlength="17">
</div>

<script>
    document.getElementById('telefone').addEventListener('input', function(event) {
        let telefone = event.target.value;
        telefone = telefone.replace(/\D/g, ''); // Remove caracteres não numéricos
        telefone = telefone.replace(/^(\d{2})(\d{2})(\d{5})(\d{4})$/, '+$1 ($2) $3-$4'); // Formata o número de telefone
        event.target.value = telefone;
    });
</script>


    </div>
    <div class="col">

    <div class="form-group">
    <label for="whatsapp">Número de WhatsApp:</label>
    <input type="tel" class="form-control" id="whatsapp" name="whatsapp" placeholder="Digite o número de WhatsApp  +00 (00) 0 0000-0000" value="<?php echo $whatsapp; ?>" maxlength="17">
</div>

<script>
    document.getElementById('whatsapp').addEventListener('input', function(event) {
        let whatsapp = event.target.value;
        whatsapp = whatsapp.replace(/\D/g, ''); // Remove caracteres não numéricos
        whatsapp = whatsapp.replace(/^(\d{2})(\d{2})(\d{5})(\d{4})$/, '+$1 ($2) $3-$4'); // Formata o número de WhatsApp
        event.target.value = whatsapp;
    });
</script>

    </div>
    </div>
    <div class="row">
      <div class="col">
        
      <div class="form-group">
    <label for="cnpj">CNPJ:</label>
    <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o CNPJ da empresa" value="<?php echo $cnpj; ?>" maxlength="18">
</div>

<script>
    document.getElementById('cnpj').addEventListener('input', function(event) {
        let cnpj = event.target.value;
        cnpj = cnpj.replace(/\D/g, ''); // Remove caracteres não numéricos
        cnpj = cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5'); // Formata o CNPJ
        event.target.value = cnpj;
    });
</script>



      </div>
    <div class="col">
    <div class="form-group">
      <label for="cidade">Cidade:</label>
      <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Digite a cidade" value="<?php echo $cidade; ?>">
    </div>
    </div>
    <div class="col">
    <div class="form-group">
      <label for="estado">Estado:</label>
      <input type="text" class="form-control" id="estado" name="estado" placeholder="Digite o estado da empresa" value="<?php echo $estado; ?>">
    </div>
    </div>
    </div>


<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="endereco">Endereço:</label>
            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Digite o endereço da empresa" value="<?php echo $endereco; ?>">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="bairro">Bairro:</label>
            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Digite o bairro" value="<?php echo $bairro; ?>">
        </div>
    </div>
    <div class="col-2">
    <div class="form-group">
    <label for="cep">CEP:</label>
    <input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o CEP" maxlength="9" value="<?php echo $cep; ?>">
</div>

<script>
    document.getElementById('cep').addEventListener('input', function(event) {
        let cep = event.target.value;
        cep = cep.replace(/\D/g, ''); // Remove caracteres não numéricos
        cep = cep.replace(/^(\d{5})(\d{1,3})/, '$1-$2'); // Adiciona o hífen após os primeiros 5 dígitos
        event.target.value = cep;
    });
</script>


    </div>

    <div class="col-2">
        <div class="form-group">
            <label for="cep">Nº:</label>
            <input type="text" class="form-control" id="num" name="num" placeholder="Digite o Nº" value="<?php echo $num; ?>">
        </div>
    </div>

</div>

<hr>
<div class="row">
  <div class="col">
    <label for="freteGratisSelect" class="form-label"><strong>Frete grátis para a sua Cidade?</strong></label>
    <select id="freteGratisSelect" name="freteGratisSelect" class="form-control">
      <option value="Sim" <?php echo ($freteRegiao == 1) ? 'selected' : ''; ?>>Sim</option>
      <option value="Não" <?php echo ($freteRegiao == 2) ? 'selected' : ''; ?>>Não</option>
    </select>
  </div>
</div>

<div class="row" id="valorFreteRow" <?php echo ($freteRegiao == 2) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
  <div class="col">
    <label for="valorFreteInput" class="form-label">Valor do Frete:</label>
    <input type="text" id="valorFreteInput" name="valorFreteInput" class="form-control" value="<?php echo $valorFreteDoBanco; ?>">
  </div>
</div>


<script>
  // Captura o elemento select e o elemento de input
  var freteGratisSelect = document.getElementById("freteGratisSelect");
  var valorFreteRow = document.getElementById("valorFreteRow");

  // Adiciona um evento de mudança ao select
  freteGratisSelect.addEventListener("change", function() {
    // Verifica se a opção selecionada é "Não"
    if (freteGratisSelect.value === "Não") {
      // Se for, mostra o campo de input
      valorFreteRow.style.display = "block";
    } else {
      // Caso contrário, esconde o campo de input
      valorFreteRow.style.display = "none";
    }
  });
</script>





    <hr>
    <div class="row">
    <div class="col">

    <div class="form-group">
      <label for="instagram">Instagram:</label>
      <input type="text" class="form-control" id="instagram" name="instagram" placeholder="Digite o perfil do Instagram" value="<?php echo $instagram; ?>">
    </div>

    </div>
    <div class="col">

    <div class="form-group">
      <label for="telegram">Telegram:</label>
      <input type="text" class="form-control" name="telegram" id="telegram" placeholder="Digite o canal do Telegram" value="<?php echo $telegram; ?>">
    </div>
    </div>

    </div>
    <hr>

    <div class="form-group">
    <label for="horariosFuncionamento">Horários de Funcionamento:</label>
    <div class="row">
        <!-- Exemplo para cada dia da semana -->
        <!-- Segunda-feira -->
        <div class="col-md-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkSegunda" onchange="toggleHorario('Segunda')">
                <label class="form-check-label" for="checkSegunda">Segunda-feira</label>
            </div>
            <div id="horarioSegunda" style="display: none;">
                <label for="segundaAbertura" class="col-form-label">Abertura:</label>
                <input type="time" class="form-control" id="segundaAbertura" name="segundaAbertura" placeholder="Abertura" value="<?php echo $segundaAbertura; ?>">
                <label for="segundaFechamento" class="col-form-label">Fechamento:</label>
                <input type="time" class="form-control" id="segundaFechamento" name="segundaFechamento" placeholder="Fechamento" value="<?php echo $segundaFechamento; ?>">
            </div>
        </div>
   <!-- Terça-feira -->
<div class="col-md-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="checkTerca" onchange="toggleHorario('Terca')">
        <label class="form-check-label" for="checkTerca">Terça-feira</label>
    </div>
    <div id="horarioTerca" style="display: none;">
        <label for="tercaAbertura" class="col-form-label">Abertura:</label>
        <input type="time" class="form-control" id="tercaAbertura" name="tercaAbertura" placeholder="Abertura" value="<?php echo $tercaAbertura; ?>">
        <label for="tercaFechamento" class="col-form-label">Fechamento:</label>
        <input type="time" class="form-control" id="tercaFechamento" name="tercaFechamento" placeholder="Fechamento" value="<?php echo $tercaFechamento; ?>">
    </div>
</div>

<!-- Quarta-feira -->
<div class="col-md-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="checkQuarta" onchange="toggleHorario('Quarta')">
        <label class="form-check-label" for="checkQuarta">Quarta-feira</label>
    </div>
    <div id="horarioQuarta" style="display: none;">
        <label for="quartaAbertura" class="col-form-label">Abertura:</label>
        <input type="time" class="form-control" id="quartaAbertura" name="quartaAbertura" placeholder="Abertura" value="<?php echo $quartaAbertura; ?>">
        <label for="quartaFechamento" class="col-form-label">Fechamento:</label>
        <input type="time" class="form-control" id="quartaFechamento" name="quartaFechamento" placeholder="Fechamento" value="<?php echo $quartaFechamento; ?>">
    </div>
</div>

<!-- Quinta-feira -->
<div class="col-md-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="checkQuinta" onchange="toggleHorario('Quinta')">
        <label class="form-check-label" for="checkQuinta">Quinta-feira</label>
    </div>
    <div id="horarioQuinta" style="display: none;">
        <label for="quintaAbertura" class="col-form-label">Abertura:</label>
        <input type="time" class="form-control" id="quintaAbertura" name="quintaAbertura" placeholder="Abertura" value="<?php echo $quintaAbertura; ?>">
        <label for="quintaFechamento" class="col-form-label">Fechamento:</label>
        <input type="time" class="form-control" id="quintaFechamento" name="quintaFechamento" placeholder="Fechamento" value="<?php echo $quintaFechamento; ?>">
    </div>
</div>

    </div>
    <div class="row mt-4">
<!-- Sexta-feira -->
<div class="col-md-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="checkSexta" onchange="toggleHorario('Sexta')">
        <label class="form-check-label" for="checkSexta">Sexta-feira</label>
    </div>
    <div id="horarioSexta" style="display: none;">
        <label for="sextaAbertura" class="col-form-label">Abertura:</label>
        <input type="time" class="form-control" id="sextaAbertura" name="sextaAbertura" placeholder="Abertura" value="<?php echo $sextaAbertura; ?>">
        <label for="sextaFechamento" class="col-form-label">Fechamento:</label>
        <input type="time" class="form-control" id="sextaFechamento" name="sextaFechamento" placeholder="Fechamento" value="<?php echo $sextaFechamento; ?>">
    </div>
</div>

<!-- Sábado -->
<div class="col-md-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="checkSabado" onchange="toggleHorario('Sabado')">
        <label class="form-check-label" for="checkSabado">Sábado</label>
    </div>
    <div id="horarioSabado" style="display: none;">
        <label for="sabadoAbertura" class="col-form-label">Abertura:</label>
        <input type="time" class="form-control" id="sabadoAbertura" name="sabadoAbertura" placeholder="Abertura" value="<?php echo $sabadoAbertura; ?>">
        <label for="sabadoFechamento" class="col-form-label">Fechamento:</label>
        <input type="time" class="form-control" id="sabadoFechamento" name="sabadoFechamento" placeholder="Fechamento" value="<?php echo $sabadoFechamento; ?>">
    </div>
</div>

<!-- Domingo -->
<div class="col-md-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="checkDomingo" onchange="toggleHorario('Domingo')">
        <label class="form-check-label" for="checkDomingo">Domingo</label>
    </div>
    <div id="horarioDomingo" style="display: none;">
        <label for="domingoAbertura" class="col-form-label">Abertura:</label>
        <input type="time" class="form-control" id="domingoAbertura" name="domingoAbertura" placeholder="Abertura" value="<?php echo $domingoAbertura; ?>">
        <label for="domingoFechamento" class="col-form-label">Fechamento:</label>
        <input type="time" class="form-control" id="domingoFechamento" name="domingoFechamento" placeholder="Fechamento" value="<?php echo $domingoFechamento; ?>">
    </div>
</div>

    </div>
</div>

<script>
function toggleHorario(dia) {
    var checkBox = document.getElementById("check" + dia);
    var horarioDiv = document.getElementById("horario" + dia);
    if (checkBox.checked == true) {
        horarioDiv.style.display = "block";
    } else {
        horarioDiv.style.display = "none";
    }
}
</script>



    <button type="submit" class="btn btn-primary mt-5">Salvar Alterações</button>
  </form>


      </div>



    



    <?php include_once 'config/footer.php'?>

    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

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
