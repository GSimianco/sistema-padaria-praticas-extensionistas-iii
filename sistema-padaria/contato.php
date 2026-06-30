<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$mensagemSucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $assunto = $_POST["assunto"];
    $mensagem = $_POST["mensagem"];

    $sql = "INSERT INTO contato (nome, email, assunto, mensagem)
            VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $assunto, $mensagem]);

    $mensagemSucesso = "Mensagem enviada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Contato - Sistema Padaria</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>Contato com os Desenvolvedores</h1>
</header>

<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="produtos.php">Produtos</a>
    <a href="relatorio.php">Relatório</a>
    <a href="contato.php">Contato</a>
    <a href="logout.php">Sair</a>
</nav>

<main>

<h2>Fale Conosco</h2>

<p>
    Utilize o formulário abaixo para enviar dúvidas, sugestões ou solicitações
    aos desenvolvedores da solução.
</p>

<?php if ($mensagemSucesso): ?>
    <div class="sucesso">
        <?php echo $mensagemSucesso; ?>
    </div>
<?php endif; ?>

<form method="POST">

    <label>Nome:</label>
    <input type="text" name="nome" required>

    <label>E-mail:</label>
    <input type="email" name="email" required>

    <label>Assunto:</label>
    <input type="text" name="assunto" required>

    <label>Mensagem:</label>
    <textarea name="mensagem" rows="6" required></textarea>

    <button type="submit">Enviar Mensagem</button>

</form>

</main>

</body>
</html>