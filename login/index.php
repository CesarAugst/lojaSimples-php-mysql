<?php include_once '../components/header.php' ?>

<body class="container">
    <a href="../">Voltar</a>
    <h1>Minha tela de LOGIN</h1>

    <form action="server.php" method="POST">
        <div class="form-group">
            <label>LOGIN</label>
            <input type="text" class="form-control" placeholder="Seu login..." name="login">
        </div>
        <div class="form-group">
            <label>SENHA</label>
            <input type="password" class="form-control" placeholder="Sua senha..." name="senha">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

<?php include_once '../components/footer.php'?> 