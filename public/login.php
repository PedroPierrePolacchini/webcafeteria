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
            required
        >

        <button type="submit">
            Entrar
        </button>

    </form>

</div>

<?php
include '../includes/footer.php';
?>
