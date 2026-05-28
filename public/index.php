<?php

require "../includes/db.php";

include '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM produtos");

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<style>

	.horizontal-container{
		display: flex;
		flex-wrap: wrap;
		justify-content: space-around;
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

</style>
	
<h1>Lista de Cafés</h1>

<div class="horizontal-container">

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
