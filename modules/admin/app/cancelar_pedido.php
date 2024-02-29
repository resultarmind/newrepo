<?php
include_once "config/conection.php";

$data = json_decode(file_get_contents('php://input'), true);
$pedidoId = $data['pedidoId'] ?? null;

if ($pedidoId) {
    $stmt = $conn->prepare("UPDATE pedidos SET status = 'cancelado' WHERE id = ?");
    $stmt->bind_param("i", $pedidoId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID do pedido não fornecido']);
}
?>
