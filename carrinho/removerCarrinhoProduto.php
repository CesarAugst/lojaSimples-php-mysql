<?php
session_start();

$carrinho = $_GET['id'];

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

$comentario = $_GET['comentario'];

    $sql = "CALL remove_carrinho(:id);";
    $result = $connection->prepare($sql);
    $result->bindValue(':id', $carrinho);
    $result->execute();

header("location: ./carrinho.php");