<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;

$app = new Application();

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'dbname'    => 'webchercheur',
        'host'      => 'localhost',
        'user'      => 'root',
        'password'  => '3010potter',
    ),
));

return $app;
