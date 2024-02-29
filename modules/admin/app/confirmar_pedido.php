<?php
include_once "config/conection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id'])) {
    $pedidoId = $_POST['pedido_id'];
    $prioridade = $_POST['prioridade'];
    $tempoProducao = ($_POST['tempoProducao'] === 'custom') ? $_POST['customTempoProducaoInput'] : $_POST['tempoProducao'];
    $tempoEntrega = ($_POST['tempoEntrega'] === 'custom') ? $_POST['customTempoEntregaInput'] : $_POST['tempoEntrega'];


    var_dump($_POST);
    // Inicia a transação
    $conn->begin_transaction();

    // Atualiza os tempos no banco de dados
    $sqlAtualizarTempos = "UPDATE pedidos SET prioridade = ?, tempo_producao = ?, tempo_envio = ? WHERE id = ?";
    $stmtAtualizarTempos = $conn->prepare($sqlAtualizarTempos);
    $stmtAtualizarTempos->bind_param("sssi", $prioridade, $tempoProducao, $tempoEntrega, $pedidoId);

    // Verifica se a atualização dos tempos foi bem-sucedida
    if ($stmtAtualizarTempos->execute()) {
        // Atualiza o status do pedido para 'producao'
        $sqlAtualizarStatus = "UPDATE pedidos SET status = 'producao' WHERE id = ?";
        $stmtAtualizarStatus = $conn->prepare($sqlAtualizarStatus);
        $stmtAtualizarStatus->bind_param("i", $pedidoId);

        // Verifica se a atualização do status foi bem-sucedida
        if ($stmtAtualizarStatus->execute()) {
            // Confirma a transação
            $conn->commit();

            // Redireciona de volta para index.php
            header("Location: index.php");
            exit();
        } else {
            // Se houver um erro, reverte a transação
            $conn->rollback();
            echo "Erro ao atualizar o status do pedido: " . $stmtAtualizarStatus->error;
        }

        $stmtAtualizarStatus->close();
    } else {
        // Se houver um erro, reverte a transação
        $conn->rollback();
        echo "Erro ao atualizar os tempos: " . $stmtAtualizarTempos->error;
    }

    $stmtAtualizarTempos->close();
} else {
    echo "Ação inválida ou pedido não especificado.";
}

$conn->close();
?>

