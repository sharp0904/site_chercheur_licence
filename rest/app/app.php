<?php

$app = require __DIR__ . '/config/config.php';

$app = require __DIR__ . '/config/controllers/Login.php';
$app = require __DIR__ . '/config/controllers/Categorie.php';
$app = require __DIR__ . '/config/controllers/Publication.php';
$app = require __DIR__ . '/config/controllers/Menu.php';
$app = require __DIR__ . '/config/controllers/Rubrique.php';

return $app;
