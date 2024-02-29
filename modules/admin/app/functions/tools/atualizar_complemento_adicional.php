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
    if (isset($_POST["id"], $_POST["nome_complemento"], $_POST["valor"])) {
        $complemento_id = $_POST["id"];
        $nome_complemento = $_POST["nome_complemento"];
        $valor = str_replace(['R$'], '', $_POST["valor"]); // Remova "R$" e "," do valor

        // Recupere o panel_id do usuário do banco de dados
        $username = $_SESSION["username"];
        $sqlPanelId = "SELECT panel_id FROM usuarios WHERE username = '$username'";
        $resultPanelId = $conn->query($sqlPanelId);

        if ($resultPanelId->num_rows > 0) {
            $rowPanelId = $resultPanelId->fetch_assoc();
            $panel_id = $rowPanelId["panel_id"];

            // Verifique se o complemento adicional pertence ao usuário antes de atualizar
            $sqlCheckOwnership = "SELECT id FROM complementos_adicionais WHERE panel_id = $panel_id AND id = $complemento_id";
            $resultCheckOwnership = $conn->query($sqlCheckOwnership);

            if ($resultCheckOwnership->num_rows > 0) {
                // Atualize as informações do complemento adicional no banco de dados
                $sqlUpdate = "UPDATE complementos_adicionais SET nome_complemento = ?, valor = ? WHERE id = ? AND panel_id = ?";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bind_param("ssii", $nome_complemento, $valor, $complemento_id, $panel_id);

                if ($stmtUpdate->execute()) {
                    // Redirecione para a página de visualização de complementos adicionais após a atualização
                    header("Location: ../../view_complementos_adicionais.php");
                    exit();
                } else {
                    echo "Erro ao atualizar o complemento adicional: " . $stmtUpdate->error;
                }

                $stmtUpdate->close();
            } else {
                echo "Você não tem permissão para editar este complemento adicional.";
            }
        } else {
            echo "Panel ID do usuário não encontrado.";
        }
    } else {
        echo "Campos obrigatórios não fornecidos.";
    }
} else {
    // Se a requisição não for do tipo POST, redirecione para a página apropriada
    header("Location: ../../view_complementos_adicionais.php");
    exit();
}
?>
