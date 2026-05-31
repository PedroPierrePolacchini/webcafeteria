<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	die('Acesso inválido.');
}

if (!isset($_POST['indice'])) {
    	die('Item não informado.');
}

$indice = intval($_POST['indice']);

if (!isset($_SESSION['carrinho'][$indice])) {
    	die('Item inexistente.');
}

unset($_SESSION['carrinho'][$indice]);

$_SESSION['carrinho'] = array_values($_SESSION['carrinho']);

header('Location: ../public/carrinho.php');

exit;
