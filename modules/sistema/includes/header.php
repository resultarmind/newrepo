<?php
include_once "includes/connection.php";
?>



<?php
// Obtém o URI atual
$uri = $_SERVER['REQUEST_URI'];

// Verifica se o URI contém 'pages' para identificar se está em uma subpágina
$inSubPage = strpos($uri, '/pages/') !== false;

// Define o caminho para o link de INÍCIO baseado na localização da página
$homeLinkPath = $inSubPage ? '../index.php' : 'index.php';
?>





<nav class="navbar navbar-expand-lg bg-light sticky-top">
    <div class="container">
        <div class="navbar-collapse text-center" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link active" aria-current="page" href="<?php echo $homeLinkPath; ?>"><i class="fa-solid fa-house"></i> INÍCIO</a>
                </li>
                <!-- Outros itens do menu aqui -->
            </ul>

            <!-- Carrinho (visível em dispositivos móveis) -->
            <?php
// Verifica se a URL contém 'pages/success.php' ou 'pages/checkout.php'
if (strpos($_SERVER['REQUEST_URI'], 'pages/success.php') !== false || strpos($_SERVER['REQUEST_URI'], 'pages/checkout.php') !== false):
?>
    <!-- Botão de início -->
    <a href="../index.php" class="botao-inicio"><i class="fa-solid fa-house"></i> INÍCIO</a>
<?php else: ?>
    <!-- Carrinho -->
    <div class="carrinho" id="abrir-menu" data-toggle="modal" data-target="#carrinhoModal">
        <p>Carrinho <i class="fa-solid fa-cart-shopping"></i></p>
        <div class="cart">
            <p>0</p>
        </div>
    </div>
<?php endif; ?>

        </div>
    </div>
</nav>




<?php
// Verifica se a URL contém 'pages/success'
if (strpos($_SERVER['REQUEST_URI'], 'pages/success') !== false):
?>
    <div class="d-flex align-items-center justify-content-center p-4 mb-1 mt-3">
        <h4 class="text-center success mx-auto mt-5 mb-1">
            PEDIDO REALIZADO COM SUCESSO <i class="fa-solid fa-circle-check"></i>
        </h4>
    </div>
<?php endif; ?>



<div class="container mt-5">




    <div class="card no-border">

    <?php
// Definir o fuso horário para São Paulo
date_default_timezone_set('America/Sao_Paulo');

include_once "../includes/connection.php";

$query = "SELECT nome, cidade, valor_frete, whatsapp, telefone, logo, banner FROM infos WHERE id = $loja_id";

$result = $conn->query($query);

if ($result === false) {
    echo "Erro na consulta: " . $conn->error;
} else {
    $row = $result->fetch_assoc();

    $nome_loja = $row['nome'];
    $cidade = $row['cidade'];
    $valor_frete = $row['valor_frete'];
    $whatsapp = $row['whatsapp'];
    $telefone = $row['telefone'];
    $logo_nome = $row['logo'];
    $banner_nome = $row['banner'];

    // Obtém o URI atual
    $uri = $_SERVER['REQUEST_URI'];

    // Verifica se o URI contém 'pages' para identificar se está em uma subpágina
    if (strpos($uri, '/pages/') !== false) {
        // Está dentro da pasta 'pages', portanto usa dois '../'
        $path_prefix = '../../';
    } else {
        // Está na raiz (ou não está dentro de 'pages'), usa um '../'
        $path_prefix = '../';
    }

    // Define os URLs com o prefixo correto
    $logo_url = $path_prefix . "admin/app/uploads/$logo_nome";
    $banner_url = $path_prefix . "admin/app/uploads/$banner_nome";

    echo '<div class="col-md-12 mb-5 mobile-custom-class mobile-display">';
    echo "<img src=\"$banner_url\" class=\"img-banner\" style=\"height:300px; width:100%;\" alt=\"$nome_loja\">";
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-md-2 mobile-custom-class pt-4">';
    echo "<img src=\"$logo_url\" class=\"img-banner rounded\" style=\"height:150px\" alt=\"$logo_nome\">";
    echo '</div>';

    function formatarTelefone($numero)
    {
        // Remove espaços e parênteses
        $numero = str_replace([' ', '(', ')'], '', $numero);

        // Remove caracteres não numéricos
        $numero = preg_replace('/\D/', '', $numero);

        // Verifica se o número começa com "+" e tem um comprimento válido
        if (substr($numero, 0, 1) == '+') {
            // Remove o "+" antes de continuar
            $numero = substr($numero, 1);
        }

        if (strlen($numero) == 13 && substr($numero, 0, 2) == '55') {
            // Número no formato +55 (00) 3 0000-0000
            return '+55 (' . substr($numero, 2, 2) . ') ' . substr($numero, 4, 1) . ' ' . substr($numero, 5, 4) . '-' . substr($numero, 9, 4);
        } elseif (strlen($numero) == 13) {
            // Outros números no formato +00 (00) 3 0000-0000
            return '+'. substr($numero, 0, 2) . ' (' . substr($numero, 2, 2) . ') ' . substr($numero, 4, 1) . ' ' . substr($numero, 5, 4) . '-' . substr($numero, 9, 4);
        } elseif (strlen($numero) == 12) {
            // Números de celular ou fixo no formato +00 (00) XXXX-XXXX
            return '+'. substr($numero, 0, 2) . ' (' . substr($numero, 2, 2) . ') ' . substr($numero, 4, 4) . '-' . substr($numero, 8, 4);
        } else {
            return 'Número de telefone inválido';
        }
    }

    echo '<div class="col-md-4 mobile-custom-class mobile-custom-spacing-2 pt-4">';
    echo "<h3 class='mt-4'>$nome_loja</h3>";
    echo '<div class="number">';
    echo "<h6>WHATSAPP: <a href=\"https://api.whatsapp.com/send?phone=$whatsapp\" target=\"_blank\">" . formatarTelefone($whatsapp) . " <i class=\"fab fa-whatsapp\"></i></a></h6>";
    echo "<h6>TELEFONE: <a href=\"tel:$telefone\">" . formatarTelefone($telefone) . " <i class=\"fa-solid fa-phone\"></i></a></h6>";
    echo '</div>';
    echo '</div>';

    echo '<div class="col-md-6 ms-auto">';
    echo '<div class="horario" id="horario">';

    // Consulta SQL para obter os horários de funcionamento
    $sqlHorarios = "SELECT 
        abertura_segunda, fechamento_segunda,
        abertura_terca, fechamento_terca,
        abertura_quarta, fechamento_quarta,
        abertura_quinta, fechamento_quinta,
        abertura_sexta, fechamento_sexta,
        abertura_sabado, fechamento_sabado,
        abertura_domingo, fechamento_domingo
    FROM horarios WHERE id = ?";

    $stmtHorarios = $conn->prepare($sqlHorarios);
    $stmtHorarios->bind_param("i", $loja_id);
    $stmtHorarios->execute();
    $resultadoHorarios = $stmtHorarios->get_result();

    if ($resultadoHorarios->num_rows > 0) {
        $horarios = $resultadoHorarios->fetch_assoc();

        // Inicializando a string de horário de funcionamento
        $horarioFuncionamento = "<h5 class='text-center pb-2'>Horário de Funcionamento</h5>";
        $horarioFuncionamento .= "<ul class='list-unstyled horarios text-center'>";

        // Dias da semana e seus respectivos horários
        $diasSemana = [
            "SEG" => ["Segunda-feira", substr($horarios['abertura_segunda'], 0, 5), substr($horarios['fechamento_segunda'], 0, 5)],
            "TER" => ["Terça-feira", substr($horarios['abertura_terca'], 0, 5), substr($horarios['fechamento_terca'], 0, 5)],
            "QUA" => ["Quarta-feira", substr($horarios['abertura_quarta'], 0, 5), substr($horarios['fechamento_quarta'], 0, 5)],
            "QUI" => ["Quinta-feira", substr($horarios['abertura_quinta'], 0, 5), substr($horarios['fechamento_quinta'], 0, 5)],
            "SEX" => ["Sexta-feira", substr($horarios['abertura_sexta'], 0, 5), substr($horarios['fechamento_sexta'], 0, 5)],
            "SAB" => ["Sábado", substr($horarios['abertura_sabado'], 0, 5), substr($horarios['fechamento_sabado'], 0, 5)],
            "DOM" => ["Domingo", substr($horarios['abertura_domingo'], 0, 5), substr($horarios['fechamento_domingo'], 0, 5)]
        ];

        // Obter o horário atual
        $agora = strtotime(date("H:i:s"));

        // Determinar o dia da semana atual
// Obter o dia atual em português
setlocale(LC_TIME, 'pt_BR.utf-8');
$diaSemanaAtual = strftime('%A');

        // Comparar o horário atual com os horários de abertura e fechamento da loja para o dia da semana atual
        $abertura = strtotime($horarios["abertura_$diaSemanaAtual"]);
        $fechamento = strtotime($horarios["fechamento_$diaSemanaAtual"]);


        // Determinar se a loja está aberta ou fechada com base na comparação
        $abertoAgora = ($agora >= $abertura && $agora <= $fechamento);

        // Restante do código permanece o mesmo
        $statusClasse = $abertoAgora ? "aberto" : "fechado";
        $statusTexto = $abertoAgora ? "ABERTO AGORA" : "FECHADO AGORA";
        $corTexto = $abertoAgora ? "green" : "red";

        // Exibir o status de aberto/fechado
        $horarioFuncionamento .= "<p class='text-center display-horario $statusClasse blinking' style='color: $corTexto;'><i class='fa-solid fa-circle-dot'></i> $statusTexto </p>";

        // Exibindo os horários de funcionamento
        foreach ($diasSemana as $dia => $horario) {
            $horarioFuncionamento .= "<li>$horario[0]: $horario[1] - $horario[2]</li>";
        }

        $horarioFuncionamento .= "</ul>";
        echo $horarioFuncionamento;
    } else {
        echo "<p>Horários de funcionamento não encontrados.</p>";
    }

    echo '</div>';
    echo '</div>';
}
?>





    </div>
</div>


<?php if (strpos($_SERVER['REQUEST_URI'], 'pages/success.php') !== false): ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp ?>&text=Ol%C3%A1%21%20" class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
<?php endif; ?>
