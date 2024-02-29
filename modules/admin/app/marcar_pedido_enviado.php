<?php
include_once "config/conection.php";

if (isset($_GET['pedido_id'])) {
    $pedido_id = $_GET['pedido_id'];

    // Atualizar o status do pedido para "enviado"
    $sqlAtualizarStatus = "UPDATE pedidos SET status = 'enviado' WHERE id = ?";
    $stmtAtualizarStatus = $conn->prepare($sqlAtualizarStatus);
    $stmtAtualizarStatus->bind_param("i", $pedido_id);

    if ($stmtAtualizarStatus->execute()) {
        // Redirecionar de volta para a página anterior (index.php)
        header("Location: index.php");
        exit();
    } else {
        // Exibir uma mensagem de erro, se necessário
        echo "Erro ao marcar o pedido como enviado.";
    }

    $stmtAtualizarStatus->close();
} else {
    // Pedido_id não fornecido, exibir mensagem de erro ou redirecionar para a página adequada
    echo "Pedido_id não fornecido.";
}
?>
