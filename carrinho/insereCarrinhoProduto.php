<?php
session_start();
$produto = $_GET['produto'] ?? '';
$usuario =  $_SESSION['id_login'] ?? '';
$quantidade = (int)$_POST['quantidade'] ?? 1;

$host = '50.16.128.166';
$port = '3306';
$db = 'p3';
$user = 'root';
$passwd = 'minhaSenha';

try {
    $connection = new PDO("mysql:host={$host};port={$port};dbname={$db}", $user, $passwd);
} catch (Exception $error) {
    echo "Ocorreu o seguinte erro: {$error->getMessage()}";
}

$sql = "CALL adiciona_produto_carrinho(:usuario,:produto,:quantidade)";
$result = $connection->prepare($sql);
$result->bindValue(':usuario', $usuario);
$result->bindValue(':produto', $produto);
$result->bindValue(':quantidade', $quantidade);
$result->execute();

header('location: ../');
