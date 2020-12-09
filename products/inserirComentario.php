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

$comentario = $_POST['comentario'];
$autor = (int)$_SESSION['id_login'];
$produto = (int)$_GET["product"];

if($comentario != ''){
    $sql = "CALL insere_comentario(:comentario, :autor, :produto);";
    $result = $connection->prepare($sql);
    $result->bindValue(':comentario', $comentario);
    $result->bindValue(':autor', $autor);
    $result->bindValue(':produto', $produto);
    $result->execute();
}
header("location: ./produto.php?id={$_GET["product"]}");