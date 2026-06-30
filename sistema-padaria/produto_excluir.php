<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];

$stmt = $pdo->prepare(
    "DELETE FROM produto WHERE id_produto = ?"
);

$stmt->execute([$id]);

header("Location: produtos.php");
exit;