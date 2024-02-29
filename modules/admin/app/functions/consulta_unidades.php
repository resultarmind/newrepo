<?php
// Inclui o arquivo de conexão ao banco de dados
include_once "../config/conection.php";

// Verifica se o itemId foi enviado pelo método POST
if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];

    // Prepara a consulta SQL para evitar injeções SQL
    $stmt = $conn->prepare("SELECT unidade FROM itens WHERE item_id = ?");
    $stmt->bind_param("s", $itemId); // "i" indica que o parâmetro é um inteiro

    
// Executa a consulta
if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Retorna apenas o valor da unidade
        echo json_encode(array('unidade' => $row['unidade']));
    } else {
        // Retorna um valor nulo se não encontrar a unidade
        echo json_encode(array('unidade' => null));
    }
} else {
    // Retorna um erro se a execução da consulta falhar
    echo json_encode(array('erro' => 'Erro ao executar a consulta.'));
}


    // Fecha o statement
    $stmt->close();
} else {
    // Retorna um erro se o itemId não for fornecido
    echo json_encode(array('erro' => 'ID do item não fornecido.'));
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
