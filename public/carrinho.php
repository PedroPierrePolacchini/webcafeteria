<?php

session_start();

$carrinho = $_SESSION['carrinho'] ?? [];

$total = 0;

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Carrinho</title>

    <style>

        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 40px;
        }

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

        .remover {
            display: inline-block;
            margin-top: 10px;
            padding: 10px;

            background: red;
            color: white;

            text-decoration: none;
            border-radius: 5px;
	}
	
	.botao {
		display: inline-block;
		margin-top: 10px;
		margin-bottom: 10px;
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

    <h1>Seu Carrinho</h1>

    <?php if (empty($carrinho)): ?>

        <p>Carrinho vazio.</p>

    <?php else: ?>

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

                <p>
                    Quantidade:
                    <?= $item['quantidade'] ?>
                </p>

                <p>
                    Subtotal:
                    R$
                    <?= number_format($subtotal, 2, ',', '.') ?>
                </p>

                <a
                    class="remover"
                    href="remover_carrinho.php?indice=<?= $indice ?>"
                >
                    Remover
		</a>
	
            </div>

        <?php endforeach; ?>

        <p class="total">

            Total:
            R$ <?= number_format($total, 2, ',', '.') ?>

        </p>

    <?php endif; ?>

	<a
		class="botao"
		href="index.php">
		voltar ao catalogo
	</a>

	<a href="finalizar.php">

    	<button>
        Finalizar Compra
    	</button>

	</a>

</body>
</html>
