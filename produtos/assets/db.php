<?php
$servidor = "127.0.0.1";
$usuario = "root";
$senha = "usbw";
$banco = "cadastro_de_produtos";

$conecta_db = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conecta_db) {
    die("Erro ao conectar: " . mysqli_connect_error());
}

mysqli_select_db($conecta_db, $banco) or die("Erro ao selecionar o banco de dados");
mysqli_set_charset($conecta_db, 'utf8');
?>