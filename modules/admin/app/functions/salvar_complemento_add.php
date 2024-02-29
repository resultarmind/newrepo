<?php
session_start();
include_once "../config/conection.php";

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
} else {
    // Lidar com a situação em que o panel_id não foi encontrado
    echo "Erro ao obter o panel_id do usuário.";
    exit();
}

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados do formulário
    $novoComplemento = $_POST["novoComplemento"];
    $valorComplementoAdd = $_POST["valorComplementoAdd"];

    // Prepare a declaração SQL para a inserção
    $sql = "INSERT INTO complementos_adicionais (nome_complemento, valor, panel_id) VALUES ('$novoComplemento', '$valorComplementoAdd', '$panel_id')";

    // Execute a declaração SQL
    if ($conn->query($sql) === TRUE) {
        // Redirecionar para a página anterior
        $prevPage = $_SERVER['HTTP_REFERER'];
        header("Location: $prevPage");
        exit();
    } else {
        // Lide com erros durante a inserção
        echo "Erro ao adicionar complemento";
    }

    // Feche a conexão com o banco de dados
}
?>
