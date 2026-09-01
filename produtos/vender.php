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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1],
    ]);
    $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1],
    ]);

    if ($id === false || $id === null || $quantidade === false || $quantidade === null) {
        $mensagem = 'Dados da venda inválidos.';
    } else {
        $sql_produto = mysqli_query($mysqli, "SELECT id, descricao, estoque FROM produtos WHERE id = $id");
        $produto = mysqli_fetch_assoc($sql_produto);

        if (!$produto) {
            $mensagem = 'Produto não encontrado.';
        } elseif ((int) $produto['estoque'] < $quantidade) {
            $mensagem = 'Estoque insuficiente para essa venda.';
        } else {
            $novo_estoque = (int) $produto['estoque'] - $quantidade;
            $sql_venda = mysqli_query($mysqli, "UPDATE produtos SET estoque = $novo_estoque WHERE id = $id");

            if ($sql_venda) {
                $mensagem = 'Venda registrada com sucesso!';
            } else {
                $mensagem = 'Erro ao registrar a venda.';
            }
        }
    }

    echo "<script>
            alert('" . addslashes($mensagem) . "');
            window.location.href = 'controle_produtos.php';
          </script>";
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);

if ($id === false || $id === null) {
    $sql_produtos = mysqli_query($mysqli, "SELECT id, descricao, estoque FROM produtos ORDER BY descricao") or die(mysqli_error($mysqli));
    $produtos = mysqli_fetch_all($sql_produtos, MYSQLI_ASSOC);
} else {
    $sql_produto = mysqli_query($mysqli, "SELECT * FROM produtos WHERE id = $id");
    $produto = mysqli_fetch_assoc($sql_produto);

    if (!$produto) {
        echo "<script>
                alert('Produto não encontrado.');
                window.location.href = 'controle_produtos.php';
              </script>";
        exit;
    }
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
    <title>Vender Produto</title>
</head>
<body>
    <div class="container mt-5">
        <?php if ($id === false || $id === null): ?>
            <h2><i class="bi bi-cart3 me-2"></i>Vender Produto</h2>
            <hr class="border border-dark border-3 opacity-100 mb-4">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Estoque</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['descricao'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= intval($item['estoque']) ?></td>
                            <td>
                                <a href="vender.php?id=<?= intval($item['id']) ?>" class="btn btn-sm btn-success">Vender</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="controle_produtos.php" class="btn btn-secondary">Voltar</a>
        <?php else: ?>
            <h2><i class="bi bi-bag-check me-2"></i>Registrar Venda</h2>
            <hr class="border border-dark border-3 opacity-100 mb-4">

            <form action="vender.php" method="POST">
                <input type="hidden" name="id" value="<?= intval($produto['id']) ?>">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Descrição</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estoque atual</label>
                        <input type="text" class="form-control" value="<?= intval($produto['estoque']) ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Quantidade vendida</label>
                        <input type="number" class="form-control" name="quantidade" min="1" max="<?= intval($produto['estoque']) ?>" value="1" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success me-3">Confirmar Venda</button>
                <a href="controle_produtos.php" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

