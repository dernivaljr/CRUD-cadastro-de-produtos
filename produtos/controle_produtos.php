<?php
include './assets/db.php';

$mysqli = isset($conecta_db) ? $conecta_db : null;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Controle de Produtos</title>
</head>
<body>
    <div class="container mt-5">
        <h2><i class="bi bi-box-seam me-2"></i>Cadastro de Produtos</h2>
        <hr class="border border-dark border-3 opacity-100 mb-4">
        <form id="formProduto" action="salvar.php" method="POST">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="txt_descricao" placeholder="Digite a descrição do produto">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoria" name="txt_categoria" placeholder="Digite a categoria do produto">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Valor Compra (R$)</label>
                    <input type="text" class="form-control" id="valor_compra" name="txt_valor_compra" placeholder="Digite o valor de compra do produto">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Valor Venda (R$)</label>
                    <input type="text" class="form-control" id="valor_venda" name="txt_valor_venda" placeholder="Digite o valor de venda do produto">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Estoque</label>
                    <input type="text" class="form-control" id="estoque" name="txt_estoque" placeholder="Digite a quantidade em estoque do produto">
                </div>
            </div>
            <button type="submit" class="btn btn-primary me-4">Cadastrar Produto</button>
            <button type="button" class="btn btn-primary me-4">Vender Produto</button>
        </form>

        <form method="GET" action="controle_produtos.php" class="mb-4" onsubmit="return false;">
            <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
                <h2 class="m-0">
                    <i class="bi bi-clipboard-data me-2"></i>Inventário
                </h2>
                <div class="position-relative" style="max-width: 300px; width: 100%;">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-secondary"></i>
                    <input type="search" class="form-control ps-5" id="searchInput" name="search" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>" placeholder="Pesquisar produto...">
                </div>
            </div>
        </form>

        <?php include 'listagem.php'; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const input = document.getElementById('searchInput');
                if (!input) return;

                input.addEventListener('input', function () {
                    const value = this.value.trim();
                    const url = new URL(window.location.href);

                    if (value === '') {
                        url.searchParams.delete('search');
                    } else {
                        url.searchParams.set('search', value);
                    }

                    window.location.href = url.toString();
                });
            });
        </script>
    </div>
</body>
</html>