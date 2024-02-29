<?php
include_once "config/conection.php";

$loja_id = $resultPanelId; // Substitua pelo valor correto

$sqlPedidosPendentes = "SELECT id, nome_cliente, telefone_cliente, metodo_entrega, forma_pagamento, observacoes, data_pedido FROM pedidos WHERE (status = 'pendente' OR status IS NULL) AND loja_id = ? ORDER BY data_pedido DESC";
$stmtPedidosPendentes = $conn->prepare($sqlPedidosPendentes);
$stmtPedidosPendentes->bind_param("i", $loja_id);
$stmtPedidosPendentes->execute();
$resultadoPedidos = $stmtPedidosPendentes->get_result();

$pedidos = [];

while ($pedido = $resultadoPedidos->fetch_assoc()) {
    $pedidos[] = $pedido;
}

header('Content-Type: application/json');
echo json_encode($pedidos);
?>
