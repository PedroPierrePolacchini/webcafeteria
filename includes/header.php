<!DOCTYPE html>

<?php

	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
?>

<link rel="stylesheet" href="/cafeteria/assets/style.css">

<html lang="pt-br">

<head>
    	<meta charset="UTF-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>Cafeteria</title>
    	<link rel="stylesheet" href="/cafeteria/assets/css/style.css">
</head>

<style>

	body{
		background-color: white;
	}

	nav{
		display: flex;
		align-items: center;

		gap: 10px;
		font-size: 24px;		
		background-color: #4e4b48;
	}

	header{
		background-color: #4e4b48;
	}

	nav a{
	    	background-color: #353331;
		color:white;
    		padding: 10px 20px;
    		border-radius: 6px;
		font-weight: bold;
		transition: 0.2s;
	}

	nav a:hover {

    		background-color: gray;

    		transform: translateY(-2px);
	}
		
	button{
		background-color: #353331;
		color:white;
		text-decoration: none;
		
    		padding: 10px 20px;
    		border-radius: 6px;
		font-weight: bold;
		transition: 0.2s;
	}

	button:hover{
	    	background-color: gray;
    		transform: translateY(-2px);
	}

	.usuario-logado {
    		font-weight: bold;
    		color: white;
    		padding: 10px;
	}


</style>

<body>

<header>

	<nav>

		<a 	
			href="../public/index.php">
            		Catálogo
        	</a>

		<a 	
			href="../public/carrinho.php">
            		Carrinho
		</a>


	<?php if (isset($_SESSION['usuario'])): ?>

		<span class="usuario-logado">

    			Olá, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>

		</span>

    		<form
        		action="/cafeteria/actions/logout.php"
        		method="POST"
   		>

		<button	type="submit">
            		Sair
        	</button>

    		</form>

	<?php else: ?>

		<a 	
			href="../public/login.php">
			Login
		</a>
	
		<a 	
			href="../public/cadastro.php">
			Cadastro
		</a>

	<?php endif; ?>

    	</nav>

</header>
