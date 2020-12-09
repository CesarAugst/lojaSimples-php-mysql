<?php
session_start();
include './index.php';
$nome_digitado = $_POST['nome'] ?? 'Desconhecido';
$usuario_digitado = $_POST['usuario'] ?? '';
$senha_digitado = $_POST['senha'] ?? '';
$email_digitado = $_POST['email'] ?? '';

if($usuario_digitado == '' || $senha_digitado == ''){
    echo "Informações importantes faltando!";
    die();
}

$senhaSegura = password_hash($senha_digitado, PASSWORD_DEFAULT);

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

//login
$sql = "CALL cadastra_usuario(:usuario,:senha,:nome,:email)";
$result = $connection->prepare($sql);
$result->bindValue(':usuario', $usuario_digitado);
$result->bindValue(':senha', $senhaSegura);
$result->bindValue(':nome', $nome_digitado);
$result->bindValue(':email', $email_digitado);
$result->execute();
$resposta = $result->fetchAll(PDO::FETCH_OBJ);

if(isset($resposta[0])){
    echo "Login já existe<br>";
    die();
}

header('location: ../login/index.php');
