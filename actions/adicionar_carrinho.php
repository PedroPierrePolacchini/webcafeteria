<?php

session_start();

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	die('Acesso inválido.');
}

$produto_id = intval($_POST['produto_id']);

$moagem = trim($_POST['moagem']);

$peso = trim($_POST['peso']);

$quantidade = intval($_POST['quantidade']);

if ($quantidade < 1) {
	$quantidade = 1;
}

$sql = "SELECT * FROM produtos WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':id', $produto_id, PDO::PARAM_INT);

$stmt->execute();

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
	header('Content-Type: application/json');
	echo json_encode([
	'sucesso' => false,
	'mensagem' => 'Produto não encontrado.'
    ]);

	exit;
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

header('Content-Type: application/json');

echo json_encode([
    	'sucesso' => true,
    	'mensagem' => 'Produto adicionado ao carrinho.'
]);

exit;
