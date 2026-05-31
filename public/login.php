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

<style>
	.mostrar-senha{
		display: flex;
		align-items: flex-start;
		justify-content: flex-start
		gap: 6px;
	}

	.mostrar-senha input {
		width: auto;
	}


</style>

<div class="form-container">

	<h1>Login</h1>

    	<form action="../actions/realizar_login.php" method="POST">

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

		<button 
			type="submit">
            		Entrar
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
