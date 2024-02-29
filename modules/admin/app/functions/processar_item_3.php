<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complementoOption = $_POST["complementoOption"];

    if ($complementoOption == "com_complementos") {
        $panel_id = $_POST["panel_id"];
        $id = $_POST["id"];

        // Conecte-se ao banco de dados
        include_once "../config/conection.php";

        // String para armazenar os complementos formatados
        $complementosFormatados = "";

        if (isset($_POST['complementos']) && is_array($_POST['complementos'])) {
            foreach ($_POST['complementos'] as $nomeComplemento) {
                $quantidade = isset($_POST['quantidade'][$nomeComplemento]) ? intval($_POST['quantidade'][$nomeComplemento]) : 0;

                // Formatar e adicionar à string de complementos
                $complementosFormatados .= ($quantidade > 0) ? "{$quantidade}x {$nomeComplemento}, " : "";
            }

            // Remover a última vírgula e espaço
            $complementosFormatados = rtrim($complementosFormatados, ", ");

            // Insira a string formatada na tabela "complementos_produtos"
            $sqlInserirComplemento = "INSERT INTO complementos_produtos (item_id, complemento_nome, panel_id) VALUES (?, ?, ?)";
            $stmtComplemento = $conn->prepare($sqlInserirComplemento);
            $stmtComplemento->bind_param("isi", $id, $complementosFormatados, $panel_id);

            if (!$stmtComplemento->execute()) {
                var_dump($stmtComplemento->error);
            }
            $stmtComplemento->close();
        }

        header("Location: ../add_prod_4.php?id=$id&panel_id=$panel_id");
        exit;
    } else {
        header("Location: ../add_prod_4.php?id=$id&panel_id=$panel_id");
        exit;
    }
}

$conn->close();

?>
