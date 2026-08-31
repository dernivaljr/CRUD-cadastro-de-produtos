<?php
header('Content-Type: text/html; charset=utf-8');
include './assets/db.php';

$mysqli = isset($conecta_db) ? $conecta_db : null;

if (!$mysqli) {
    echo "<script>
            alert('Erro ao conectar ao banco de dados!');
            window.location.href = 'controle_produtos.php';
          </script>";
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);

if ($id === false || $id === null) {
    $mensagem = 'Produto inválido.';
} else {
    $descricao = trim(isset($_POST['txt_descricao']) ? $_POST['txt_descricao'] : '');
    $categoria = trim(isset($_POST['txt_categoria']) ? $_POST['txt_categoria'] : '');
    $valor_compra = (float) (isset($_POST['txt_valor_compra']) ? $_POST['txt_valor_compra'] : 0);
    $valor_venda = (float) (isset($_POST['txt_valor_venda']) ? $_POST['txt_valor_venda'] : 0);
    $estoque = (int) (isset($_POST['txt_estoque']) ? $_POST['txt_estoque'] : 0);

    if ($descricao === '' || $categoria === '') {
        $mensagem = 'Descrição e categoria são obrigatórias.';
    } else {
        $lucro = $valor_venda - $valor_compra;

        $descricao_segura = mysqli_real_escape_string($mysqli, $descricao);
        $categoria_segura = mysqli_real_escape_string($mysqli, $categoria);

        $sql_verifica = mysqli_query($mysqli, "SELECT id FROM produtos WHERE descricao = '$descricao_segura' AND categoria = '$categoria_segura' AND valor_compra = '$valor_compra' AND valor_venda = '$valor_venda' AND lucro = '$lucro' AND estoque = '$estoque' AND id != $id") or die(mysqli_error($mysqli));

        if (mysqli_num_rows($sql_verifica) > 0) {
            $mensagem = 'Produto já cadastrado.';
        } else {
            $sql_update = mysqli_query($mysqli, "UPDATE produtos SET descricao = '$descricao_segura', categoria = '$categoria_segura', valor_compra = '$valor_compra', valor_venda = '$valor_venda', lucro = '$lucro', estoque = '$estoque' WHERE id = $id") or die(mysqli_error($mysqli));

            if ($sql_update) {
                $mensagem = 'Produto atualizado com sucesso!';
            } else {
                $mensagem = 'Erro ao atualizar o produto.';
            }
        }
    }
}

echo "<script>
        alert(" . json_encode($mensagem, JSON_UNESCAPED_UNICODE) . ");
        window.location.href = 'controle_produtos.php';
      </script>";
?>
