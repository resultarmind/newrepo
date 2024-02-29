<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once "../config/conection.php";

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: login/login.php");
    exit();
}

// Recupere o panel_id do usuário do banco de dados
$username = $_SESSION["username"];
$sql = "SELECT panel_id FROM usuarios WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $panel_id = $row["panel_id"];
} else {
    // Lidar com a situação em que o panel_id não foi encontrado
    echo "Erro ao obter o panel_id do usuário.";
    exit();
}
var_dump($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $coluna = isset($_POST["coluna"]) ? $_POST["coluna"] : null;
    $nomeItem = isset($_POST["nomeItem"]) ? $_POST["nomeItem"] : null;
    $valorItem = isset($_POST["valorItem"]) ? $_POST["valorItem"] : null;
    $tamanhoItem = isset($_POST["tamanhoItem"]) ? $_POST["tamanhoItem"] : null; // Defina como 0 se for null
    $unidade = isset($_POST["unidade"]) ? $_POST["unidade"] : null; // Defina como 0 se for null
    
    // Verifique se as chaves estão definidas antes de usá-las
    if ($coluna !== null && $nomeItem !== null && $valorItem !== null && isset($_FILES["imagemItem"])) {
      
        // Processamento do upload da imagem
        $diretorioUpload = "../uploads/";
        $nomeUnico = uniqid() . "_" . $_FILES["imagemItem"]["name"];
        $caminhoCompleto = $diretorioUpload . $nomeUnico;

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES["imagemItem"]["type"], $allowedMimeTypes) && move_uploaded_file($_FILES["imagemItem"]["tmp_name"], $caminhoCompleto)) {
            echo "Imagem do produto carregada com sucesso.";


// Tratamento de promoção apenas se a imagem for carregada com sucesso
$temPromocao = isset($_POST["temPromocao"]) ? (int)$_POST["temPromocao"] : 0;
$valorPromocao = $temPromocao == 0 ? "" : (isset($_POST["valorPromocao"]) ? $_POST["valorPromocao"] : null);
$tempoPromocao = $temPromocao == 0 ? "" : (isset($_POST["tempoPromocao"]) ? $_POST["tempoPromocao"] : null);
$unidadeTempoPromocao = $temPromocao == 0 ? "" : (isset($_POST["unidadeTempoPromocao"]) ? $_POST["unidadeTempoPromocao"] : null);



// Defina $temPromocao, $valorPromocao, $tempoPromocao e $unidadeTempoPromocao como nulos se necessário
$temPromocao = $temPromocao !== null ? $temPromocao : null;
$valorPromocao = $valorPromocao !== null ? $valorPromocao : null;
$tempoPromocao = $tempoPromocao !== null ? $tempoPromocao : null;
$unidadeTempoPromocao = $unidadeTempoPromocao !== null ? $unidadeTempoPromocao : null;

// Inserção na tabela "itens"
$sqlInserirItens = "INSERT INTO itens (coluna, nomeItem, valorItem, tamanho, unidade, imagem, temPromocao, valorPromocao, tempoPromocao, unidadeTempoPromocao, panel_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmtItens = $conn->prepare($sqlInserirItens);
$stmtItens->bind_param("ssdssssdssi", $coluna, $nomeItem, $valorItem, $tamanhoItem, $unidade, $nomeUnico, $temPromocao, $valorPromocao, $tempoPromocao, $unidadeTempoPromocao, $panel_id);

            if ($stmtItens->execute()) {
                // Obtenha o ID do último item inserido
                $lastItemId = $stmtItens->insert_id;

                if (isset($_POST['medida_multipla'])) {
                    // Verifica se o campo "medidas" está presente e é um array
                    if (isset($_POST['medidas']) && is_array($_POST['medidas'])) {
                        foreach ($_POST['medidas'] as $medida) {
                            // $medida contém o nome da medida
                            $valorMedida = isset($_POST["valor_$medida"]) ? $_POST["valor_$medida"] : null;
            
                            $sqlInserirMedida = "INSERT INTO medidas_multiplas (item_id, medida_nome, medida_valor, panel_id) VALUES (?, ?, ?, ?)";
                            $stmtMedida = $conn->prepare($sqlInserirMedida);
                            $stmtMedida->bind_param("isss", $lastItemId, $medida, $valorMedida, $panel_id);
            
                            if ($stmtMedida->execute()) {
                                echo "Medida adicionada com sucesso.";
                            } else {
                                echo "Erro ao adicionar medida: " . $stmtMedida->error;
                            }
            
                            $stmtMedida->close();
                        }
            
        // Atualização do campo "tamanho" na tabela "itens"
        $tamanhoAtualizado = "medida_multipla"; // Substitua "medida" pela string desejada
        $sqlAtualizarTamanho = "UPDATE itens SET tamanho = ? WHERE id = ?";
        $stmtAtualizarTamanho = $conn->prepare($sqlAtualizarTamanho);
        $stmtAtualizarTamanho->bind_param("si", $tamanhoAtualizado, $lastItemId);
        $stmtAtualizarTamanho->execute();
        $stmtAtualizarTamanho->close();
            
                        echo "Tamanho atualizado com base na medida múltipla.";
                    } else {
                        echo "Erro: Campo 'medidas' ausente ou inválido.";
                    }
                } else {
                    echo "Erro: Campo 'medida_multipla' ausente ou inválido.";
                }


// Processamento dos tamanhos múltiplos
if (isset($_POST['tamanhos_multiplas'])) {
    // Verifica se o campo "tamanhos" está presente e é um array
    if (isset($_POST['tamanhos']) && is_array($_POST['tamanhos'])) {
        foreach ($_POST['tamanhos'] as $tamanhoSelecionado) {
            // Inserção na tabela "tamanhos_multiplos"
            $sqlInserirTamanho = "INSERT INTO tamanhos_multiplos (item_id, nome_tamanho, panel_id) VALUES (?, ?, ?)";
            $stmtTamanho = $conn->prepare($sqlInserirTamanho);
            $stmtTamanho->bind_param("iss", $lastItemId, $tamanhoSelecionado, $panel_id);

            if ($stmtTamanho->execute()) {
                echo "Tamanho adicionado com sucesso: $tamanhoSelecionado.";

                // Processamento dos valores para cada tamanho
                if (isset($_POST["valor_$tamanhoSelecionado"])) {
                    $valorTamanho = $_POST["valor_$tamanhoSelecionado"];

                    // Atualização do campo "valor_tamanho" na tabela "tamanhos_multiplos"
                    $sqlAtualizarValorTamanho = "UPDATE tamanhos_multiplos SET valor_tamanho = ? WHERE item_id = ? AND nome_tamanho = ? AND panel_id = ?";
                    $stmtAtualizarValorTamanho = $conn->prepare($sqlAtualizarValorTamanho);
                    $stmtAtualizarValorTamanho->bind_param("ssis", $valorTamanho, $lastItemId, $tamanhoSelecionado, $panel_id);
                    $stmtAtualizarValorTamanho->execute();
                    $stmtAtualizarValorTamanho->close();

                    echo "Valor do tamanho atualizado com sucesso: $valorTamanho.";

                    // Atualização do campo "unidade" na tabela "itens" se os tamanhos múltiplos foram inseridos
                    $unidadeAtualizada = "tamanho_multiplo";
                    $sqlAtualizarUnidade = "UPDATE itens SET unidade = ? WHERE id = ?";
                    $stmtAtualizarUnidade = $conn->prepare($sqlAtualizarUnidade);
                    $stmtAtualizarUnidade->bind_param("si", $unidadeAtualizada, $lastItemId);
                    $stmtAtualizarUnidade->execute();
                    $stmtAtualizarUnidade->close();
                } else {
                    echo "Aviso: Valor do tamanho não especificado para $tamanhoSelecionado.";
                }
            } else {
                echo "Erro ao adicionar tamanho: " . $stmtTamanho->error;
            }

            $stmtTamanho->close();
        }
    } else {
        echo "Erro: Campo 'tamanhos' ausente ou inválido.";
    }
}



// Verifique se há complementos selecionados no formulário
if (isset($_POST['complementos']) && is_array($_POST['complementos'])) {
    // Concatenar os complementos selecionados separados por vírgula
    $complementosString = implode(', ', $_POST['complementos']);

    // Insira na tabela "complementos_produtos"
    $sqlInserirComplemento = "INSERT INTO complementos_produtos (item_id, complemento_nome, panel_id) VALUES (?, ?, ?)";
    $stmtComplemento = $conn->prepare($sqlInserirComplemento);
    $stmtComplemento->bind_param("isi", $lastItemId, $complementosString, $panel_id);
    $stmtComplemento->execute();
    $stmtComplemento->close();
}



// Verifique se há complementos adicionais selecionados no formulário
if (
    isset($_POST['complementos_adicionais_nome']) && is_array($_POST['complementos_adicionais_nome']) &&
    isset($_POST['complementos_adicionais_valor']) && is_array($_POST['complementos_adicionais_valor'])
) {

    // Certifique-se de que os arrays têm o mesmo número de elementos
    if (count($_POST['complementos_adicionais_nome']) === count($_POST['complementos_adicionais_valor'])) {

        // Iterar sobre os arrays simultaneamente
        foreach (array_map(null, $_POST['complementos_adicionais_nome'], $_POST['complementos_adicionais_valor']) as $complemento) {

            // Obtenha informações do complemento adicional
            $nomeComplementoAdicional = $complemento[0];
            $valorComplementoAdicional = $complemento[1];

            // Insira na tabela "complementos_adicionais_produtos"
            $sqlInserirComplementoAdicionalProduto = "INSERT INTO complementos_adicionais_produtos (item_id, complemento_nome, valor, panel_id) VALUES (?, ?, ?, ?)";
            $stmtComplementoAdicionalProduto = $conn->prepare($sqlInserirComplementoAdicionalProduto);
            $stmtComplementoAdicionalProduto->bind_param("isdi", $lastItemId, $nomeComplementoAdicional, $valorComplementoAdicional, $panel_id);
            $stmtComplementoAdicionalProduto->execute();
            $stmtComplementoAdicionalProduto->close();
        }
    } else {
        // Número de elementos nos arrays não é o mesmo, trate o erro conforme necessário.
    }
}



echo "Item e complementos adicionados com sucesso.";
} else {
    echo "Erro ao adicionar item: " . $stmtItens->error;
}


        } else {
            echo "Erro ao processar o upload da imagem.";
        }
    } else {
        echo "Erro: Dados do formulário incompletos ou inválidos.";
    }
} else {
    echo "Erro no método da requisição: " . $_SERVER["REQUEST_METHOD"];
    var_dump($_POST); // Adicione esta linha para depuração
}
?>
