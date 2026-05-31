<?php

session_start();

require '../includes/db.php';

$codigo = strtoupper(
        trim($_POST['cupom'])
    	);

$sql = "
	SELECT *
	FROM cupons
	WHERE codigo = :codigo
	AND ativo = 1
	";

$stmt = $pdo->prepare($sql);

$stmt->execute([':codigo' => $codigo]);

$cupom = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cupom) {
    	$_SESSION['erro'] = 'Cupom inválido.';

} else {
	$_SESSION['cupom'] = [
		'codigo' => $cupom['codigo'],
		'desconto' => $cupom['desconto']
	];
}

header(
	'Location: ../public/carrinho.php'
);

exit;
