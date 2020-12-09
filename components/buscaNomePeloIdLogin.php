<?php

function buscaNomePeloIdLogin($id)
{
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

    $sql = "CALL procura_nome_pelo_id(:id)";
    $result = $connection->prepare($sql);
    $result->bindValue(':id', $id);
    $result->execute();
    $nome = $result->fetchAll(PDO::FETCH_OBJ);
    return ($nome[0]->nome);
}