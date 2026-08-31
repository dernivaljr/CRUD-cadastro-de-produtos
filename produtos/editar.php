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

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);

if ($id === false || $id === null) {
    echo "<script>
            alert('Produto inválido.');
            window.location.href = 'controle_produtos.php';
          </script>";
    exit;
}

$sql_select = mysqli_query($mysqli, "SELECT * FROM produtos WHERE id = $id");
$produto = mysqli_fetch_assoc($sql_select);

if (!$produto) {
    echo "<script>
            alert('Produto não encontrado.');
            window.location.href = 'controle_produtos.php';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Editar Produto</title>
</head>
<body>
    <div class="container mt-5">
        <h2><i class="bi bi-pencil-square me-2"></i>Editar Produto</h2>
        <hr class="border border-dark border-3 opacity-100 mb-4">

        <form action="atualizar.php" method="POST">
            <input type="hidden" name="id" value="<?= intval($produto['id']) ?>">

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="txt_descricao" value="<?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoria" name="txt_categoria" value="<?= htmlspecialchars($produto['categoria'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Valor Compra (R$)</label>
                    <input type="text" class="form-control" id="valor_compra" name="txt_valor_compra" value="<?= number_format((float) $produto['valor_compra'], 2, '.', '') ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Valor Venda (R$)</label>
                    <input type="text" class="form-control" id="valor_venda" name="txt_valor_venda" value="<?= number_format((float) $produto['valor_venda'], 2, '.', '') ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Estoque</label>
                    <input type="text" class="form-control" id="estoque" name="txt_estoque" value="<?= intval($produto['estoque']) ?>" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success me-3">Salvar Alterações</button>
            <a href="controle_produtos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

