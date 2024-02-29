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
    if (isset($_POST["id"]) && isset($_POST["nome_medida"])) {
        $medida_id = $_POST["id"];
        $nome_medida = $_POST["nome_medida"];

        // Recupere o panel_id do usuário do banco de dados
        $username = $_SESSION["username"];
        $sqlPanelId = "SELECT panel_id FROM usuarios WHERE username = '$username'";
        $resultPanelId = $conn->query($sqlPanelId);

        if ($resultPanelId->num_rows > 0) {
            $rowPanelId = $resultPanelId->fetch_assoc();
            $panel_id = $rowPanelId["panel_id"];

            // Verifique se o complemento pertence ao usuário antes de atualizar
            $sqlCheckOwnership = "SELECT id FROM medidas WHERE panel_id = $panel_id AND id = $medida_id";
            $resultCheckOwnership = $conn->query($sqlCheckOwnership);

            if ($resultCheckOwnership->num_rows > 0) {
                // Atualize as informações do complemento no banco de dados
                $sqlUpdate = "UPDATE medidas SET nome_medida = '$nome_medida' WHERE id = $medida_id";
                $resultUpdate = $conn->query($sqlUpdate);

                if ($resultUpdate) {
                    // Redirecione para a página de visualização de complementos após a atualização
                    header("Location: ../../view_medidas.php");
                    exit();
                } else {
                    echo "Erro ao atualizar o complemento.";
                }
            } else {
                echo "Você não tem permissão para editar esta medida.";
            }
        } else {
            echo "Panel ID do usuário não encontrado.";
        }
    } else {
        echo "Campos obrigatórios não fornecidos.";
    }
} else {
    // Se a requisição não for do tipo POST, redirecione para a página apropriada
    header("Location: ../../view_medidas.php");
    exit();
}
?>
