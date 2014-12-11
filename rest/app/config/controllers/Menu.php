<?php

use Symfony\Component\HttpFoundation\Response;

$app->get('/menus', function () use ($app) {
    $query = $app['db']->executeQuery('SELECT * FROM menu');
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No menus', 400);
    }
    $menus = array();
    foreach ($results as $menu) {
        array_push($menus, $menu);
    }
    $jsonMenus = json_encode($menus);

    return new Response($jsonMenus, 200);
});

$app->get('/menus/actif', function () use ($app) {
    $query = $app['db']->executeQuery('SELECT * FROM menu WHERE actif = 1 order by position');
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No menus', 400);
    }
    $menus = array();
    foreach ($results as $menu) {
        array_push($menus, $menu);
    }
    $jsonMenus = json_encode($menus);

    return new Response($jsonMenus, 200);
});

$app->get('/menus/{id}', function ($id) use ($app) {
    $req = 'SELECT * FROM menu WHERE ID = ?';
    $result = $app['db']->fetchAssoc($req, array((int) $id));
    if (null == $result) {
        return new Response('Menu doesn\'t exist', 400);
    }
    $jsonMenu = json_encode($result);

    return new Response($jsonMenu, 200);
});

return $app;
