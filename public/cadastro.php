<?php

session_start();

include '../includes/header.php';

?>

<?php if (isset($_SESSION['erro'])) : ?>

    <p class="erro">

        <?= $_SESSION['erro']; ?>

    </p>

    <?php unset($_SESSION['erro']); ?>

<?php endif; ?>

<div class="form-container">

    <h1>Cadastro</h1>

	<?php if (isset($_SESSION['erro'])) : ?>

		<p class="erro">

			<?= $_SESSION['erro']; ?>
		</p>

		<?php unset($_SESSION['erro']); ?>
	<?php endif; ?>

    <form action="../actions/realizar_cadastro.php" method="POST">

        <label>Nome</label>

        <input
            type="text"
            name="nome"
            required
        >

        <label>Email</label>

        <input
            type="email"
            name="email"
            required
        >

        <label>Senha</label>

        <input
            type="password"
            name="senha"
            required
        >

        <button type="submit">
            Cadastrar
        </button>

    </form>

</div>

<?php
include '../includes/footer.php';
?>
