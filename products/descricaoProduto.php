<?php

function descricaoProduto($id)
{
    include_once '../sql/connection.php';
    $sql = "CALL descricao_produto(:id)";
    $result = $connection->prepare($sql);
    $result->bindValue(':id', $id);
    $result->execute();
    $resposta = $result->fetchAll(PDO::FETCH_OBJ);
    return $resposta;
}
