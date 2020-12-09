<?php
session_start();
$_SESSION["logado"]=false;
$_SESSION = array();
session_destroy();
header('location: ../index.php');