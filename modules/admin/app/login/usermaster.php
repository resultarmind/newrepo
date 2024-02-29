<?php
// Inclua o arquivo de configuração do banco de dados
include_once "../config/conection.php";

// Defina as informações do usuário
$username = "espetinho";
$password = "123"; // Lembre-se de usar password_hash() para armazenar a senha no banco de dados

// Hash da senha usando password_hash()
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Consulta preparada para inserir um novo usuário
$sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);

// Execute a instrução preparada
if (mysqli_stmt_execute($stmt)) {
    echo "Usuário inserido com sucesso!";
} else {
    echo "Erro ao inserir usuário: " . mysqli_error($conn);
}

// Feche a instrução preparada e a conexão
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
