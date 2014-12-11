<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Appli\PasswordEncoder;

$app->post('/login', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $attributes = json_decode($request->getContent());
    if (!isset($attributes->{'username'}) || !isset($attributes->{'password'})) {
        return new Response('Attributes username or password not here', 404);
    }
    $sqlRequest = 'SELECT login, password FROM user WHERE login = ?';
    $result = $app['db']->fetchAssoc($sqlRequest, array($attributes->{'username'}));
    if (null == $result) {
        return new Response('User don\'t exist', 400);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->verifyPassword($result['password'], $attributes->{'password'})) {
        return new Response($encoder->encodePassword('Admin connected'), 200);
    }

    return new Response('Admin not connected', 400);
});

return $app;
