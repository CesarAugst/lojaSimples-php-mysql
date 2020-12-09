<?php
session_start();
$id_usuario = $_SESSION['id_login'];
$valor_total = 0;

include_once '../components/header.php';

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

$html = "
<a href='../'>Voltar</a>
<body class='container'>
<table class='table'>
    <thead>
        <tr>
            <th scope='col'></th>
            <th scope='col'>produto</th>
            <th scope='col'>quantidade</th>
            <th scope='col'>valor unitário</th>
            <th scope='col'>valor total</th>
            <th scope='col'></th>
        </tr>
    </thead>
    <tbody>
";

$sql = "CALL lista_carrinho(:id);";
$result = $connection->prepare($sql);
$result->bindValue(':id', $id_usuario);
$result->execute();
$carrinhos = $result->fetchAll(PDO::FETCH_OBJ);

foreach ($carrinhos as $carrinho) {
    $sql = "CALL descricao_produto(:id);";
    $result = $connection->prepare($sql);
    $result->bindValue(':id', $carrinho->fk_produto);
    $result->execute();
    $produtos = $result->fetchAll(PDO::FETCH_OBJ);

    foreach ($produtos as $produto) {
        $valor_total_produto = $produto->valor * $carrinho->quantidade;
        $valor_total += (float)$valor_total_produto;
        $valor_total_produto = number_format($produto->valor * $carrinho->quantidade, 2, ',', '');
        

        $html .= "
            <tr>
                <th scope='row'>
                    #
                </th>
                <td>{$produto->nome}</td>
                <td>{$carrinho->quantidade}</td>
                <td>{$produto->valor}</td>
                <td>{$valor_total_produto}</td>
                <td><a href='removerCarrinhoProduto.php?id={$carrinho->id_carrinho}'>Remover</a></td>
                ";

        $html .= "
                        </tr>
                    </div>
                    ";
    }
}
$valor_total = number_format($valor_total, 2, ',', '');
$html .= "
</tbody>
</table>
</body>
<p>Total da compra: {$valor_total}</p>
<a href='comprarCarrinho.php'>Comprar</a>";

echo $html;

include_once '../components/footer.php';