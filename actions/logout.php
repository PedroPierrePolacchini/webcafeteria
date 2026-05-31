<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	die('Acesso inválido.');
}

session_unset();

session_destroy();

header('Location: /cafeteria/public/login.php');

exit;
