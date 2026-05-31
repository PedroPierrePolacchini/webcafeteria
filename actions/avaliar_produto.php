<?php

session_start();

require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	die('Acesso inválido.');
}


if (!isset($_SESSION['usuario'])) {
	die('Faça login para avaliar.');
}

$usuario_id = $_SESSION['usuario']['id'];

$produto_id = (int) $_POST['produto_id'];

$nota = (int) $_POST['nota'];

if ($nota < 1 || $nota > 5) {
	die('Nota inválida.');
}

if (strlen($comentario) > 500) {
	die('Comentário muito grande.');
}

$comentario = trim($_POST['comentario']);

$sql = "
	SELECT id
	FROM avaliacoes
	WHERE usuario_id = ?
	AND produto_id = ?
	";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    	$usuario_id,
    	$produto_id
]);

$avaliacao = $stmt->fetch();

if ($avaliacao) {
	$sql = "
    		UPDATE avaliacoes
    		SET
        	nota = ?,
        	comentario = ?
    		WHERE
        	usuario_id = ?
    		AND
        	produto_id = ?
	";

	$stmt = $pdo->prepare($sql);

	$stmt->execute([
		$nota,
        	$comentario,
        	$usuario_id,
        	$produto_id
	]);

} else {

    	$sql = "
    		INSERT INTO avaliacoes(
        		usuario_id,
        		produto_id,
        		nota,
        		comentario
    		)
    		VALUES(
        	?, ?, ?, ?
    		)
    	";

    	$stmt = $pdo->prepare($sql);

    	$stmt->execute([
		$usuario_id,
		$produto_id,
		$nota,
		$comentario
	]);
}

header(
    	'Location: ../public/produto.php?id=' .
    	$produto_id
);

exit;
