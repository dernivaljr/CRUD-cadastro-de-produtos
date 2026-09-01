<?php
include './assets/db.php';

$mysqli = isset($conecta_db) ? $conecta_db : null;

if (!$mysqli) {
    echo "<script>
            alert('Erro ao conectar ao banco de dados!');
            window.location.href = 'controle_produtos.php';
          </script>";
    exit;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = '';

if ($search !== '') {
    $searchTerm = mysqli_real_escape_string($mysqli, $search);
    $where = " WHERE descricao LIKE '%$searchTerm%' OR categoria LIKE '%$searchTerm%' ";
}

$sql = mysqli_query($mysqli, "SELECT id, descricao, categoria, valor_venda, lucro, estoque FROM produtos $where ORDER BY descricao") or die(mysqli_error($mysqli));
$resultado = mysqli_fetch_all($sql, MYSQLI_ASSOC);
?>

<hr class="border border-dark border-3 opacity-100 mb-4">
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">Descrição</th>
            <th scope="col">Categoria</th>
            <th scope="col">Venda (R$)</th>
            <th scope="col">Lucro (R$)</th>
            <th scope="col">Estoque</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody id="productTableBody">
        <?php foreach ($resultado as $produto): ?>
            <tr>
                <td><?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($produto['categoria'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= number_format($produto['valor_venda'], 2, ',', '.') ?></td>
                <td><?= number_format($produto['lucro'], 2, ',', '.') ?></td>
                <td><?= intval($produto['estoque']) ?></td>
                <td>
                    <a class="btn btn-sm btn-outline-primary" href="editar.php?id=<?= intval($produto['id']) ?>">Editar</a>
                    <a class="btn btn-sm btn-outline-success" href="vender.php?id=<?= intval($produto['id']) ?>">Vender</a>
                    <a class="btn btn-sm btn-outline-danger" href="excluir.php?id=<?= intval($produto['id']) ?>" onclick="return confirm('Confirma a exclusão deste produto?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
