<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$totalProdutos = $pdo->query("SELECT COUNT(*) FROM produto")->fetchColumn();
$totalCategorias = $pdo->query("SELECT COUNT(*) FROM categoria")->fetchColumn();
$totalContatos = $pdo->query("SELECT COUNT(*) FROM contato")->fetchColumn();
$estoqueBaixo = $pdo->query("SELECT COUNT(*) FROM produto WHERE quantidade_estoque <= 10")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistema Padaria</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>Padaria Santo Pão</h1>
    <p>Sistema de Gestão para Padaria</p>
</header>

<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="produtos.php">Produtos</a>
    <a href="relatorio.php">Relatório</a>
    <a href="contato.php">Contato</a>
    <a href="logout.php">Sair</a>
</nav>

<main>
    <h2>Dashboard</h2>

    <p>Bem-vindo, <strong><?php echo $_SESSION["nome"]; ?></strong>!</p>

    <div class="cards">
        <div class="card">
            <h3>Produtos</h3>
            <p><?php echo $totalProdutos; ?></p>
        </div>

        <div class="card">
            <h3>Categorias</h3>
            <p><?php echo $totalCategorias; ?></p>
        </div>

        <div class="card">
            <h3>Estoque Baixo</h3>
            <p><?php echo $estoqueBaixo; ?></p>
        </div>

        <div class="card">
            <h3>Contatos</h3>
            <p><?php echo $totalContatos; ?></p>
        </div>
    </div>
</main>

</body>
</html>