<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$categorias = $pdo->query("SELECT * FROM categoria ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $estoque = $_POST["estoque"];
    $validade = $_POST["validade"];
    $categoria = $_POST["categoria"];

    $sql = "INSERT INTO produto
            (nome, descricao, preco_venda, quantidade_estoque, data_validade, id_categoria)
            VALUES
            (?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $nome,
        $descricao,
        $preco,
        $estoque,
        $validade,
        $categoria
    ]);

    header("Location: produtos.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Novo Produto</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>Novo Produto</h1>
</header>

<main>

<form method="POST">

    <label>Nome:</label>
    <input type="text" name="nome" required>

    <label>Descrição:</label>
    <input type="text" name="descricao">

    <label>Preço:</label>
    <input type="number" step="0.01" name="preco" required>

    <label>Quantidade em Estoque:</label>
    <input type="number" name="estoque" required>

    <label>Data de Validade:</label>
    <input type="date" name="validade">

    <label>Categoria:</label>
    <select name="categoria" required>

        <?php foreach($categorias as $categoria): ?>

            <option value="<?= $categoria['id_categoria'] ?>">
                <?= $categoria['nome'] ?>
            </option>

        <?php endforeach; ?>

    </select>

    <br><br>

    <button type="submit">Salvar Produto</button>

    <a href="produtos.php">Voltar</a>

</form>

</main>

</body>
</html>