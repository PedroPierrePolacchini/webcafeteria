<?php

session_start();

require "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Acesso inválido.');
}

if (!isset($_SESSION['usuario'])) {

    header("Location: ../public/login.php");

    exit;
}

$carrinho = $_SESSION['carrinho'] ?? [];

if (empty($carrinho)) {

    die("Carrinho vazio.");
}

$usuario_id =
    $_SESSION['usuario']['id'];

$total = 0;

foreach ($carrinho as $item) {

    $total +=
        $item['preco'] *
        $item['quantidade'];
}

try {

    $pdo->beginTransaction();

    /*
    =========================
    CRIA PEDIDO
    =========================
    */

    $stmt = $pdo->prepare("
        INSERT INTO pedidos
        (usuario_id, total)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $usuario_id,
        $total
    ]);

    /*
    =========================
    PEGA ID DO PEDIDO
    =========================
    */

    $pedido_id =
        $pdo->lastInsertId();

    /*
    =========================
    INSERE ITENS
    =========================
    */

    $stmtItem = $pdo->prepare("
        INSERT INTO itens_pedido
        (
            pedido_id,
            produto_id,
            quantidade,
            preco,
            moagem,
            peso
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    foreach ($carrinho as $item) {

        $stmtItem->execute([

            $pedido_id,

            $item['id'],

            $item['quantidade'],

            $item['preco'],

            $item['moagem'],

            $item['peso']

        ]);
    }

    /*
    =========================
    FINALIZA TRANSAÇÃO
    =========================
    */

    $pdo->commit();

    /*
    =========================
    LIMPA CARRINHO
    =========================
    */

    unset($_SESSION['carrinho']);

} catch (Exception $e) {

    $pdo->rollBack();

    die("Erro ao finalizar pedido.");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Pedido Finalizado</title>

</head>

<body>

    <h1>
        Pedido realizado com sucesso!
    </h1>

    <p>
        Número do pedido:
        <?= $pedido_id ?>
    </p>

    <a href="../public/index.php">
        Voltar à loja
    </a>

</body>
</html>
