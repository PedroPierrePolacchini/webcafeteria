<?php

require "../includes/db.php";

$stmt = $pdo->query("SELECT * FROM produtos");

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 40px;
        }

        h1 {
            margin-bottom: 30px;
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
</head>
<body>

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

        </div>

    <?php endforeach; ?>

</body>
</html>
