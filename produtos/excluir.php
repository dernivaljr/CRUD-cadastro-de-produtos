<?php
// Define o tipo de conteúdo como HTML e o charset como UTF-8
header('Content-Type: text/html; charset=utf-8');
// Conexão com o banco de dados
include './assets/db.php';

$mysqli = isset($conecta_db) ? $conecta_db : null;

if (!$mysqli) {
        echo "<script>
                        alert('Erro ao conectar ao banco de dados!');
                        window.location.href = 'controle_produtos.php';
                    </script>";
        exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);

if ($id === false || $id === null) {
    $mensagem = 'Produto inválido.';
} else {
    $sql_delete = mysqli_query($mysqli, "DELETE FROM produtos WHERE id=$id");

    if ($sql_delete && mysqli_affected_rows($mysqli) > 0) {
        $mensagem = 'Produto excluído com sucesso!';
    } else {
        $mensagem = 'Produto não encontrado ou não foi possível excluí-lo.';
    }
}

echo "<script>
        alert('$mensagem');
        window.location.href = 'controle_produtos.php'; 
      </script>";
?>