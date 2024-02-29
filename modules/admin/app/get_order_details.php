<?php
include_once "config/conection.php";

// Ensure that the pedido_id parameter is set
if (isset($_GET['pedido_id'])) {
    $pedido_id = $_GET['pedido_id'];

    // Fetch order details and customer data
    $sqlOrderDetails = "SELECT nome_cliente, forma_pagamento, data_pedido, telefone_cliente, metodo_entrega, bairro_entrega, endereco_entrega, numero_entrega, tempo_producao, tempo_envio FROM pedidos WHERE id = ?";
    $stmtOrderDetails = $conn->prepare($sqlOrderDetails);
    $stmtOrderDetails->bind_param("i", $pedido_id);
    $stmtOrderDetails->execute();
    $resultOrderDetails = $stmtOrderDetails->get_result();

    // Check if the order exists
    if ($resultOrderDetails->num_rows > 0) {
        $orderData = $resultOrderDetails->fetch_assoc();

        // Fetch items associated with the order
        $sqlItems = "SELECT nome_item, quantidade, tamanho, complementos, observacao, preco FROM itens_pedido WHERE pedido_id = ?";
        $stmtItems = $conn->prepare($sqlItems);
        $stmtItems->bind_param("i", $pedido_id);
        $stmtItems->execute();
        $resultItems = $stmtItems->get_result();

        // Check if items exist
        if ($resultItems->num_rows > 0) {
            $items = array();

            while ($item = $resultItems->fetch_assoc()) {
                $items[] = $item;
            }

            // Add items to the order data
            $orderData['itens'] = $items;
        } else {
            // If no items are found, set an empty array
            $orderData['itens'] = array();
        }

        // Return order details including items as JSON
        echo json_encode($orderData);
    } else {
        // Handle the case where the order does not exist
        echo json_encode(["error" => "Order not found"]);
    }

    $stmtOrderDetails->close();
    $stmtItems->close();
} else {
    // Handle the case where pedido_id parameter is not set
    echo json_encode(["error" => "Pedido ID not provided"]);
}

$conn->close();
?>
