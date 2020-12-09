<?php
session_start();
include_once './components/buscaNomePeloIdLogin.php';
$logado = $_SESSION["aprovado"] ?? false;
$adm = $_SESSION["adm"] ?? false;
?>

<?php include_once './components/header.php'; ?>
<?php include_once './components/montaCategorias.php'; ?>

<body class="container">
    <h1>Loja do Cesar</h1>

    <?php
    if ($logado) {
        $nome = buscaNomePeloIdLogin($_SESSION['id_login']);
        echo "<br>Voce esta logado como {$nome}<br>";
        echo "<a href='./login/sair.php'>Fazer logoff</a><br>";
        echo "<a href='./carrinho/carrinho.php'>Meu carrinho</a><br>";
        if($adm){
            echo "<a href='./products/insereProdutoForm.php'>Cadastrar produtos</a>";
        }
    } else {
        echo "<a href='./login/index.php'>Fazer login</a><br>";
        echo "<a href='./register/index.php'>Se cadastrar</a>";
    }
    ?>

    <br>
    <br>
    <form method="get">
        <input type="text" name="filtro">
        <?php montaCategorias();?>
        <input type="submit" class="btn btn-primary mb-2" value="Pesquisar">
    </form>


    <?php include('./products/montaListaProdutos.php') ?>


    <?php include_once './components/footer.php' ?>