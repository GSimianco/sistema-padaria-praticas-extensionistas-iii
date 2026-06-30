<?php

$host = "127.0.0.1";
$porta = "3307";
$banco = "padaria_db";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}