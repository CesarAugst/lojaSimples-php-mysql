<?php
session_start();
$nome_digitado = $_POST['nome'] ?? '';
$valor_digitado = (float)str_replace(",", ".", $_POST['valor']) ?? '';
$descricao_digitado = $_POST['descricao'] ?? '';
$categoria_digitado = $_POST['categoria'] ?? '';
$imagem = $_FILES['imagem'];

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

if ($imagem['name'] != '') {
    $nameImage = md5($imagem['name'] . rand(0, 9999));
    $tipo = substr($imagem['name'], -4);
    $nomeCompleto = "{$nameImage}{$tipo}";
    $imagem = $imagem['tmp_name'];

    move_uploaded_file($imagem, "../img/{$nomeCompleto}");

    $sql = "CALL insere_produto(:nome, :imagem, :valor, :descricao, :categoria)";
    $result = $connection->prepare($sql);
    $result->bindValue(':nome', $nome_digitado);
    $result->bindValue(':imagem', $nomeCompleto);
    $result->bindValue(':valor', $valor_digitado);
    $result->bindValue(':descricao', $descricao_digitado);
    $result->bindValue(':categoria', $categoria_digitado);
    $result->execute();
}

header('location: ../index.php');
