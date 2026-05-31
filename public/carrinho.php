<?php

include '../includes/header.php';

$carrinho = $_SESSION['carrinho'] ?? [];

$total = 0;
$desconto = 0;
$total_final = 0;

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
    class="form-atualizar"
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

<p class="subtotal" data-indice="<?= $indice ?>">
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

<?php

if (isset($_SESSION['cupom'])) {

    $desconto =
        $total *
        ($_SESSION['cupom']['desconto'] / 100);

}

$total_final = $total - $desconto;

?>

<form
    action="../actions/aplicar_cupom.php"
    method="POST"
>

    <input
        type="text"
        name="cupom"
        placeholder="Digite seu cupom"
    >

    <button type="submit">

        Aplicar Cupom

    </button>

</form>

<p>

    Subtotal:
    R$ <?= number_format($total, 2, ',', '.') ?>

</p>

<?php if (isset($_SESSION['cupom'])): ?>

    <p>

        Cupom:
        <?= htmlspecialchars(
            $_SESSION['cupom']['codigo']
        ) ?>

        (
        <?= $_SESSION['cupom']['desconto'] ?>
        %)

    </p>

    <p>

        Desconto:
        R$ <?= number_format(
            $desconto,
            2,
            ',',
            '.'
        ) ?>

    </p>

<?php endif; ?>

<p
    class="total"
    id="total-geral"
>

    Total:
    R$ <?= number_format(
        $total_final,
        2,
        ',',
        '.'
    ) ?>

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
            'Finalizar compra no valor de R$ <?= number_format($total_final, 2, ',', '.') ?> ?'
        );

        if (!confirmar) {

            event.preventDefault();
        }
    });

</script>

<script>

document
    .querySelectorAll('.form-atualizar')
    .forEach(form => {

        form.addEventListener(
            'submit',
            async function(event) {

                event.preventDefault();

                const formData =
                    new FormData(this);

                try {

                    const resposta =
                        await fetch(
                            '../actions/atualizar_quantidade.php',
                            {
                                method: 'POST',
                                body: formData
                            }
                        );

                    const dados =
                        await resposta.json();

                    document
                        .querySelector(
                            `.subtotal[data-indice="${dados.indice}"]`
                        )
                        .textContent =
                            'Subtotal: R$ ' +
                            dados.subtotal;

                    document
                        .getElementById(
                            'total-geral'
                        )
                        .textContent =
                            'Total: R$ ' +
                            dados.total;

                } catch (erro) {

                    alert(
                        'Erro ao atualizar quantidade.'
                    );
                }

            }
        );

    });

</script>

<?php
include '../includes/footer.php';
?>
