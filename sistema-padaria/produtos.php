<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$produtos = $pdo->query("
    SELECT p.*, c.nome AS categoria
    FROM produto p
    LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
    ORDER BY p.nome
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>Padaria Santo Pão</h1>
</header>

<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="produtos.php">Produtos</a>
    <a href="relatorio.php">Relatório</a>
    <a href="contato.php">Contato</a>
    <a href="logout.php">Sair</a>
</nav>

<main>

<h2>Produtos</h2>

<a class="btn" href="produto_novo.php">Novo Produto</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Preço</th>
        <th>Estoque</th>
        <th>Validade</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($produtos as $produto): ?>
    <tr>
        <td><?= $produto['id_produto'] ?></td>
        <td><?= $produto['nome'] ?></td>
        <td><?= $produto['categoria'] ?></td>
        <td>R$ <?= number_format($produto['preco_venda'],2,",",".") ?></td>
        <td><?= $produto['quantidade_estoque'] ?></td>
        <td><?= $produto['data_validade'] ?></td>
        <td>
            <a href="produto_editar.php?id=<?= $produto['id_produto'] ?>">Editar</a>
            |
            <a href="produto_excluir.php?id=<?= $produto['id_produto'] ?>"
               onclick="return confirm('Deseja excluir este produto?')">
               Excluir
            </a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</main>

</body>
</html>