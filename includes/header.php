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
	nav{
		display: flex;
		align-items: center;

		gap: 10px;
		font-size: 24px;		
		background-color: pink;
	}

	header{
		background-color: red;
	}

	nav a{
	    	background-color: black;
		color:white;
    		padding: 10px 20px;
    		border-radius: 6px;
    		font-weight: bold;
	}

	nav a:hover {

    		background-color: gray;

    		transform: translateY(-2px);
	}


</style>

<body>

<header>

	<nav>

		<a 	
			href="../public/index.php">
            		Catalogo
        	</a>

		<a 	
			href="../public/carrinho.php">
            		Carrinho
		</a>


	<?php if (isset($_SESSION['usuario'])): ?>

		<a	class="header-text">
			Olah, <?=htmlspecialchars($_SESSION['usuario']['nome']) ?>
		</a>

    		<form
        		action="/cafeteria/actions/logout.php"
        		method="POST"
   		>

        	<button type="submit">
            		Sair
        	</button>

    </form>

	<?php else: ?>

		<a 	
			class='button'
			href="../public/login.php">
			login
		</a>
	
		<a 	
			class="button"
			href="../public/cadastro.php">
			cadastro
		</a>

	<?php endif; ?>

    	</nav>

</header>
