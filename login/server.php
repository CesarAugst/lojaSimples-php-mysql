<?php
session_start();
include_once './index.php';
if ($_POST['login'] == '' or $_POST['senha'] == '') {
    echo 'Digite as informações corretamente<br>';
    die();
}
include_once '../sql/connection.php';

$usuario_digitado = $_POST['login'];
$senha_digitada = $_POST['senha'];

$sql = "CALL busca_senha_com_login(:usuario)";
$result = $connection->prepare($sql);
$result->bindValue(':usuario', $usuario_digitado);
$result->execute();
$resposta = $result->fetchAll(PDO::FETCH_OBJ);
if(empty($resposta)){
    $_SESSION["aprovado"] = false;
    echo "Usuario ou senha invalidos!";
}
elseif (password_verify($_POST['senha'], $resposta[0]->senha)){
    $_SESSION["id_login"] = $resposta[0]->id_usuario;
    $_SESSION["aprovado"] = true;

        if($resposta[0]->super_user){
            $_SESSION["adm"] = true;
        }else{
            $_SESSION["adm"] = false;
        }

    header('location: ../index.php');
}else{
    $_SESSION["aprovado"] = false;
    echo "Usuario ou senha invalidos!";
}
