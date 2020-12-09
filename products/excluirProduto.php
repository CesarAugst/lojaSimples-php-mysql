<?php
session_start();
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

$id = $_GET['id'];

$sql = "CALL exclui_produto(:id);";
$result = $connection->prepare($sql);
$result->bindValue(':id', $id);
$result->execute();

header("location: ../");