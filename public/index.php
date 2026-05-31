<?php

require "../includes/db.php";

include '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM produtos");

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<style>

.horizontal-container {

    display: flex;

    flex-wrap: wrap;

    justify-content: center;

    align-items: flex-start;

    gap: 30px;

    padding: 20px;
}

.produto-card {

    width: 280px;

    background-color: white;

    border-radius: 10px;

    padding: 20px;

    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

    text-align: center;
}

.produto-imagem {

    width: 100%;

    height: 180px;

    object-fit: cover;

    border-radius: 8px;
}

.produto-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-top: 15px;
}

.produto-header h2 {

    margin: 0;
}

.preco {

    color: green;

    font-size: 20px;

    font-weight: bold;

    margin: 0;
}

.descricao {

    margin: 20px 0;

    line-height: 1.5;
}

.produto-footer {

    text-align: center;
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

.busca-container {

    text-align: center;

    margin: 20px;
}

#busca {

    width: 300px;

    max-width: 90%;

    padding: 10px;

    border: 1px solid #ccc;

    border-radius: 6px;

    font-size: 16px;
}

h1 {

    margin-left: 15px;
}

</style>

<h1>Cardápio</h1>

<div class="busca-container">

    <input
        type="text"
        id="busca"
        placeholder="Buscar produto..."
    >

</div>

<div class="horizontal-container">

<?php foreach ($produtos as $produto): ?>

    <div class="produto-card">

        <img
            src="/cafeteria/<?= htmlspecialchars($produto['imagem']) ?>"
            alt="<?= htmlspecialchars($produto['nome']) ?>"
            class="produto-imagem"
        >

        <div class="produto-header">

            <h2>
                <?= htmlspecialchars($produto['nome']) ?>
            </h2>

            <p class="preco">
                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            </p>

        </div>

        <p class="descricao">
            <?= htmlspecialchars($produto['descricao']) ?>
        </p>

        <div class="produto-footer">

            <a
                class="produto-link"
                href="produto.php?id=<?= $produto['id'] ?>"
            >
                Ver produto
            </a>

        </div>

    </div>

<?php endforeach; ?>

</div>

<script>

const busca = document.getElementById('busca');

busca.addEventListener('keyup', function() {

    const texto = busca.value.toLowerCase();

    const produtos =
        document.querySelectorAll('.produto-card');

    produtos.forEach(function(produto) {

        const nome =
            produto.querySelector('h2')
                .textContent
                .toLowerCase();

        if (nome.includes(texto)) {

            produto.style.display = 'block';

        } else {

            produto.style.display = 'none';
        }
    });
});

</script>

<?php
include '../includes/footer.php';
?>
