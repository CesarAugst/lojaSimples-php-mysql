<?php 
    session_start();
    include_once './descricaoProduto.php';
    $id_digitado = $_GET['id'];
    $produto = (descricaoProduto($id_digitado)[0]);
    $logado = $_SESSION["aprovado"] ?? false;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="../css/style.css" rel="stylesheet">

    <title>
        <?php echo $produto->nome?>
    </title>
</head>

<body class='container'>
    <h1>
        <?php echo $produto->nome?>
    </h1>

    <p>
        <?php echo $produto->descricao?>
    </p>
    <?php
    echo "
    <div class='imagemProduto'>
        <img src='../img/{$produto->imagem}' alt='Produto'>
    </div>
    ";
    if($logado){
        echo "
        <div class='col-1 mx-auto'>
        <form action='../carrinho/insereCarrinhoProduto.php?produto={$produto->id_produto}' method='POST'>
            <div class='form-group'>
                <label>Selecione a quantidade</label>
                <input type='number' class='form-control' name='quantidade'>
            </div>
            <button type='submit' class='btn btn-primary'>Adicionar</button>
        </form>
        </div><br><br>";
    }
    ?>
<div>
    <form action="./inserirComentario.php?product=<?php echo $produto->id_produto?>" method="post">
        <textarea class="form-control" placeholder="Insira o comentário" rows="3" , name='comentario'></textarea>
        <input type="submit" class="btn btn-primary mb-2" value="Enviar">
    </form>

    <?php include_once './montaComentarios.php';?>
    <a href="../">Voltar</a>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>