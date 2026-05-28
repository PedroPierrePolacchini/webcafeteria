<?php

session_start();

require "../includes/db.php";

$stmt = $pdo->query("SELECT * FROM produtos");

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';

?>

<style>

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

</style>

	<?php if (isset($_SESSION['usuario'])): ?>

    		<p>

        		Olá, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>
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


<div class="form-container">
    <h1>Lista de Cafés</h1>

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

</div>

<?php
	include '../includes/footer.php';
?>
