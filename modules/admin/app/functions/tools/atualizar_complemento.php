<?php
session_start();
include_once "../../config/conection.php";

// Verifique se o usuário está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: ../../login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se todos os campos necessários estão presentes
    if (isset($_POST["id"]) && isset($_POST["nome_complemento"])) {
        $complemento_id = $_POST["id"];
        $nome_complemento = $_POST["nome_complemento"];

        // Recupere o panel_id do usuário do banco de dados
        $username = $_SESSION["username"];
        $sqlPanelId = "SELECT panel_id FROM usuarios WHERE username = '$username'";
        $resultPanelId = $conn->query($sqlPanelId);

        if ($resultPanelId->num_rows > 0) {
            $rowPanelId = $resultPanelId->fetch_assoc();
            $panel_id = $rowPanelId["panel_id"];

            // Verifique se o complemento pertence ao usuário antes de atualizar
            $sqlCheckOwnership = "SELECT id FROM complementos WHERE panel_id = $panel_id AND id = $complemento_id";
            $resultCheckOwnership = $conn->query($sqlCheckOwnership);

            if ($resultCheckOwnership->num_rows > 0) {
                // Atualize as informações do complemento no banco de dados
                $sqlUpdate = "UPDATE complementos SET nome_complemento = '$nome_complemento' WHERE id = $complemento_id";
                $resultUpdate = $conn->query($sqlUpdate);

                if ($resultUpdate) {
                    // Redirecione para a página de visualização de complementos após a atualização
                    header("Location: ../../view_complementos.php");
                    exit();
                } else {
                    echo "Erro ao atualizar o complemento.";
                }
            } else {
                echo "Você não tem permissão para editar este complemento.";
            }
        } else {
            echo "Panel ID do usuário não encontrado.";
        }
    } else {
        echo "Campos obrigatórios não fornecidos.";
    }
} else {
    // Se a requisição não for do tipo POST, redirecione para a página apropriada
    header("Location: ../../view_complementos.php");
    exit();
}
?>
