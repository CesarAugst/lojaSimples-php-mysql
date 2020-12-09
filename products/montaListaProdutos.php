<?php
$adm = $_SESSION["adm"] ?? false;

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

//organiza os filtros
if(isset($_GET['filtro'])){
    $filtro = $_GET['filtro'] == '' ? "'tudo'": "'{$_GET['filtro']}'";
}else{
    $filtro = "'tudo'";
}
$categoria = isset($_GET['categoria']) ? "'{$_GET['categoria']}'": "'tudo'" ;

//chama os produtos
$sql = "CALL lista_produtos({$categoria},{$filtro})";
$result = $connection->prepare($sql);
$result->execute();
$produtos = $result->fetchAll(PDO::FETCH_OBJ);

$html = "
<table class='table'>
    <thead>
        <tr>
            <th scope='col'></th>
            <th scope='col'>Descrição</th>
            <th scope='col'>Nome</th>
            <th scope='col'>Valor</th>
            <th scope='col'>Descricao</th>
            <th scope='col'>Categoria</th>
            <th scope='col'></th>
        </tr>
    </thead>
    <tbody>
";
foreach ($produtos as $produto) {
    $html .= "
        <tr>
            <th scope='row'>
                <div class='imagem'>
                    <img src='./img/{$produto->imagem}' alt='Produto'>
                </div>
            </th>
            <td><a href='./products/produto.php?id={$produto->id_produto}'>Visualizar</a></td>
            <td>{$produto->nome}</td>
            <td>{$produto->valor}</td>
            <td>{$produto->descricao}</td>
            <td>{$produto->categoria}</td>
    ";

    if($adm){
        $html.="<td><a href='./products/excluirProduto.php?id={$produto->id_produto}'>Excluir</a></td>";
    }

    $html .= "</tr></div>";
}
$html .= "
</tbody>
</table>";

echo $html;
