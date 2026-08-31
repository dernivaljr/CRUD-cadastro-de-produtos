<?php
// Define o tipo de conteúdo como HTML e o charset como UTF-8
header('Content-Type: text/html; charset=utf-8');
// Conexão com o banco de dados
include './assets/db.php';

// Setando as variáveis com os valores do formulário
$mysqli = isset($conecta_db) ? $conecta_db : null;

if (!$mysqli) {
        echo "<script>
                        alert('Erro ao conectar ao banco de dados!');
                        window.location.href = 'controle_produtos.php';
                    </script>";
        exit;
}

$descricao = mysqli_real_escape_string($mysqli, isset($_POST['txt_descricao']) ? $_POST['txt_descricao'] : '');
$categoria = mysqli_real_escape_string($mysqli, isset($_POST['txt_categoria']) ? $_POST['txt_categoria'] : '');
$valor_compra = mysqli_real_escape_string($mysqli, isset($_POST['txt_valor_compra']) ? $_POST['txt_valor_compra'] : '0');
$valor_venda = mysqli_real_escape_string($mysqli, isset($_POST['txt_valor_venda']) ? $_POST['txt_valor_venda'] : '0');
//$lucro = $_POST['txt_lucro'];
$estoque = mysqli_real_escape_string($mysqli, isset($_POST['txt_estoque']) ? $_POST['txt_estoque'] : '0');

$lucro = (float) $valor_venda - (float) $valor_compra;

$sql = mysqli_query($mysqli, "SELECT * FROM produtos WHERE descricao='$descricao' AND categoria='$categoria' AND valor_compra='$valor_compra' AND valor_venda='$valor_venda' AND lucro='$lucro' AND estoque='$estoque'") or die(mysqli_error($mysqli));

$mensagem = "";

if (mysqli_num_rows($sql) > 0) {
    $mensagem = "Produto já cadastrado!";
} else {
    // Inserir novo produto
    $sql_insert = mysqli_query($mysqli, "INSERT INTO produtos (descricao, categoria, valor_compra, valor_venda, lucro, estoque) VALUES ('$descricao', '$categoria', '$valor_compra', '$valor_venda', '$lucro', '$estoque')");
    
    if ($sql_insert) {
        $mensagem = "Produto cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar produto!";
    }
}
echo "<script>
        alert('$mensagem');
        window.location.href = 'controle_produtos.php'; 
      </script>";
?>