<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    die('Acesso inválido.');
}

$id = $_POST['id'];

$quantidade = (int) $_POST['quantidade'];

if ($quantidade < 1) {

    $quantidade = 1;
}

if (isset($_SESSION['carrinho'][$id])) {

    $_SESSION['carrinho'][$id]['quantidade'] = $quantidade;
}

header('Location: ../public/carrinho.php');

exit;
