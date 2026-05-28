<?php

session_start();

require "../includes/db.php";

include '../includes/header.php';

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




<div class="form-container">

	<title>Login</title>

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
</div>

	nao tem conta? <a 
		href="cadastro.php">cadastro
	</a>

<?php
include '../includes/footer.php';
?>
