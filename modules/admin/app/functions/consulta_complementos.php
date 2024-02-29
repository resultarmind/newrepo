<?php
// Seu código de conexão ao banco de dados e lógica de consulta aqui
include_once "../config/conection.php";
// Exemplo simples (ajuste conforme necessário)
$itemId = $_POST['itemId'];
$sql = "SELECT * FROM complementos_adicionais_produtos WHERE item_id = $itemId";
$result = $conn->query($sql);

$complementos = array();
while ($row = $result->fetch_assoc()) {
    $complementos[] = $row;
}

echo json_encode($complementos);
?>
