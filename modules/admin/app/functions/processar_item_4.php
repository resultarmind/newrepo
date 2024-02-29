<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique o valor selecionado em "complementoOption"
    $complementoOption = $_POST["complementoOption"];

    if ($complementoOption == "com_complementos") {
        // O usuário selecionou "com_complementos", então continue com o processamento do formulário

        // Recupere os dados do formulário
        $panel_id = $_POST["panel_id"];
        $id = $_POST["id"];
        // Exibindo os valores recuperados para depuração
        var_dump($panel_id);
        var_dump($id);

        // Conecte-se ao banco de dados (use a sua conexão existente)
        include_once "../config/conection.php";

        if (isset($_POST['complementos']) && is_array($_POST['complementos'])) {
            foreach ($_POST['complementos'] as $key => $nomeComplemento) {
                $valor = $_POST['valor'][$key];
                // Verify if the quantity for this complement has been defined
                $quantidade = isset($_POST['quantidade'][$nomeComplemento]) ? intval($_POST['quantidade'][$nomeComplemento]) : 0;
        
                // Insert into the "complementos_adicionais_produtos" table
                $sqlInserirComplemento = "INSERT INTO complementos_adicionais_produtos (item_id, complemento_nome, valor, panel_id) VALUES (?, ?, ?, ?)";
                $stmtComplemento = $conn->prepare($sqlInserirComplemento);
        
                if ($stmtComplemento) {
                    // Bind parameters and execute the query
                    $stmtComplemento->bind_param("issi", $id, $nomeComplemento, $valor, $panel_id);
                    if (!$stmtComplemento->execute()) {
                        // Handle query execution error here (e.g., log or display an error message)
                        echo "Error: " . $stmtComplemento->error;
                    }
                    $stmtComplemento->close();
                } else {
                    // Handle the case where the statement preparation failed
                    echo "Statement preparation failed: " . $conn->error;
                }
            }
        } else {
            // Handle the case where 'complementos' is not set or is not an array
            echo "Invalid or missing 'complementos' in the POST data.";
        }
        

        // Redireciona para a próxima página
        header("Location: ../view_produto.php?success=1");
        exit; // Certifique-se de sair após o redirecionamento
    } else {
        // O usuário selecionou "sem_complementos", então redirecione para "add_item_4.php"
        header("Location: ../view_produto.php?success=1");
        exit;
    }
}

// Feche a conexão com o banco de dados, se necessário
$conn->close();

?>
