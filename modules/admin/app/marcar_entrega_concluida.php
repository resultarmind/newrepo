<?php
include_once "config/conection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["pedido_id"])) {
    $pedido_id = $_GET["pedido_id"];

    // Atualiza o status do pedido para "finalizado"
    $sqlAtualizarStatus = "UPDATE pedidos SET status = 'finalizado' WHERE id = ?";
    $stmtAtualizarStatus = $conn->prepare($sqlAtualizarStatus);
    $stmtAtualizarStatus->bind_param("i", $pedido_id);

    if ($stmtAtualizarStatus->execute()) {
        // Redireciona de volta para a página que exibe os pedidos enviados
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao atualizar o status do pedido: " . $stmtAtualizarStatus->error;
    }

    $stmtAtualizarStatus->close();
} else {
    echo "Parâmetros inválidos.";
}
?>
