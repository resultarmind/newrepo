<?php
// Seu código de conexão ao banco de dados e lógica de consulta aqui
include_once "../config/conection.php";

// Verificar se o ID do item foi fornecido via POST
if(isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];

    // Verifica se é tamanho múltiplo
    $sqlTamanhosMultiplos = "SELECT nome_tamanho, valor_tamanho FROM tamanhos_multiplos WHERE item_id = ?";
    $stmtTamanhosMultiplos = $conn->prepare($sqlTamanhosMultiplos);
    $stmtTamanhosMultiplos->bind_param("i", $itemId);
    $stmtTamanhosMultiplos->execute();
    $resultTamanhosMultiplos = $stmtTamanhosMultiplos->get_result();

    // Se houver tamanhos múltiplos
    if ($resultTamanhosMultiplos->num_rows > 0) {
        $valoresTamanhos = array();
        $nomesTamanhos = array();

        while ($tamanhoMultiplo = $resultTamanhosMultiplos->fetch_assoc()) {
            $valoresTamanhos[] = $tamanhoMultiplo['valor_tamanho'];
            $nomesTamanhos[] = $tamanhoMultiplo['nome_tamanho'];
        }

        $stmtTamanhosMultiplos->close();

    } else {
        // Se não houver tamanhos múltiplos, verifica se é medida múltipla
        $sqlMedidasMultiplas = "SELECT medida_nome, medida_valor FROM medidas_multiplas WHERE item_id = ?";
        $stmtMedidasMultiplas = $conn->prepare($sqlMedidasMultiplas);
        $stmtMedidasMultiplas->bind_param("i", $itemId);
        $stmtMedidasMultiplas->execute();
        $resultMedidasMultiplas = $stmtMedidasMultiplas->get_result();

        // Se houver medidas múltiplas
        if ($resultMedidasMultiplas->num_rows > 0) {
            $valoresTamanhos = array();
            $nomesTamanhos = array();

            while ($medidaMultipla = $resultMedidasMultiplas->fetch_assoc()) {
                $valoresTamanhos[] = $medidaMultipla['medida_valor'];
                $nomesTamanhos[] = $medidaMultipla['medida_nome'];
            }

            $stmtMedidasMultiplas->close();

        }else {
            // Se não houver medidas múltiplas, pegue os valores da tabela padrão
            $sqlPadrao = "SELECT tamanho, valorItem, unidade FROM itens WHERE id = ?";
            $stmtPadrao = $conn->prepare($sqlPadrao);
            $stmtPadrao->bind_param("i", $itemId);
            $stmtPadrao->execute();
            $resultPadrao = $stmtPadrao->get_result();
        
            if ($resultPadrao->num_rows > 0) {
                $rowPadrao = $resultPadrao->fetch_assoc();
                $valoresTamanhos = array();
                $isBebida = false; // Inicialmente, assuma que não é uma bebida
        
                if ($rowPadrao['valorItem'] === null) {
                    $sqlBebida = "SELECT quente, gelada FROM bebida WHERE bebida_id = ?";
                    $stmtBebida = $conn->prepare($sqlBebida);
                    $stmtBebida->bind_param("i", $itemId);
                    $stmtBebida->execute();
                    $resultBebida = $stmtBebida->get_result();
        
                    if ($resultBebida->num_rows > 0) {
                        $rowBebida = $resultBebida->fetch_assoc();
        
                        // Inicializar a variável como uma string vazia
                        $valoresConcatenados = '';
        
                        // Verificar se o valor 'quente' existe e é numérico
                        if (is_numeric($rowBebida['quente'])) {
                            $valoresConcatenados .= $rowBebida['quente'];
                            $isBebida = true;
                        }
        
                        // Adicionar uma vírgula se ambos os valores existirem
                        if (is_numeric($rowBebida['quente']) && is_numeric($rowBebida['gelada'])) {
                            $valoresConcatenados .= ',';
                        }
        
                        // Verificar se o valor 'gelada' existe e é numérico
                        if (is_numeric($rowBebida['gelada'])) {
                            $valoresConcatenados .= $rowBebida['gelada'];
                            $isBebida = true;
                        }
        
                        // Atribuir a string concatenada ao array $valoresTamanhos
                        $valoresTamanhos = $valoresConcatenados;
                    }
                    $stmtBebida->close();
                } else {
                    // Se $valorItem não for nulo na tabela "itens", adicione-o ao array
                    $valoresTamanhos[] = $rowPadrao['valorItem'];
                }
        
                $nomesTamanhos = array($rowPadrao['tamanho'] ?: $rowPadrao['unidade']);
            }
        
            $stmtPadrao->close();
        }
        
        
        
        
        // Agora você pode usar $valorItem para continuar seu código com o valor desejado.
    }        

// Preparar os dados a serem retornados ao JavaScript
$dadosRetorno = array(
    'tamanhos' => $nomesTamanhos,
    'menorValor' => $valoresTamanhos,
    'isBebida' => $isBebida  // Adicionando a informação de bebida aqui
);


    // Fechar a conexão com o banco de dados
    $conn->close();

    // Retornar os dados como JSON
    echo json_encode($dadosRetorno);
} else {
    // Se o ID do item não foi fornecido, retornar um array vazio
    echo json_encode(array());
}
?>