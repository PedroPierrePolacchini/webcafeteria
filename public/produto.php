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
$sql = "
	SELECT
    	a.*,
    	u.nome
	FROM avaliacoes a
	JOIN usuarios u
    	ON a.usuario_id = u.id
	WHERE a.produto_id = ?
	ORDER BY a.data_avaliacao DESC
	";

$stmt = $pdo->prepare($sql);

$stmt->execute([$produto['id']]);

$avaliacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "
	SELECT
    	AVG(nota) as media
	FROM avaliacoes
	WHERE produto_id = ?
	";

$stmt = $pdo->prepare($sql);

$stmt->execute([$produto['id']]);

$media = $stmt->fetch(PDO::FETCH_ASSOC);

$avaliacaoUsuario = null;

if (isset($_SESSION['usuario'])) {
	$sql = "
		SELECT *
    		FROM avaliacoes
    		WHERE usuario_id = ?
    		AND produto_id = ?
    		";

    	$stmt = $pdo->prepare($sql);

    	$stmt->execute([
        	$_SESSION['usuario']['id'],
        	$produto['id']
    	]);

    	$avaliacaoUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

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

	.produto-container,
	.avaliacoes-container,
	.avaliar-container {
    		background: white;
    		padding: 25px;
    		border-radius: 12px;
    		margin: 20px auto;
    		max-width: 700px;
    		box-shadow: 0 2px 10px rgba(0,0,0,0.08);
	}

	.avaliacao-card {
    		border-bottom: 1px solid #ddd;
    		padding: 15px 0;
	}

	.avaliacao-card:last-child {
    		border-bottom: none;
	}

	.avaliacao-usuario {
    		font-weight: bold;
    		font-size: 18px;
	}

	.avaliacao-nota {
    		color: #d4a017;
    		font-weight: bold;
	}

	.avaliacao-comentario {
    		margin-top: 10px;
	}

	.media-produto {
    		background: #f4f4f4;
    		padding: 12px;
    		border-radius: 8px;
    		text-align: center;
    		font-size: 20px;
    		margin-bottom: 20px;
	}

	.aviso-avaliacao {
    		background: #e8f5e9;
    		color: #2e7d32;
    		padding: 12px;
    		border-radius: 8px;
    		margin-bottom: 20px;
	}

	textarea {
    		width: 100%;
    		min-height: 120px;
    		resize: vertical;
	}

	.avaliar-container button {
    		margin-top: 15px;
	}

</style>

<div class = "form-container">
	<h1>
            <?= htmlspecialchars($produto['nome']) ?>
	</h1>

	<div class="produto-container">
        	<p>
            		<?= htmlspecialchars($produto['descricao']) ?>
        	</p>

		<p 
			class="preco">
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

	    	<button 
			type="submit">
                	Adicionar ao carrinho
	    	</button>

		<p 
			id="mensagem-carrinho">
		</p>

        </form>

    	</div>
</div>

<h2>Avaliações</h2>

<?php if ($media['media']): ?>

	<div class="media-produto">
    		Média dos clientes:
    		<strong>
        		<?= number_format($media['media'], 1) ?> / 5.0
		</strong>
	</div>

<?php endif; ?>

<?php foreach ($avaliacoes as $avaliacao): ?>

	<div class="avaliacoes-container">
	<div class="avaliacao-card">
	<div class="avaliacao-usuario">
    		<?= htmlspecialchars($avaliacao['nome']) ?>
	</div>

	<div class="avaliacao-nota">
    		<?= str_repeat('★', $avaliacao['nota']) ?>
    		<?= str_repeat('☆', 5 - $avaliacao['nota']) ?>
	</div>

	<div class="avaliacao-comentario">
		<?= nl2br(htmlspecialchars($avaliacao['comentario'])) ?>
	</div>
</div>
</div>

<?php endforeach; ?>

<?php if (isset($_SESSION['usuario'])): ?>

	<?php if ($avaliacaoUsuario): ?>

		<div class="aviso-avaliacao">
            		Você já avaliou este produto.
            		Alterar os dados abaixo irá atualizar sua avaliação.

        	</div>

	<?php endif; ?>

	<div class="avaliar-container">
    	<h3>
	<?= $avaliacaoUsuario
		? 'Atualizar Avaliação'
		: 'Avaliar Produto' ?>

    	</h3>

    	<form action="../actions/avaliar_produto.php"method="POST">

        	<input
            		type="hidden"
            		name="produto_id"
            		value="<?= $produto['id'] ?>"
        	>

        <label>Nota</label>

        <select name="nota">

		<?php for ($i = 5; $i >= 1; $i--): ?>

                	<option
				value="<?= $i ?>"
				<?= ($avaliacaoUsuario &&$avaliacaoUsuario['nota'] == $i)
                    		? 'selected'
                    		: '' ?>
			>

			<?= $i ?>

                	</option>

            	<?php endfor; ?>

        </select>

        <label>Comentário</label>

	<textarea
        	name="comentario"
            	rows="4"
            	maxlength="500"
            	required
	>
		<?= $avaliacaoUsuario? htmlspecialchars($avaliacaoUsuario['comentario']): '' ?></textarea>

        <button type="submit">
            	<?= $avaliacaoUsuario
                ? 'Atualizar Avaliação'
                : 'Enviar Avaliação' ?>

	</button>

    </form>

</div>

<?php endif; ?>

<script>
document.getElementById('form-carrinho').addEventListener('submit', async function(event) {
	event.preventDefault();
	const formData = new FormData(this);
	try {
		const resposta = await fetch('../actions/adicionar_carrinho.php',{
                    	method: 'POST',
                    	body: formData
                }
            );

            const dados = await resposta.json();
            const mensagem = document.getElementById('mensagem-carrinho');
            mensagem.textContent = dados.mensagem;
            mensagem.style.color = dados.sucesso ? 'green': 'red';

        } catch (erro) {
		document.getElementById('mensagem-carrinho').textContent = 'Erro ao adicionar produto.';
        }

});

</script>

<?php
include '../includes/footer.php';
?>
