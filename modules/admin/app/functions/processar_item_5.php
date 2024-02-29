<?php
// Conecte-se ao banco de dados (use a sua conexão existente)
include_once "../config/conection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os valores do formulário
    $panel_id = $_POST["panel_id"];
    $id = $_POST["id"];
    $opcao_gelado = $_POST["gelado_option"];
    $opcao_acucar = isset($_POST["acucar_option"]) ? $_POST["acucar_option"] : array();
    $valor_bebida_gelada = $_POST["valor_bebida_gelada"];
    $valor_bebida_quente = $_POST["valor_bebida_quente"];
    $tamanho_bebida = $_POST["tamanho_bebida"];

    // Exibindo os valores recuperados para depuração
    var_dump($_POST);

    // Verifique se a opção "gelado_e_quente" foi selecionada
    if ($opcao_gelado == "gelado_e_quente") {
        // Insira ou atualize na tabela "itens" (dependendo se já existe um registro)
        $sqlAtualiza = "UPDATE itens SET unidade = ? WHERE id = ?";
        $stmtAtualiza = $conn->prepare($sqlAtualiza);
        $stmtAtualiza->bind_param("si", $tamanho_bebida, $id);

        if (!$stmtAtualiza->execute()) {
            // Exibir erro se a execução falhar
            var_dump($stmtAtualiza->error);
        }
        $stmtAtualiza->close();

        $sqlInsert = "INSERT INTO bebida SET bebida_id = ?, quente = ?, gelada = ?, panel_id = ?";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("iiii", $id, $valor_bebida_quente, $valor_bebida_gelada, $panel_id);

        if (!$stmtInsert->execute()) {
            // Exibir erro se a execução falhar
            var_dump($stmtInsert->error);
        }
        $stmtInsert->close();

        // Processar as opções de açúcar
        $acucarOptions = [
            "sem_acucar" => [0, 0, 1, 0],
            "com_acucar" => [1, 0, 0, 0],
            "com_acucar_reduzido" => [0, 1, 0, 0],
            "com_as_duas_opcoes" => [0, 0, 0, 1]
        ];

        if (isset($acucarOptions[$opcao_acucar[0]])) {
            $acucarValues = $acucarOptions[$opcao_acucar[0]];
            $acucarInsere = "UPDATE bebida SET acucar = ?, pouco_acucar = ?, sem_acucar = ?, double_option_acucar = ? WHERE bebida_id = ?";
            $stmtAcucar = $conn->prepare($acucarInsere);
            $stmtAcucar->bind_param("iiiii", $acucarValues[0], $acucarValues[1], $acucarValues[2], $acucarValues[3], $id);

            if (!$stmtAcucar->execute()) {
                // Exibir erro se a execução falhar
                var_dump($stmtAcucar->error);
            }
            $stmtAcucar->close();
        }

        // Redireciona para a próxima página
        header("Location: ../view_produto.php");
        exit; // Certifique-se de sair após o redirecionamento
    }

    else if ($opcao_gelado == "somente_gelado") {
        // Insira ou atualize na tabela "itens" (dependendo se já existe um registro)
        $sqlAtualiza = "UPDATE itens SET unidade = ? WHERE id = ?";
        $stmtAtualiza = $conn->prepare($sqlAtualiza);
        $stmtAtualiza->bind_param("si", $tamanho_bebida, $id);

        if (!$stmtAtualiza->execute()) {
            // Exibir erro se a execução falhar
            var_dump($stmtAtualiza->error);
        }
        $stmtAtualiza->close();

        $sqlInsert = "INSERT INTO bebida SET bebida_id = ?, gelada = ?, panel_id = ?";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("iii", $id, $valor_bebida_gelada, $panel_id);

        if (!$stmtInsert->execute()) {
            // Exibir erro se a execução falhar
            var_dump($stmtInsert->error);
        }
        $stmtInsert->close();

        // Processar as opções de açúcar
        $acucarOptions = [
            "sem_acucar" => [0, 0, 1, 0],
            "com_acucar" => [1, 0, 0, 0],
            "com_acucar_reduzido" => [0, 1, 0, 0],
            "com_as_duas_opcoes" => [0, 0, 0, 1]
        ];

        if (isset($acucarOptions[$opcao_acucar[0]])) {
            $acucarValues = $acucarOptions[$opcao_acucar[0]];
            $acucarInsere = "UPDATE bebida SET acucar = ?, pouco_acucar = ?, sem_acucar = ?, double_option_acucar = ? WHERE bebida_id = ?";
            $stmtAcucar = $conn->prepare($acucarInsere);
            $stmtAcucar->bind_param("iiiii", $acucarValues[0], $acucarValues[1], $acucarValues[2], $acucarValues[3], $id);

            if (!$stmtAcucar->execute()) {
                // Exibir erro se a execução falhar
                var_dump($stmtAcucar->error);
            }
            $stmtAcucar->close();
        }

        // Redireciona para a próxima página
        header("Location: ../view_produto.php");
        exit; // Certifique-se de sair após o redirecionamento
    }

    else if ($opcao_gelado == "somente_quente") {
        // Insira ou atualize na tabela "itens" (dependendo se já existe um registro)
        $sqlAtualiza = "UPDATE itens SET unidade = ? WHERE id = ?";
        $stmtAtualiza = $conn->prepare($sqlAtualiza);
        $stmtAtualiza->bind_param("si", $tamanho_bebida, $id);

        if (!$stmtAtualiza->execute()) {
            // Exibir erro se a execução falhar
            var_dump($stmtAtualiza->error);
        }
        $stmtAtualiza->close();

        $sqlInsert = "INSERT INTO bebida SET bebida_id = ?, quente = ?, panel_id = ?";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("iii", $id, $valor_bebida_quente, $panel_id);

        if (!$stmtInsert->execute()) {
            // Exibir erro se a execução falhar
            var_dump($stmtInsert->error);
        }
        $stmtInsert->close();

        // Processar as opções de açúcar
        $acucarOptions = [
            "sem_acucar" => [0, 0, 1, 0],
            "com_acucar" => [1, 0, 0, 0],
            "com_acucar_reduzido" => [0, 1, 0, 0],
            "com_as_duas_opcoes" => [0, 0, 0, 1]
        ];

        if (isset($acucarOptions[$opcao_acucar[0]])) {
            $acucarValues = $acucarOptions[$opcao_acucar[0]];
            $acucarInsere = "UPDATE bebida SET acucar = ?, pouco_acucar = ?, sem_acucar = ?, double_option_acucar = ? WHERE bebida_id = ?";
            $stmtAcucar = $conn->prepare($acucarInsere);
            $stmtAcucar->bind_param("iiiii", $acucarValues[0], $acucarValues[1], $acucarValues[2], $acucarValues[3], $id);

            if (!$stmtAcucar->execute()) {
                // Exibir erro se a execução falhar
                var_dump($stmtAcucar->error);
            }
            $stmtAcucar->close();
        }

        // Redireciona para a próxima página
        header("Location: ../view_produto.php?success=1");
        exit; // Certifique-se de sair após o redirecionamento
    }

}

// Feche a conexão com o banco de dados, se necessário
$conn->close();
?>
