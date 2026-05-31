<?php

require "../includes/db.php";

include '../includes/header.php';

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");

$stmt->execute([$id]);

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}

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

<form id="form-carrinho">

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

                <option value="250ml">
                    250ml
                </option>

                <option value="500ml">
                    500ml
                </option>

                <option value="1L">
                    1L
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

<p id="mensagem-carrinho"></p>

        </form>

    	</div>
</div>
<script>

document
    .getElementById('form-carrinho')
    .addEventListener('submit', async function(event) {

        event.preventDefault();

        const formData = new FormData(this);

        try {

            const resposta = await fetch(
                '../actions/adicionar_carrinho.php',
                {
                    method: 'POST',
                    body: formData
                }
            );

            const dados = await resposta.json();

            const mensagem =
                document.getElementById(
                    'mensagem-carrinho'
                );

            mensagem.textContent =
                dados.mensagem;

            mensagem.style.color =
                dados.sucesso
                    ? 'green'
                    : 'red';

        } catch (erro) {

            document.getElementById(
                'mensagem-carrinho'
            ).textContent =
                'Erro ao adicionar produto.';
        }

    });

</script>
<?php
include '../includes/footer.php';
?>
