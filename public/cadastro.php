<?php

include '../includes/guest.php';

include '../includes/header.php';

if (isset($_SESSION['erro'])) :

?>

<script>
	alert("<?= $_SESSION['erro']; ?>");
</script>

<?php
	unset($_SESSION['erro']);
	endif;
?>

<?php if (isset($_SESSION['erro'])) : ?>
	<p 
		class="erro">
        	<?= $_SESSION['erro']; ?>
    	</p>

    	<?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<style>	
	.mostrar-senha {
    		display: flex;
		align-items: flex-start;
    		justify-content: flex-start;
    		gap: 6px;
	}

	.mostrar-senha input {
    		width: auto;
	}
</style>

<div class="form-container">

	<h1>Cadastro</h1>

	<?php if (isset($_SESSION['erro'])) : ?>

		<p 
			class="erro">
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
				id="senha"
				required
        		>

		<label>

		<div class="mostrar-senha">

    			<input
        			type="checkbox"
        			id="mostrar_senha"
    			>

			<label 
				for="mostrar_senha">
        			Mostrar senha
    			</label>
		</div>
	</label>

	<label>Confirmar senha</label>

	<input
    		type="password"
		name="confirmar_senha"
		id="confirmar_senha"
    		required
	>

	<button 
		type="submit">
            	Cadastrar
        </button>

    	</form>

</div>

<script>

const checkbox = document.querySelector('#mostrar_senha');
const senha = document.querySelector('#senha');
checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            	senha.type = 'text';
        } else {
            	senha.type = 'password';
        }
});

</script>

<?php
include '../includes/footer.php';
?>
