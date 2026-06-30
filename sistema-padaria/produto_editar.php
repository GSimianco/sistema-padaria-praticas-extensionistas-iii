<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];

$categorias = $pdo->query("SELECT * FROM categoria ORDER BY nome")
                  ->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM produto WHERE id_produto = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "UPDATE produto SET
                nome = ?,
                descricao = ?,
                preco_venda = ?,
                quantidade_estoque = ?,
                data_validade = ?,
                id_categoria = ?
            WHERE id_produto = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST["nome"],
        $_POST["descricao"],
        $_POST["preco"],
        $_POST["estoque"],
        $_POST["validade"],
        $_POST["categoria"],
        $id
    ]);

    header("Location: produtos.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>Editar Produto</h1>
</header>

<main>

<form method="POST">

    <label>Nome:</label>
    <input type="text" name="nome"
           value="<?= $produto['nome'] ?>" required>

    <label>Descrição:</label>
    <input type="text" name="descricao"
           value="<?= $produto['descricao'] ?>">

    <label>Preço:</label>
    <input type="number" step="0.01" name="preco"
           value="<?= $produto['preco_venda'] ?>" required>

    <label>Estoque:</label>
    <input type="number" name="estoque"
           value="<?= $produto['quantidade_estoque'] ?>" required>

    <label>Validade:</label>
    <input type="date" name="validade"
           value="<?= $produto['data_validade'] ?>">

    <label>Categoria:</label>
    <select name="categoria">

        <?php foreach($categorias as $categoria): ?>

            <option value="<?= $categoria['id_categoria'] ?>"
                <?= $categoria['id_categoria'] == $produto['id_categoria']
                    ? 'selected'
                    : '' ?>>
                <?= $categoria['nome'] ?>
            </option>

        <?php endforeach; ?>

    </select>

    <br><br>

    <button type="submit">Salvar Alterações</button>
    <a href="produtos.php">Cancelar</a>

</form>

</main>

</body>
</html>