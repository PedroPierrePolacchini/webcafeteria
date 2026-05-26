<?php

session_start();

$indice = $_GET['indice'];

unset($_SESSION['carrinho'][$indice]);

$_SESSION['carrinho'] =
    array_values($_SESSION['carrinho']);

header("Location: carrinho.php");

exit;
