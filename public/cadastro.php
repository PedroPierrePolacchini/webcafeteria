<?php

require "../includes/db.php";

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);

    $email = trim($_POST['email']);

    $senha = $_POST['senha'];

	$confirmar_senha = $_POST['confirmar_senha'];

    	if (
        	empty($nome) ||
        	empty($email) ||
        	empty($senha)
    	) {

        	$erro = "Preencha todos os campos.";

    	} elseif ($senha !== $confirmar_senha) {

	    $erro = "As senhas não coincidem.";

	} else {

        	$hash = password_hash(
            	$senha,
            	PASSWORD_DEFAULT
        );

        $stmt = $pdo->prepare("
            	INSERT INTO usuarios
            	(nome, email, senha)
		VALUES (?, ?, ?)
	");

        try {

            	$stmt->execute([
                	$nome,
                	$email,
                	$hash
            	]);

            header("Location: login.php");

            exit;

        } catch (PDOException $e) {

            $erro = "E-mail já cadastrado.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Cadastro</title>

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

        <h1>Cadastro</h1>

        <?php if ($erro): ?>

            <p class="erro">
                <?= $erro ?>
            </p>

        <?php endif; ?>

        <input
            type="text"
            name="nome"
            placeholder="Nome"
        >

        <input
            type="email"
            name="email"
            placeholder="E-mail"
        >

        <input
            type="password"
	    name="senha"
		id="senha"
            placeholder="Senha"
        >

	<label>

    		<input
			type="checkbox"
        		id="mostrarSenha"
    		>
		Mostrar senha

	</label>

	<input
    		type="password"
    		name="confirmar_senha"
    		id="confirmar_senha"
    		placeholder="Confirmar senha"
	>

        <button type="submit">
            Cadastrar
        </button>

    </form>

<script>

	const checkbox =
		document.getElementById("mostrarSenha");

	checkbox.addEventListener("change", function() {

    	const senha =
        	document.getElementById("senha");

    	if (checkbox.checked) {

        	senha.type = "text";

    	} else {

        	senha.type = "password";

    	}

	});

</script>

</body>
</html>
