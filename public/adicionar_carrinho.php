<?php

session_start();

require "../includes/db.php";

$id = intval($_POST['produto_id']);

$moagem = $_POST['moagem'];

$peso = $_POST['peso'];

$quantidade = intval($_POST['quantidade']);

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");

$stmt->execute([$id]);

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}

$item = [

    'id' => $produto['id'],

    'nome' => $produto['nome'],

    'preco' => $produto['preco'],

    'moagem' => $moagem,

    'peso' => $peso,

    'quantidade' => $quantidade

];

$_SESSION['carrinho'][] = $item;

header("Location: carrinho.php");

exit;
