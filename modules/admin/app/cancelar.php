<?php
include_once "config/conexao.php"; // Certifique-se de incluir seu arquivo de conexão

// Verifica se o ID do pedido está presente na solicitação (por exemplo, via POST)
if (isset($_POST['pedido_id'])) {
    $pedidoId = $_POST['pedido_id'];

    // Prepara a instrução SQL DELETE
    $sqlExcluirPedido = "DELETE FROM pedidos WHERE id = ?";

    // Prepara e executa a instrução
    $stmtExcluirPedido = $conn->prepare($sqlExcluirPedido);
    $stmtExcluirPedido->bind_param("i", $pedidoId);

    if ($stmtExcluirPedido->execute()) {
        // Se a exclusão for bem-sucedida, você pode redirecionar para uma página de confirmação, por exemplo
        header("Location: confirmacao_exclusao.php");
        exit;
    } else {
        // Se ocorrer um erro na exclusão, você pode redirecionar para uma página de erro ou tratamento adequada
        header("Location: erro_exclusao.php");
        exit;
    }

    // Fecha a declaração preparada
    $stmtExcluirPedido->close();
} else {
    // Se o ID do pedido não estiver presente na solicitação, redirecione para uma página de erro ou tratamento adequada
    header("Location: erro.php");
    exit;
}

// Fecha a conexão com o banco de dados (não necessário se você estiver usando MySQLi)
$conn->close();
?>
