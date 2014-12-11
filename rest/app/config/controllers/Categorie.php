<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Appli\PasswordEncoder;

$app->post('/admin/categorie', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $categorieArray = json_decode($request->getContent());
    if (!isset($categorieArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $categorieArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    if (!isset($categorieArray->{'name_fr'}) || !isset($categorieArray->{'name_en'})) {
        return new Response('Attributes name_fr or name_en not here', 404);
    }
    if (!isset($categorieArray->{'ID'})) {
        $sqlRequest = 'INSERT INTO categorie VALUES (null, ?, ?)';
        $app['db']->executeUpdate($sqlRequest, array($categorieArray->{'name_fr'}, $categorieArray->{'name_en'}));

        return new Response('Categorie created', 200);
    }
    $sqlRequest = 'INSERT INTO categorie VALUES (?, ?, ?)';
    $app['db']->executeUpdate($sqlRequest, array($categorieArray->{'ID'}, $categorieArray->{'name_fr'}, $categorieArray->{'name_en'}));

    return new Response('Categorie created', 200);
});

$app->get('/categories', function () use ($app) {
    $sqlRequest = 'SELECT * FROM categorie';
    $query = $app['db']->executeQuery($sqlRequest);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No categories', 400);
    }
    $categories = array();
    foreach ($results as $row) {
        array_push($categories, $row);
    }
    $jsonCategories = json_encode($categories);

   return new Response($jsonCategories, 200);
});

$app->get('/categories/{id}', function ($id) use ($app) {
    $sqlRequest = 'SELECT * FROM categorie WHERE ID = ?';
    $result = $app['db']->fetchAssoc($sqlRequest, array((int) $id));
    if (null == $result) {
        return new Response('Categorie doesn\'t exist', 400);
    }
    $jsonCategorie = json_encode($result);

    return new Response($jsonCategorie, 200);
});

$app->put('/admin/categories/{id}', function (Request $request, $id) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $categorieArray = json_decode($request->getContent());
    if (!isset($categorieArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $categorieArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    $sqlRequest = 'SELECT * FROM categorie WHERE ID = ?';
    $result = $app['db']->fetchAssoc($sqlRequest, array((int) $id));
    if (null == $result) {
        return new Response('Categorie doesn\'t exist', 400);
    }
    if (!isset($categorieArray->{'name_fr'}) || !isset($categorieArray->{'name_en'})) {
        return new Response('Attributes name_fr or name_en not here', 404);
    }
    $sqlRequest = 'UPDATE categorie SET name_fr = ?, name_en = ? WHERE ID = ?';
    $app['db']->executeUpdate($sqlRequest, array($categorieArray->{'name_fr'}, $categorieArray->{'name_en'},  $id));

    return new Response('Categorie updated', 200);
});

$app->delete('/admin/categories/{id}', function (Request $request, $id) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $array = json_decode($request->getContent());
    if (!isset($array->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $array->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    $sqlRequest = 'SELECT * FROM categorie WHERE ID = ?';
    $result = $app['db']->fetchAssoc($sqlRequest, array((int) $id));
    if (null == $result) {
        return new Response('Categorie doesn\'t exist', 400);
    }
    $sqlRequest = 'DELETE FROM categorie WHERE ID = ?';
    $app['db']->executeUpdate($sqlRequest, array((int) $id));

    return new Response('Categorie deleted', 200);
});

$app->delete('/admin/categories', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $array = json_decode($request->getContent());
    if (!isset($array->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $array->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    $sqlRequest = 'DELETE FROM categorie WHERE 1';
    $app['db']->executeUpdate($sqlRequest);

    return new Response('Categories deleted', 200);
});

return $app;
