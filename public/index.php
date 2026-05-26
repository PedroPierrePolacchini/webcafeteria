<?php

session_start();

require "../includes/db.php";

$stmt = $pdo->query("SELECT * FROM produtos");

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cafeteria</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 40px;
        }

        h1 {
            margin-bottom: 30px;
        }

        .produto {
            background: white;
	    padding: 20px;
		margin-bottom: 20px;
            border-radius: 10px;
        }

        .preco {
            color: green;
            font-size: 20px;
            font-weight: bold;
        }

        .botao {
            display: inline-block;
	    margin-top: 10px;
		margin-bottom: 20px;
            padding: 10px 15px;

            background: brown;
            color: white;

            text-decoration: none;
            border-radius: 5px;
        }

        .botao:hover {
	    background: black;
        }

    </style>
</head>

<body>

	<?php if (isset($_SESSION['usuario'])): ?>

    		<p>

        		Olá,
        		<?= htmlspecialchars(
            		$_SESSION['usuario']['nome']
        		) ?>

    		</p>

    		<a href="../actions/logout.php">
        	Sair
    		</a>

	<?php else: ?>

    		<a href="login.php">
        		Login
    		</a>

    		<a href="cadastro.php">
        		Cadastro
    		</a>

	<?php endif; ?>

    <h1>Lista de Cafés</h1>

	<a
		class="botao"
		href="carrinho.php">
		Ver Carrinho
	</a>

    <?php foreach ($produtos as $produto): ?>

        <div class="produto">

            <h2>
                <?= htmlspecialchars($produto['nome']) ?>
            </h2>

            <p>
                <?= htmlspecialchars($produto['descricao']) ?>
            </p>

            <p class="preco">
                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            </p>

            <a
                class="botao"
                href="produto.php?id=<?= $produto['id'] ?>">
                Ver produto
            </a>

        </div>

    <?php endforeach; ?>

</body>
</html>
