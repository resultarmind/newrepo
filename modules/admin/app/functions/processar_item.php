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
    $tamanhoItem = isset($_POST["tamanhoItem"]) ? $_POST["tamanhoItem"] : null; // Defina como 0 se for null

    // Verifique se as chaves estão definidas antes de usá-las
    if ($coluna !== null && $nomeItem !== null && isset($_FILES["imagemItem"])) {
        // Processamento do upload da imagem
        $diretorioUpload = "../uploads/";
        $nomeUnico = uniqid() . "_" . $_FILES["imagemItem"]["name"];
        $caminhoCompleto = $diretorioUpload . $nomeUnico;

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES["imagemItem"]["type"], $allowedMimeTypes) && move_uploaded_file($_FILES["imagemItem"]["tmp_name"], $caminhoCompleto)) {
            echo "Imagem do produto carregada com sucesso.";

            // Inserção na tabela "itens"
            $sqlInserirItens = "INSERT INTO itens (coluna, nomeItem, imagem, panel_id) VALUES (?, ?, ?, ?)";
            $stmtItens = $conn->prepare($sqlInserirItens);
            $stmtItens->bind_param("sssi", $coluna, $nomeItem, $nomeUnico, $panel_id);
            if ($stmtItens->execute()) {
                // Item inserido com sucesso, obtenha o ID inserido
                $idInserido = mysqli_insert_id($conn);
                
                // Redirecione para a página "add_prod_2.php" com os parâmetros
                header("Location: ../add_prod_2.php?panel_id=$panel_id&id=$idInserido");
                exit();
            } else {
                echo "Erro ao inserir o item: " . $stmtItens->error;
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
