<?php
session_start();
$host = '50.16.128.166';
$port='3306';
$db = 'Projeto_Comentario';
$user = 'root';
$passwd = 'minhaSenha';

try {
    $connection = new PDO ("mysql:host={$host};port={$port};dbname={$db}", $user,$passwd);
} catch (Exception $error) {
    echo "Ocorreu o seguinte erro: {$error->getMessage()}";
}

$sql = 'SELECT * FROM comentarios';
$result = $connection->prepare($sql);
$result->execute();
$comentarios = $result->fetchAll(PDO::FETCH_OBJ);

$html = "
<table class='table'>
    <thead>
        <tr>
            <th scope='col'></th>
            <th scope='col'>id-Comentario</th>
            <th scope='col'>Conteudo</th>
            <th scope='col'>Autor</th>
            <th scope='col'>Excluir</th>
        </tr>
    </thead>
    <tbody>
";
foreach ($comentarios as $comentario) {
    if(isset($_SESSION['id_login'])){
        $criou = $_SESSION['id_login'] == $comentario->fk_autor_comentario;
    }else{
        $criou = false;
    }

    if($comentario->fk_autor_comentario == null){
        $_SESSION['nome_autor'] = 'Autor anônimo';
        $_SESSION['avatar_autor'] = 'default-icon.png';
    }else{
        $sql = 'SELECT * FROM usuario_info where fk_login = :id';
        $result = $connection->prepare($sql);
        $result->bindValue(':id',$comentario->fk_autor_comentario);
        $result->execute();
        $comentador = $result->fetchAll(PDO::FETCH_OBJ);
        $_SESSION['nome_autor'] = $comentador[0]->nome_usuario;
        $_SESSION['avatar_autor'] = $comentador[0]->avatar;
    }

    $html .= "
        <tr>
            <th scope='row'>
                <div class='imagem'>
                    <img src='./register/img/{$_SESSION['avatar_autor']}' alt='Avatar'>
                </div>
            </th>
            <td>{$comentario->data}</td>
            <td>{$comentario->conteudo}</td>
            <td>{$_SESSION['nome_autor']}</td>
            <td>";
            if($criou){
                $html .="<a href='../comments/excluirComentario.php'>Excluir</a>";
            }
            $html .="</td>
        </tr>
    ";
    $html .= "</div>";
}
$html .= "
</tbody>
</table>";

echo $html;
