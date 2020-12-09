<?php
session_start();
$host = '50.16.128.166';
$port = '3306';
$db = 'Projeto_Comentario';
$user = 'root';
$passwd = 'minhaSenha';

try {
    $connection = new PDO("mysql:host={$host};port={$port};dbname={$db}", $user, $passwd);
} catch (Exception $error) {
    echo "Ocorreu o seguinte erro: {$error->getMessage()}";
}
$logado = $_SESSION["aprovado"] ?? false;
if ($logado) {
    $comentario = $_POST['comentario'];
    if ($comentario != '') {
        $sql = "insert into comentarios values(default, :comentario, :autor, default);";
        $result = $connection->prepare($sql);
        $result->bindValue(':comentario', $comentario);
        $result->bindValue(':autor', $_SESSION['id_login']);
        $result->execute();
    }
} else {
    $comentario = $_POST['comentario'];
    if ($comentario != '') {
        $sql = "insert into comentarios values(default, :comentario, null, default);";
        $result = $connection->prepare($sql);
        $result->bindValue(':comentario', $comentario);
        $result->execute();
    }
}
header('location: ../index.php');
