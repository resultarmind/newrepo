<?php 
include_once "../includes/connection.php";


$query = "SELECT * FROM infos WHERE id = $loja_id";

$result = $conn->query($query);

if ($result === false) {
    echo "Erro na consulta: " . $conn->error;
} else {
    $row = $result->fetch_assoc();


    $logoFooter = $row['logoFooter'];
    $whatsapp = $row['whatsapp'];
    $cnpj = $row['cnpj'];
    $cidade = $row['cidade'];
    $estado = $row['estado'];
    $instagram = $row['instagram'];
    $telegram = $row['telegram'];
    $num = $row['num'];
    $bairro = $row['bairro'];
    $endereco = $row['endereco'];
    $cep = $row['cep'];


    // Obtém o URI atual
$uri = $_SERVER['REQUEST_URI'];

// Verifica se o URI contém 'pages' para identificar se está em uma subpágina
if (strpos($uri, '/pages/') !== false) {
    // Está dentro da pasta 'pages', portanto usa dois '../'
    $path_prefix = '../../';
} else {
    // Está na raiz (ou não está dentro de 'pages'), usa um '../'
    $path_prefix = '../';
}


}

?>


<div class="container mobile-custom-class">
  
<div class="divider-title"></div>

  <div class="row align-items-center">
    <div class="col-md-2">
      <img src="<?php echo $path_prefix; ?>admin/app/uploads/<?php echo $logoFooter; ?>" class="logo-footer img-fluid" alt="">
    </div>

    <div class="col-md-6">
    <p class="footer-text">
        © Copyright 2024 - ResultarMind - Todos os direitos reservados ProntoPraPedir.
        <br>
        CNPJ: <?php echo $cnpj; ?>
        <br>
        Endereço: <?php echo $endereco; ?>, <?php echo $num; ?> - <?php echo $bairro; ?>
        <br>
        Cidade/Estado: <?php echo $cidade; ?>/<?php echo $estado; ?> - CEP: <?php echo $cep; ?>
    </p>
</div>

<div class="col-md-4 text-right">
    <?php if (!empty($instagram)) { ?>
        <a href="<?php echo $instagram; ?>" target="_blank"><i class="fab fa-instagram icon-footer"></i></a>
    <?php } ?>
    <?php if (!empty($whatsapp)) { ?>
        <a href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>" target="_blank"><i class="fab fa-whatsapp icon-footer"></i></a>
    <?php } ?>
    <?php if (!empty($telegram)) { ?>
        <a href="<?php echo $telegram; ?>" target="_blank"><i class="fab fa-telegram icon-footer"></i></a>
    <?php } ?>
</div>

  </div>

  <div class="divider-title"></div>

  <p class="footer-text text-center">Website Desenvolvido pela Resultar Mind. Confira todas nossas opções e monte seu comércio online!</p>
  
</div>