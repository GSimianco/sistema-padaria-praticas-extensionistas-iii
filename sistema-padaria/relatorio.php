<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$pesquisa = $_GET['pesquisa'] ?? '';

if ($pesquisa != '') {
    $stmt = $pdo->prepare("
        SELECT p.*, c.nome AS categoria
        FROM produto p
        LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
        WHERE p.nome LIKE ?
        ORDER BY p.nome
    ");

    $stmt->execute(["%$pesquisa%"]);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {

    $produtos = $pdo->query("
        SELECT p.*, c.nome AS categoria
        FROM produto p
        LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
        ORDER BY p.nome
    ")->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Produtos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>Relatório de Produtos</h1>
</header>

<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="produtos.php">Produtos</a>
    <a href="relatorio.php">Relatório</a>
    <a href="contato.php">Contato</a>
    <a href="logout.php">Sair</a>
</nav>

<main>

<form method="GET">
    <input type="text"
           name="pesquisa"
           placeholder="Pesquisar produto..."
           value="<?= htmlspecialchars($pesquisa) ?>">

    <button type="submit">Pesquisar</button>
</form>

<br>

<table>
    <tr>
        <th>Produto</th>
        <th>Categoria</th>
        <th>Preço</th>
        <th>Estoque</th>
        <th>Validade</th>
    </tr>

    <?php foreach($produtos as $produto): ?>

    <tr>
        <td><?= $produto['nome'] ?></td>
        <td><?= $produto['categoria'] ?></td>
        <td>R$ <?= number_format($produto['preco_venda'],2,",",".") ?></td>
        <td><?= $produto['quantidade_estoque'] ?></td>
        <td><?= $produto['data_validade'] ?></td>
    </tr>

    <?php endforeach; ?>

</table>

</main>

</body>
</html>