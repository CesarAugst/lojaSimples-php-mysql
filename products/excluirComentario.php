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

$comentario = $_GET['comentario'];

    $sql = "CALL exclui_comentario(:comentario);";
    $result = $connection->prepare($sql);
    $result->bindValue(':comentario', $comentario);
    $result->execute();

$produto = $_GET['produto'];

header("location: ./produto.php?id={$produto}");