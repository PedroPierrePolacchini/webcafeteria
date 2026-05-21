<?php

$pdo = new PDO(
    "mysql:host=localhost;dbname=cafeteria;charset=utf8",
    "cafeteria_user",
    "1234"
);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
