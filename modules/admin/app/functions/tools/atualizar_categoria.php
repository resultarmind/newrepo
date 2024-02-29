<?php
session_start();
include_once "../../config/conection.php";

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: ../../login/login.php");
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $categoriaId = $_POST["id"];
    $nomeCategoria = $_POST["nome_categoria"];
    $tamanhoColuna = $_POST["tamanho_coluna"];
    // Adicione outros campos conforme necessário

    // Query para atualizar os detalhes da categoria no banco de dados
    $sql = "UPDATE categorias SET nome_categoria = '$nomeCategoria', tamanho_coluna = $tamanhoColuna WHERE id = $categoriaId";

    if ($conn->query($sql) === TRUE) {
        // Redireciona de volta à página onde a atualização foi feita
        header("Location: ../../view_categorias.php");
        exit();
    } else {
        echo "Erro ao atualizar categoria: " . $conn->error;
    }
} else {
    echo "Requisição inválida.";
}
?>
