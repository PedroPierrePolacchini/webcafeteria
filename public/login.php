<?php

session_start();

require "../includes/db.php";

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);

    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("
        SELECT * FROM usuarios
        WHERE email = ?
    ");

    $stmt->execute([$email]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (
        $usuario &&
        password_verify(
            $senha,
            $usuario['senha']
        )
    ) {

        $_SESSION['usuario'] = [

            'id' => $usuario['id'],

            'nome' => $usuario['nome'],

            'email' => $usuario['email']

        ];

        header("Location: index.php");

        exit;

    } else {

        $erro = "E-mail ou senha inválidos.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Login</title>

    <style>

        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 40px;
        }

        form {
            background: white;
            padding: 30px;
            max-width: 400px;
            margin: auto;
            border-radius: 10px;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        .erro {
            color: red;
        }

    </style>

</head>

<body>

    <form method="POST">

        <h1>Login</h1>

        <?php if ($erro): ?>

            <p class="erro">
                <?= $erro ?>
            </p>

        <?php endif; ?>

        <input
            type="email"
            name="email"
            placeholder="E-mail"
        >

        <input
            type="password"
            name="senha"
            placeholder="Senha"
        >

        <button type="submit">
            Entrar
        </button>

    </form>

</body>
</html>
