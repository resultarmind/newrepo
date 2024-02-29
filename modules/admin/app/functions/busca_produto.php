<?php
include_once "../config/conection.php";

$response = ['success' => false, 'message' => '', 'data' => []];
header('Content-Type: application/json');

if(isset($_POST['pesquisa'])) {
    $pesquisa = mysqli_real_escape_string($conn, $_POST['pesquisa']);

    $sql = "SELECT i.*, c.complemento_nome, c.quantidade
            FROM itens i
            LEFT JOIN complementos_produtos c ON i.id = c.item_id
            WHERE i.panel_id = $loja_id AND (i.nomeItem LIKE '%$pesquisa%' OR i.descricao LIKE '%$pesquisa%')";

    $result = $conn->query($sql);

    if($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $response['success'] = true;
        $response['data'] = $data;
    } else {
        $response['message'] = 'Erro na consulta: ' . $conn->error;
    }
} else {
    $response['message'] = 'Nenhum termo de pesquisa fornecido.';
}

echo json_encode($response);
?>
