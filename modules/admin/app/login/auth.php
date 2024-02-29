<?php
session_start();

// Inclua o arquivo de configuração do banco de dados
include_once "../config/conection.php";

// Verifique se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["pass"]; // O nome do campo de senha deve corresponder ao 'name' no formulário

    // Consulta para verificar as credenciais do usuário
    $sql = "SELECT id, username, password FROM usuarios WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row["password"];

            // Verifique se a senha fornecida corresponde à senha hashizada
            if (password_verify($password, $hashedPassword)) {
                // Autenticação bem-sucedida, crie uma sessão para o usuário
                $_SESSION["username"] = $username;
            
                // Obter panel_id do usuário
                $queryPanelId = "SELECT panel_id FROM usuarios WHERE username = ?";
                $stmt = $conn->prepare($queryPanelId);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $panel_id = $row['panel_id'];
            
                // Verificar se nome e telefone estão vazios ou nulos na tabela infos
                $queryInfos = "SELECT nome, telefone FROM infos WHERE id = ?";
                $stmt = $conn->prepare($queryInfos);
                $stmt->bind_param("i", $panel_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
            
                if (empty($row['nome']) || is_null($row['nome']) || empty($row['telefone']) || is_null($row['telefone'])) {
                    header("Location: ../view_infos.php?info=incomplete");
                } else {
                    header("Location: ../index.php");
                }
                
                exit();
            }
            
        }
    }

    // Se as credenciais não forem válidas, redirecione de volta para a página de login com uma mensagem de erro
    header("Location: login.php?error=1");
}
