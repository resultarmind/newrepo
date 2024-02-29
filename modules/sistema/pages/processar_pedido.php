<?php
include_once "../includes/connection.php";

date_default_timezone_set('America/Sao_Paulo');

try {
    $conn->autocommit(false);

    if (!isset($_POST['loja_id'], $_POST['nome'], $_POST['telefone'], $_POST['metodo-entrega'], $_POST['forma-pagamento'], $_POST['observacoes'], $_POST['totalItens'])) {
        throw new Exception("Dados do formulário ausentes");
    }

// Receber dados do formulário e carrinho
$loja_id = $_POST['loja_id'];
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$metodoEntrega = $_POST['metodo-entrega'];
$endereco = $_POST['endereco'] ?? null;
$bairro = $_POST['bairro'] ?? null;
$numero = $_POST['numero'] ?? null;
$formaPagamento = $_POST['forma-pagamento'];
$observacoes = $_POST['observacoes'];
$totalItens = $_POST['totalItens'];
$troco = $_POST['troco-para-quanto'];

// Exibir os valores para depuração
echo "loja_id: ";
var_dump($loja_id);
echo "<br>";

echo "nome: ";
var_dump($nome);
echo "<br>";

echo "telefone: ";
var_dump($telefone);
echo "<br>";

echo "metodoEntrega: ";
var_dump($metodoEntrega);
echo "<br>";

echo "endereco: ";
var_dump($endereco);
echo "<br>";

echo "bairro: ";
var_dump($bairro);
echo "<br>";

echo "numero: ";
var_dump($numero);
echo "<br>";

echo "formaPagamento: ";
var_dump($formaPagamento);
echo "<br>";

echo "observacoes: ";
var_dump($observacoes);
echo "<br>";

echo "totalItens: ";
var_dump($totalItens);
echo "<br>";

echo "troco: ";
var_dump($troco);
echo "<br>";

    if (!is_numeric($totalItens) || intval($totalItens) < 1) {
        throw new Exception("O campo 'totalItens' deve ser um número inteiro maior que zero");
    }

    // Preparar a declaração SQL para o pedido
    $dataPedido = date('Y-m-d H:i:s');
    $sqlPedido = "INSERT INTO pedidos (loja_id, nome_cliente, telefone_cliente, metodo_entrega, endereco_entrega, bairro_entrega, numero_entrega, forma_pagamento, observacoes, data_pedido, troco) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtPedido = $conn->prepare($sqlPedido);
    $stmtPedido->bind_param("issssssssss", $loja_id, $nome, $telefone, $metodoEntrega, $endereco, $bairro, $numero, $formaPagamento, $observacoes, $dataPedido, $troco);

    
    if ($stmtPedido->execute()) {
        $pedidoId = $conn->insert_id;

        // Preparar a declaração SQL para o item
        $sqlItem = "INSERT INTO itens_pedido (pedido_id, nome_item, quantidade, tamanho, complementos, observacao, preco) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtItem = $conn->prepare($sqlItem);

        for ($i = 0; $i < $totalItens; $i++) {
            $itemKey = 'item_' . $i;
            $carrinhoItem = json_decode($_POST[$itemKey], true);

            // Atribuir valores aos parâmetros do item
            $stmtItem->bind_param("isdsssd", $pedidoId, $carrinhoItem['itemName'], $carrinhoItem['itemQuantity'], $carrinhoItem['itemSize'], $carrinhoItem['itemComplementos'], $carrinhoItem['itemObservation'], $carrinhoItem['itemPrice']);

            $stmtItem->execute();

            if ($stmtItem->errno) {
                throw new Exception("Erro ao inserir item no pedido: " . $stmtItem->error);
            }
        }

        // Commit da transação se tudo ocorrer bem
        $conn->commit();

        // Redirecionar para a página success.php com o ID do pedido na URL
        header("Location: success.php?pedido_id=" . $pedidoId);
        exit;
    } else {
        $conn->rollback();
        throw new Exception("Erro ao inserir pedido: " . $stmtPedido->error);
    }

    $stmtPedido->close();
    $stmtItem->close();
    $conn->close();
} catch (Exception $e) {
    // Log do erro em vez de exibir diretamente na página
    error_log("Erro: " . $e->getMessage());
    // Exibir uma mensagem genérica para o usuário
    echo "Ocorreu um erro ao processar o pedido. Por favor, tente novamente mais tarde.";
}
?>
