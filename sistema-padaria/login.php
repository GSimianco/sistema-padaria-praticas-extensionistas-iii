<?php
session_start();
require_once "conexao.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"] ?? "";
    $senha = md5($_POST["senha"] ?? "");

    $sql = "SELECT * FROM usuario WHERE usuario = :usuario AND senha = :senha";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->bindParam(":senha", $senha);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION["usuario"] = $user["usuario"];
        $_SESSION["nome"] = $user["nome"];
        $_SESSION["perfil"] = $user["perfil"];

        header("Location: dashboard.php");
        exit;
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema Padaria</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">

<div class="login-container">
    <h1>Padaria Santo Pão</h1>
    <h2>Acesso ao Sistema</h2>

    <?php if ($erro): ?>
        <div class="alerta"><?php echo $erro; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Usuário</label>
        <input type="text" name="usuario" required>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <button type="submit">Entrar</button>
    </form>

    <p class="info-login">Usuário: admin | Senha: 123456</p>
</div>

</body>
</html>