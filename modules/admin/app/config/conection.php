
<?php

$servidor = "srv1078.hstgr.io";
$usuario = "u780901284_delivery";
$senha = "Dev_resultar123";
$dbname = "u780901284_delivery";

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

if (!$conn) {
    die("Falha na conexao: " . mysqli_connect_error());
} else {
    //echo "Conexao realizada com sucesso";
}

$panel_id = 7;
$loja_id = 7;

