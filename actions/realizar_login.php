<?php

session_start();

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    die('Acesso inválido.');
}

$email = trim($_POST['email']);

$senha = trim($_POST['senha']);

if (
    empty($email) ||
    empty($senha)
) {

    $_SESSION['erro'] = 'Preencha todos os campos.';

    header('Location: ../public/login.php');

    exit;
}

$sql = "
    SELECT *
    FROM usuarios
    WHERE email = :email
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':email' => $email
]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {

    $_SESSION['erro'] = 'Email ou senha inválidos.';

    header('Location: ../public/login.php');

    exit;
}

if (!password_verify($senha, $usuario['senha'])) {

    $_SESSION['erro'] = 'Email ou senha inválidos.';

    header('Location: ../public/login.php');

    exit;
}

$_SESSION['usuario'] = [

    'id' => $usuario['id'],

    'nome' => $usuario['nome'],

    'email' => $usuario['email']
];

header('Location: ../public/index.php');

exit;
