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

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados do formulário
    $categoria = $_POST["categoria"];
    $tamanho = $_POST["tamanho"];

    // Prepare a declaração SQL para a inserção
    $sql = "INSERT INTO categorias (nome_categoria, tamanho_coluna, panel_id) VALUES ('$categoria', '$tamanho', '$panel_id')";

    // Execute a declaração SQL
    if ($conn->query($sql) === TRUE) {
        // Redirecionar para a página anterior
        $prevPage = $_SERVER['HTTP_REFERER'];
        header("Location: $prevPage");
        exit();
    } else {
        // Lide com erros durante a inserção
        echo "Erro ao inserir dados: " . $conn->error;
    }
}

?>
