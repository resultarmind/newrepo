<?php 

// Obtém o URI atual
$uri = $_SERVER['REQUEST_URI'];

// Verifica se o URI contém 'pages' para identificar se está em uma subpágina
$inSubPage = strpos($uri, '/pages/') !== false;

// Define o caminho para o link de INÍCIO baseado na localização da página
$homeLinkPath = $inSubPage ? '../../' : '../';


include_once "$homeLinkPath/admin/app/config/conection.php" ?> 