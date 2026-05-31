<?php

include '../includes/header.php';

$carrinho = $_SESSION['carrinho'] ?? [];

$total = 0;

?>

<div class ="form-container">


    <h1>Seu Carrinho</h1>

    <style>

	.item {
	    	background: white;
            	padding: 20px;
            	margin-bottom: 20px;
            	border-radius: 10px;
        	}

        .total {
            	font-size: 24px;
            	font-weight: bold;
        	}
	
    </style>

	<?php foreach ($carrinho as $indice => $item): ?>

        	<?php

                	$subtotal = $item['preco'] * $item['quantidade'];

        		$total += $subtotal;

            	?>

        <div class="item">

        	<h2>
                	<?= htmlspecialchars($item['nome']) ?>
                </h2>

                <p>
                	Moagem:
                	<?= htmlspecialchars($item['moagem']) ?>
                </p>

                <p>
                	Peso:
                    	<?= htmlspecialchars($item['peso']) ?>
                </p>
	
		<form
            		action="../actions/atualizar_quantidade.php"
            		method="POST"
        	>

            		<input
                		type="hidden"
                		name="id"
                		value="<?= $indice; ?>"
            		>

            		<input
                		type="number"
                		name="quantidade"
                		value="<?= $item['quantidade']; ?>"
				min="1"
				max="99"
            		>

			<button 
				type="submit">
                		Atualizar
            		</button>

        	</form>

                <p>
                    	Subtotal: R$ <?= number_format($subtotal, 2, ',', '.') ?>
                </p>

		<form 
			action="../actions/remover_carrinho.php" method="POST">

    			<input
        			type="hidden"
        			name="indice"
        			value="<?= $indice ?>"
    			>

			<button 
				type="submit">
        			Remover
    			</button>

		</form>
	</div>

        <?php endforeach; ?>

        	<p class="total">

            	Total: R$ <?= number_format($total, 2, ',', '.') ?>

        	</p>

	<?php if ((isset($_SESSION['usuario'])) && (!empty($carrinho))): ?>

		<form id="form-finalizar" action="../actions/finalizar.php" method="POST">

    		<button type="submit">
        		Finalizar Compra
    		</button>

		</form>

	<?php elseif ((!isset($_SESSION['usuario'])) && (!empty($carrinho))): ?>
		
		Realize login para finalizar a compra <a href="login.php">
			login
		</a>

	<?php elseif (empty($carrinho)): ?>

		Carrinho vazio! Explore o catalogo <a href="index.php">
		</a>

	<?php endif; ?>
</div>
<script>

document
    .getElementById('form-finalizar')
    .addEventListener('submit', function(event) {

        const confirmar = confirm(
            'Finalizar compra no valor de R$ <?= number_format($total, 2, ',', '.') ?> ?'
        );

        if (!confirmar) {

            event.preventDefault();
        }
    });

</script>
<?php
include '../includes/footer.php';
?>
