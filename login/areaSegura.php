<?php
session_start();
if($_SESSION["aprovado"]){
    echo '<br>';
    echo "Voce foi aprovado {$_SESSION['nome']} <br>";
    echo "<a href='sair.php'>LOGOFF</a>";
}else{
    echo 'Voce foi reprovado <br>';
    echo "<a href='index.php'>VOLTAR</a>";
}