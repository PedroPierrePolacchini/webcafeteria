<?php

session_start();

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    	die('Acesso inválido.');
}

$nome = trim($_POST['nome']);

$email = trim($_POST['email']);

$senha = trim($_POST['senha']);

$confirmar_senha = trim($_POST['confirmar_senha']);
if (empty($nome) || empty($email) || empty($senha)) {
    	die('Preencha todos os campos.');
}

$sql = "
    	SELECT id
    	FROM usuarios
    	WHERE email = :email
	";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    	':email' => $email
]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario) {

    	$_SESSION['erro'] = 'Email já cadastrado.';

    	header('Location: ../public/cadastro.php');

    	exit;

}

if ($senha !== $confirmar_senha) {

    	$_SESSION['erro'] = 'As senhas não coincidem.';

    	header('Location: ../public/cadastro.php');
	
    	exit;
}

$senha_hash = password_hash(
    	$senha,
    	PASSWORD_DEFAULT
);

$sql = "
    	INSERT INTO usuarios
    	(nome, email, senha)

    	VALUES
    	(:nome, :email, :senha)
	";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    	':nome' => $nome,
    	':email' => $email,
    	':senha' => $senha_hash
]);

header('Location: ../public/login.php');

exit;
