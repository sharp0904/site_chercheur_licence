<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Appli\UserProvider;

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
$app->register(new UrlGeneratorServiceProvider());
$app->register(new SecurityServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/views',
]);

$app['security.firewalls'] = [
    'admin' => [
        'pattern' => '^/admin',
        'form' => [
            'login_path' => '/login',
            'check_path' => '/admin/login_check',
            'default_target_path' => '/admin',
        ],
        'logout' => [
            'logout_path' => '/admin/logout',
            'invalidate_session' => false,
        ],
        'users' => $app->share(function () use ($app) {
            return new UserProvider($app['db']);
        }),
    ],
];

return $app;
