<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $panel_id = $_POST["panel_id"];
    $id = $_POST["id"];
    $tipoItem = $_POST["tipoItem"];
    $valorItem = $_POST["valorItem"];

    // Conecte-se ao banco de dados (use a sua conexão existente)
    include_once "../config/conection.php";

    if ($tipoItem == "bebida") {
        // Redireciona para add_prod_5.php
        header("Location: ../add_prod_5.php?id=$id&panel_id=$panel_id");
        exit; // Certifique-se de sair após o redirecionamento
    }

    // Verifique o tipo de item selecionado
    elseif ($tipoItem == "item_simples") {
        // Caso seja um item simples, realize o UPDATE na tabela "itens"
        $sqlUpdateItemSimples = "UPDATE itens SET valorItem = ?, tamanho = ? WHERE id = ?";
        $stmtUpdateItemSimples = $conn->prepare($sqlUpdateItemSimples);
        $tamanhoDefinido = "Normal";
        $stmtUpdateItemSimples->bind_param("dsi", $valorItem, $tamanhoDefinido, $id);

        if ($stmtUpdateItemSimples->execute()) {
            // Atualização bem-sucedida
            echo "Item simples atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar item simples: " . $stmtUpdateItemSimples->error;
        }
    } elseif ($tipoItem == "item_com_medida") {
        // Verifica se o campo "medidas" está presente e é um array
        if (isset($_POST['medidas']) && is_array($_POST['medidas'])) {
            foreach ($_POST['medidas'] as $medida) {
                // $medida contém o nome da medida
                $valorMedida = isset($_POST["valor_$medida"]) ? $_POST["valor_$medida"] : null;

                $sqlInserirMedida = "INSERT INTO medidas_multiplas (item_id, medida_nome, medida_valor, panel_id) VALUES (?, ?, ?, ?)";
                $stmtMedida = $conn->prepare($sqlInserirMedida);
                $stmtMedida->bind_param("isss", $id, $medida, $valorMedida, $panel_id);

                if ($stmtMedida->execute()) {
                    echo "Medida adicionada com sucesso.";
                } else {
                    echo "Erro ao adicionar medida: " . $stmtMedida->error;
                }

                $stmtMedida->close();
            }

            // Atualização do campo "tamanho" na tabela "itens"
            $tamanhoAtualizado = "medida_multipla"; // Substitua "medida" pela string desejada
            $sqlAtualizarTamanho = "UPDATE itens SET tamanho = ? WHERE id = ?";
            $stmtAtualizarTamanho = $conn->prepare($sqlAtualizarTamanho);
            $stmtAtualizarTamanho->bind_param("si", $tamanhoAtualizado, $id);
            $stmtAtualizarTamanho->execute();
            $stmtAtualizarTamanho->close();

            echo "Tamanho atualizado com base na medida múltipla.";
        } elseif (empty($_POST["novoMedida"])) {
            // O campo "novoMedida" está vazio, então vamos adicionar a medida de forma simples
            $novaMedida = $_POST["unidade"];
            $valorMedidaUnica = $_POST["valor_medida_unica"];
        
            $sqlInserirMedidaSimples = "UPDATE itens SET unidade = ?, valorItem = ? WHERE id = ?";
            $stmtInserirMedidaSimples = $conn->prepare($sqlInserirMedidaSimples);
            $stmtInserirMedidaSimples->bind_param("ssi", $novaMedida, $valorMedidaUnica, $id);
        
            if ($stmtInserirMedidaSimples->execute()) {
                echo "Medida simples adicionada com sucesso.";
            } else {
                echo "Erro ao adicionar medida simples: " . $stmtInserirMedidaSimples->error;
            }
        
            $stmtInserirMedidaSimples->close();
        }
    }
         if ($tipoItem == "item_com_tamanho") {
        // Verifica se o campo "medidas" está presente e é um array
        if (isset($_POST['tamanhos']) && is_array($_POST['tamanhos']) && count($_POST['tamanhos']) > 0) {
            // Há tamanhos selecionados, então vamos adicionar o item com tamanhos múltiplos
    
            foreach ($_POST['tamanhos'] as $tamanho) {
                $valorTamanho = isset($_POST["valor_$tamanho"]) ? $_POST["valor_$tamanho"] : null;
    
                $sqlInserirTamanho = "INSERT INTO tamanhos_multiplos (item_id, nome_tamanho, valor_tamanho, panel_id) VALUES (?, ?, ?, ?)";
                $stmtInserirTamanho = $conn->prepare($sqlInserirTamanho);
                $stmtInserirTamanho->bind_param("isss", $id, $tamanho, $valorTamanho, $panel_id);
    
                if ($stmtInserirTamanho->execute()) {
                    echo "Tamanhos adicionados com sucesso.";
                } else {
                    echo "Erro ao adicionar tamanhos: " . $stmtInserirTamanho->error;
                }
    
                $stmtInserirTamanho->close();
            }
    
            // Atualização do campo "tamanho" na tabela "itens"
            $tamanhoAtualizado = "tamanho_multiplo"; // Substitua pelo valor correto
            $sqlAtualizarTamanho = "UPDATE itens SET unidade = ? WHERE id = ?";
            $stmtAtualizarTamanho = $conn->prepare($sqlAtualizarTamanho);
            $stmtAtualizarTamanho->bind_param("si", $tamanhoAtualizado, $id);
            $stmtAtualizarTamanho->execute();
            $stmtAtualizarTamanho->close();
    
            echo "Tamanho atualizado com base nos tamanhos múltiplos.";
        } elseif (empty($_POST["novoTamanho"])) {
            // O campo "novoTamanho" está vazio, então vamos adicionar o item de forma simples
        
            // Obtenha os valores dos campos tamanho e valor_tamanho_unica
            $tamanho = $_POST["tamanho"];
            $valorTamanhoUnica = $_POST["valor_tamanho_unica"];
        
            // Atualize a tabela itens com os valores obtidos
            $sqlAtualizarItemSimples = "UPDATE itens SET tamanho = ?, valorItem = ? WHERE id = ?";
            $stmtAtualizarItemSimples = $conn->prepare($sqlAtualizarItemSimples);
            $stmtAtualizarItemSimples->bind_param("ssi", $tamanho, $valorTamanhoUnica, $id);
        
            if ($stmtAtualizarItemSimples->execute()) {
                echo "Item simples adicionado com sucesso.";
            } else {
                echo "Erro ao adicionar item simples: " . $stmtAtualizarItemSimples->error;
            }
        
            $stmtAtualizarItemSimples->close();
        } else {
            // O campo "novoTamanho" não está vazio, mas não há tamanhos selecionados, exiba uma mensagem de erro
            echo "Erro: Nenhum tamanho selecionado.";
        }
    } else {
        echo "Erro: Nenhuma ação correspondente ao tipo de item selecionado.";


    }

    header("Location: ../add_prod_3.php?id=$id&panel_id=$panel_id");
    exit; // Certifique-se de sair após o redirecionamento

}
    // Feche a conexão com o banco de dados, se necessário
    $conn->close();
 
?>
