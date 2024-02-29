<?php
include_once "../includes/connection.php";

if (isset($_GET['pedido_id'])) {
    $pedidoId = $_GET['pedido_id'];

    $sql = "SELECT tempo_producao, tempo_envio FROM pedidos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pedidoId);
    $stmt->execute();
    $stmt->bind_result($tempoProducao, $tempoEnvio);

    if ($stmt->fetch()) {
        $response = array(
            'tempo_producao' => $tempoProducao,
            'tempo_envio' => $tempoEnvio
        );
        echo json_encode($response);
    } else {
        $response = array('error' => 'Pedido não encontrado');
        echo json_encode($response);
    }

    $stmt->close();
    $conn->close();
} else {
    $response = array('error' => 'ID do pedido não especificado');
    echo json_encode($response);
}
?>