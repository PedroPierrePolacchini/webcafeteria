<?php

require "../includes/db.php";

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");

$stmt->execute([$id]);

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}

include '../includes/header.php';

?>
<div class = "form-container">

        <h1>
            <?= htmlspecialchars($produto['nome']) ?>
	</h1>

	<style>

        .produto-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
        }

        .preco {
            color: green;
            font-size: 24px;
            font-weight: bold;
        }

        select,
        input,
        button {
            display: block;
            width: 100%;
            margin-top: 10px;
            margin-bottom: 20px;
            padding: 10px;
        }

    </style>

</head>

<body>

    <div class="produto-container">



        <p>
            <?= htmlspecialchars($produto['descricao']) ?>
        </p>

        <p class="preco">
            R$
            <?= number_format($produto['preco'], 2, ',', '.') ?>
        </p>

        <form
            action="../actions/adicionar_carrinho.php"
            method="POST"
        >

            <input
                type="hidden"
                name="produto_id"
                value="<?= $produto['id'] ?>"
            >

            <label>Tipo de moagem</label>

            <select name="moagem">

                <option value="fina">
                    Fina
                </option>

                <option value="media">
                    Média
                </option>

                <option value="grossa">
                    Grossa
                </option>

            </select>

            <label>Peso</label>

            <select name="peso">

                <option value="250g">
                    250g
                </option>

                <option value="500g">
                    500g
                </option>

                <option value="1kg">
                    1kg
                </option>

            </select>

            <label>Quantidade</label>

            <input
                type="number"
                name="quantidade"
                value="1"
                min="1"
            >

            <button type="submit">
                Adicionar ao carrinho
	    </button>

        </form>

    	</div>
</div>

<?php
include '../includes/footer.php';
?>
