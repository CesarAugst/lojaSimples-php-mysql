<?php
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


$sql = "CALL lista_comentarios_por_produto(:id)";
$result = $connection->prepare($sql);
$result->bindValue(':id', $id_digitado);
$result->execute();
$comentarios = $result->fetchAll(PDO::FETCH_OBJ);

$html = "
<table class='table'>
    <thead>
        <tr>
            <th scope='col'></th>
            <th scope='col'>Id_comentario</th>
            <th scope='col'>Conteúdo</th>
            <th scope='col'>data</th>
            <th scope='col'>fk_autor</th>
            <th scope='col'></th>
        </tr>
    </thead>
    <tbody>
";
foreach ($comentarios as $comentario) {
    $sql = "CALL procura_nome_pelo_id(:id);";
    $result = $connection->prepare($sql);
    $result->bindValue(':id', $comentario->fk_autor);
    $result->execute();
    $nome = $result->fetchAll(PDO::FETCH_OBJ);
    if($_SESSION["id_login"] == $comentario->fk_autor){
        $criou = true;
    }else{
        $criou = false;
    }
    $html .= "
        <tr>
            <th scope='row'>
                #
            </th>
            <td>{$comentario->id_comentario}</td>
            <td>{$comentario->conteudo}</td>
            <td>{$comentario->data}</td>
            <td>{$nome[0]->nome}</td>
            <td>";

            if($criou){
                $html .= "<a href='./excluirComentario.php?comentario={$comentario->id_comentario}&produto={$id_digitado}'>Exluir</a>";
            }

    $html .= "</td>
                    </tr>
                </div>";
}
$html .= "
</tbody>
</table>";

echo $html;
