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
		color: black;
	    	padding: 20px;
		margin-bottom: 20px;
            	border-radius: 10px;
        }

	.preco {
            	color: green;
            	font-size: 20px;
            	font-weight: bold;
        }

	.produto-link {
		display: inline-block;
    		background-color: #353331;
    		color: white;
    		padding: 10px 18px;
    		border-radius: 6px;
    		text-decoration: none;
    		font-weight: bold;
    		transition: 0.2s;
	}

	.produto-link:hover {
    		background-color: gray;
    		transform: translateY(-2px);
	}
	
	h1{
		margin-left: 15px;
	}

</style>
	
<h1>Cardápio</h1>

<div class="horizontal-container">

<?php foreach ($produtos as $produto): ?>

	<div class="produto">

		<div class="horizontal-container">

		<h2>
        		<?= htmlspecialchars($produto['nome']) ?>
		</h2>

	    	<p 
			class="preco">
                	R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
	    	</p>

		</div>

		<div class="horizontal-container">

            	<p>
                	<?= htmlspecialchars($produto['descricao']) ?>
		</p>

		</div>

		<div class="horizontal-container">

		<a
			class="produto-link"
                	href="produto.php?id=<?= $produto['id'] ?>">
                	ver produto
		</a>

		</div>

        </div>

<?php endforeach; ?>

</div>

<?php
	include '../includes/footer.php';
?>
