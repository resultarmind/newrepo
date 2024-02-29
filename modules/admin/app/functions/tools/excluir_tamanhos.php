<?php
session_start();

// Verifica se o ID foi fornecido na URL
if (isset($_GET['id'])) {
    $complementoId = $_GET['id'];

    include_once "../../config/conection.php";

    // Verifica se o usuário está autenticado
    if (!isset($_SESSION["username"])) {
        header("Location: ../../login/login.php");
        exit();
    }

    // Recupera o panel_id do usuário do banco de dados
    $username = $_SESSION["username"];
    $sqlPanelId = "SELECT panel_id FROM usuarios WHERE username = '$username'";
    $resultPanelId = $conn->query($sqlPanelId);

    if ($resultPanelId->num_rows > 0) {
        $rowPanelId = $resultPanelId->fetch_assoc();
        $panel_id = $rowPanelId["panel_id"];

        // Verifica a propriedade do complemento antes de excluí-lo
        $sqlCheckOwnership = "SELECT id FROM tamanhos WHERE panel_id = $panel_id AND id = $complementoId";
        $resultCheckOwnership = $conn->query($sqlCheckOwnership);

        if ($resultCheckOwnership->num_rows > 0) {
            // Query para excluir o complemento do banco de dados
            $sqlDelete = "DELETE FROM tamanhos WHERE id = $complementoId";

            if ($conn->query($sqlDelete) === TRUE) {
                // Redireciona de volta à página onde a exclusão foi feita
                header("Location: ../../view_tamanhos.php");
                exit();
            } else {
                echo "Erro ao excluir tamanho: " . $conn->error;
            }
        } else {
            echo "Você não tem permissão para excluir este tamanho.";
        }
    } else {
        echo "Panel ID do usuário não encontrado.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    echo "ID da tamanho não fornecido.";
}
?>
