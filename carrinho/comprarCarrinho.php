<?php
session_start();
$usuario =  $_SESSION['id_login'] ?? '';

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

$sql = " CALL comprar_carrinho(:id)";
$result = $connection->prepare($sql);
$result->bindValue(':id', $usuario);
$result->execute();

header('location: ../');