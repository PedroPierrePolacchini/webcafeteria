<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Content-Type: application/json');

    echo json_encode([
        'sucesso' => false
    ]);

    exit;
}

$id = (int) $_POST['id'];

$quantidade = (int) $_POST['quantidade'];

if ($quantidade < 1) {

    $quantidade = 1;
}

if (isset($_SESSION['carrinho'][$id])) {

    $_SESSION['carrinho'][$id]['quantidade'] = $quantidade;
}

$item = $_SESSION['carrinho'][$id];

$subtotal =
    $item['preco'] *
    $item['quantidade'];

$total = 0;

foreach ($_SESSION['carrinho'] as $produto) {

    $total +=
        $produto['preco'] *
        $produto['quantidade'];
}

header('Content-Type: application/json');

echo json_encode([

    'sucesso' => true,

    'indice' => $id,

    'subtotal' => number_format(
        $subtotal,
        2,
        ',',
        '.'
    ),

    'total' => number_format(
        $total,
        2,
        ',',
        '.'
    )

]);

exit;
