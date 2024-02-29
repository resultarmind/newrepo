<?php

session_start();
include_once "../config/conection.php"; // Certifique-se de incluir corretamente o arquivo de conexão

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
    exit();
}

// Função para gerar um nome de arquivo único
function generateUniqueFilename($filename) {
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $basename = pathinfo($filename, PATHINFO_FILENAME);
    $uniqueName = $basename . '_' . uniqid() . '.' . $extension;
    return $uniqueName;
}

// Pasta onde os uploads serão salvos
$uploadDir = "../uploads/";

// Obter dados do formulário
$nome = !empty($_POST['nome']) ? $_POST['nome'] : null;
$telefone = !empty($_POST['telefone']) ? $_POST['telefone'] : null;
$whatsapp = !empty($_POST['whatsapp']) ? $_POST['whatsapp'] : null;
$cnpj = !empty($_POST['cnpj']) ? $_POST['cnpj'] : null;
$cidade = !empty($_POST['cidade']) ? $_POST['cidade'] : null;
$estado = !empty($_POST['estado']) ? $_POST['estado'] : null;
$instagram = !empty($_POST['instagram']) ? $_POST['instagram'] : null;
$telegram = !empty($_POST['telegram']) ? $_POST['telegram'] : null;
$num = !empty($_POST['num']) ? $_POST['num'] : null;
$bairro = !empty($_POST['bairro']) ? $_POST['bairro'] : null;
$endereco = !empty($_POST['endereco']) ? $_POST['endereco'] : null;
$cep = !empty($_POST['cep']) ? $_POST['cep'] : null;



// Inicializar variáveis para os nomes de arquivo existentes
$banner = $_POST['currentBanner'] ?? '';
$logo = $_POST['currentLogo'] ?? '';
$logoFooter = $_POST['currentLogoFooter'] ?? '';

// Verificar se algum arquivo de imagem foi enviado
if ($_FILES['banner']['name']) {
    $banner = generateUniqueFilename($_FILES['banner']['name']);
    move_uploaded_file($_FILES['banner']['tmp_name'], $uploadDir . $banner);
}

if ($_FILES['logo']['name']) {
    $logo = generateUniqueFilename($_FILES['logo']['name']);
    move_uploaded_file($_FILES['logo']['tmp_name'], $uploadDir . $logo);
}

if ($_FILES['logoFooter']['name']) {
    $logoFooter = generateUniqueFilename($_FILES['logoFooter']['name']);
    move_uploaded_file($_FILES['logoFooter']['tmp_name'], $uploadDir . $logoFooter);
}

// Atualizar os dados na tabela infos
$sqlInfos = "UPDATE infos SET 
        banner = IF('$banner' <> '', '$banner', banner),
        logo = IF('$logo' <> '', '$logo', logo),
        logoFooter = IF('$logoFooter' <> '', '$logoFooter', logoFooter),
        nome = IF('$nome' <> '', '$nome', nome),
        telefone = IF('$telefone' <> '', '$telefone', telefone),
        whatsapp = IF('$whatsapp' <> '', '$whatsapp', whatsapp),
        cnpj = IF('$cnpj' <> '', '$cnpj', cnpj),
        cidade = IF('$cidade' <> '', '$cidade', cidade),
        estado = IF('$estado' <> '', '$estado', estado),
        instagram = IF('$instagram' <> '', '$instagram', instagram),
        telegram = IF('$telegram' <> '', '$telegram', telegram),
        num = IF('$num' <> '', '$num', num),
        bairro = IF('$bairro' <> '', '$bairro', bairro),
        endereco = IF('$endereco' <> '', '$endereco', endereco),
        cep = IF('$cep' <> '', '$cep', cep)

        WHERE id = $panel_id";



// Obter dados do formulário para horários
$segundaAbertura = isset($_POST['segundaAbertura']) ? $_POST['segundaAbertura'] : '';
$segundaFechamento = isset($_POST['segundaFechamento']) ? $_POST['segundaFechamento'] : '';
$tercaAbertura = isset($_POST['tercaAbertura']) ? $_POST['tercaAbertura'] : '';
$tercaFechamento = isset($_POST['tercaFechamento']) ? $_POST['tercaFechamento'] : '';
$quartaAbertura = isset($_POST['quartaAbertura']) ? $_POST['quartaAbertura'] : '';
$quartaFechamento = isset($_POST['quartaFechamento']) ? $_POST['quartaFechamento'] : '';
$quintaAbertura = isset($_POST['quintaAbertura']) ? $_POST['quintaAbertura'] : '';
$quintaFechamento = isset($_POST['quintaFechamento']) ? $_POST['quintaFechamento'] : '';
$sextaAbertura = isset($_POST['sextaAbertura']) ? $_POST['sextaAbertura'] : '';
$sextaFechamento = isset($_POST['sextaFechamento']) ? $_POST['sextaFechamento'] : '';
$sabadoAbertura = isset($_POST['sabadoAbertura']) ? $_POST['sabadoAbertura'] : '';
$sabadoFechamento = isset($_POST['sabadoFechamento']) ? $_POST['sabadoFechamento'] : '';
$domingoAbertura = isset($_POST['domingoAbertura']) ? $_POST['domingoAbertura'] : '';
$domingoFechamento = isset($_POST['domingoFechamento']) ? $_POST['domingoFechamento'] : '';


// Primeiro, verificar se o panel_id existe na tabela
$sqlCheck = "SELECT id FROM horarios WHERE id = $panel_id";
$result = $conn->query($sqlCheck);

// Se não existir, inserir um novo registro com esse panel_id
if ($result->num_rows == 0) {
    $sqlInsert = "INSERT INTO horarios (id) VALUES ($panel_id)";
    if (!$conn->query($sqlInsert)) {
        echo "Erro ao inserir novo panel_id: " . $conn->error;
        exit();
    }
}


// Atualizar os dados na tabela horarios
$sqlHorarios = "UPDATE horarios SET 
        abertura_segunda = IF('$segundaAbertura' <> '', '$segundaAbertura', abertura_segunda),
        fechamento_segunda = IF('$segundaFechamento' <> '', '$segundaFechamento', fechamento_segunda),
        abertura_terca = IF('$tercaAbertura' <> '', '$tercaAbertura', abertura_terca),
        fechamento_terca = IF('$tercaFechamento' <> '', '$tercaFechamento', fechamento_terca),
        abertura_quarta = IF('$quartaAbertura' <> '', '$quartaAbertura', abertura_quarta),
        fechamento_quarta = IF('$quartaFechamento' <> '', '$quartaFechamento', fechamento_quarta),
        abertura_quinta = IF('$quintaAbertura' <> '', '$quintaAbertura', abertura_quinta),
        fechamento_quinta = IF('$quintaFechamento' <> '', '$quintaFechamento', fechamento_quinta),
        abertura_sexta = IF('$sextaAbertura' <> '', '$sextaAbertura', abertura_sexta),
        fechamento_sexta = IF('$sextaFechamento' <> '', '$sextaFechamento', fechamento_sexta),
        abertura_sabado = IF('$sabadoAbertura' <> '', '$sabadoAbertura', abertura_sabado),
        fechamento_sabado = IF('$sabadoFechamento' <> '', '$sabadoFechamento', fechamento_sabado),
        abertura_domingo = IF('$domingoAbertura' <> '', '$domingoAbertura', abertura_domingo),
        fechamento_domingo = IF('$domingoFechamento' <> '', '$domingoFechamento', fechamento_domingo)
        WHERE id = $panel_id";


// Obter o valor selecionado do frete grátis
$freteGratis = $_POST['freteGratisSelect'];

// Inicializar variável para o valor do frete
$valorFrete = "";

// Verificar se o frete é grátis
if ($freteGratis === "Sim") {
    $valorFrete = "Grátis";
} else {
    // Se não for grátis, obter o valor do frete do formulário
    $valorFrete = $_POST['valorFreteInput'];
}

// Determinar o valor do campo "frete" com base em "$freteGratis"
$frete = ($freteGratis === "Sim") ? 1 : 2;

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Atualizar os dados na tabela frete_regiao
$sqlUpdateFrete = "UPDATE infos SET 
    frete_regiao = $frete,
    valor_frete = '$valorFrete'
    WHERE id = $panel_id";


// Executar as consultas SQL
if ($conn->query($sqlInfos) === TRUE && $conn->query($sqlHorarios) === TRUE && $conn->query($sqlUpdateFrete) === TRUE) {
    // Redirecionar para view_infos.php após a atualização bem-sucedida
    header("Location: ../view_infos.php");
    exit();
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}


// Fechar a conexão com o banco de dados
$conn->close();
?>
