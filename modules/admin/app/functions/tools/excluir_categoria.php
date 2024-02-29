<?php
session_start();

// Verifica se o ID foi fornecido na URL
if (isset($_GET['id'])) {
    $categoriaId = $_GET['id'];

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

        // Verifica a propriedade da categoria antes de excluí-la
        $sqlCheckOwnership = "SELECT id FROM categorias WHERE panel_id = $panel_id AND id = $categoriaId";
        $resultCheckOwnership = $conn->query($sqlCheckOwnership);

        if ($resultCheckOwnership->num_rows > 0) {
            // Query para excluir a categoria do banco de dados
            $sqlDelete = "DELETE FROM categorias WHERE id = $categoriaId";

            if ($conn->query($sqlDelete) === TRUE) {
                // Redireciona de volta à página onde a exclusão foi feita
                header("Location: ../../view_categorias.php");
                exit();
            } else {
                echo "Erro ao excluir categoria: " . $conn->error;
            }
        } else {
            echo "Você não tem permissão para excluir esta categoria.";
        }
    } else {
        echo "Panel ID do usuário não encontrado.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    echo "ID da categoria não fornecido.";
}
?>
