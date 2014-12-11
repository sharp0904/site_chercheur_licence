<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Appli\PasswordEncoder;

$app->post('/admin/publication', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $publicationArray = json_decode($request->getContent());
    if (!isset($publicationArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $publicationArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    if (!isset($publicationArray->{'reference'}) || !isset($publicationArray->{'auteurs'})
        || !isset($publicationArray->{'titre'}) || !isset($publicationArray->{'date'})) {
        return new Response('Attributes reference, auteurs, titre or date not here', 404);
    }
    if (!isset($publicationArray->{'ID'})) {
        $sqlRequest = 'INSERT INTO publication VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $app['db']->executeUpdate($sqlRequest, array(
            $publicationArray->{'reference'},
            $publicationArray->{'auteurs'},
            $publicationArray->{'titre'},
            $publicationArray->{'date'},
            isset($publicationArray->{'journal'}) ? $publicationArray->{'journal'} : null,
            isset($publicationArray->{'volume'}) ? $publicationArray->{'volume'} : null,
            isset($publicationArray->{'number'}) ? $publicationArray->{'number'} : null,
            isset($publicationArray->{'pages'}) ? $publicationArray->{'pages'} : null,
            isset($publicationArray->{'note'}) ? $publicationArray->{'note'} : null,
            isset($publicationArray->{'abstract'}) ? $publicationArray->{'abstract'} : null,
            isset($publicationArray->{'keywords'}) ? $publicationArray->{'keywords'} : null,
            isset($publicationArray->{'series'}) ? $publicationArray->{'series'} : null,
            isset($publicationArray->{'localite'}) ? $publicationArray->{'localite'} : null,
            isset($publicationArray->{'publisher'}) ? $publicationArray->{'publisher'} : null,
            isset($publicationArray->{'editor'}) ? $publicationArray->{'editor'} : null,
            isset($publicationArray->{'pdf'}) ? $publicationArray->{'pdf'} : null,
            isset($publicationArray->{'date_display'}) ? $publicationArray->{'date_display'} : null,
            isset($publicationArray->{'categorie_id'}) ? $publicationArray->{'categorie_id'} : null,
        ));

        return new Response('Publication created', 200);
    }
    $sqlRequest = 'INSERT INTO publication VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $app['db']->executeUpdate($sqlRequest, array(
        $publicationArray->{'ID'},
        $publicationArray->{'reference'},
        $publicationArray->{'auteurs'},
        $publicationArray->{'titre'},
        $publicationArray->{'date'},
        isset($publicationArray->{'journal'}) ? $publicationArray->{'journal'} : null,
        isset($publicationArray->{'volume'}) ? $publicationArray->{'volume'} : null,
        isset($publicationArray->{'number'}) ? $publicationArray->{'number'} : null,
        isset($publicationArray->{'pages'}) ? $publicationArray->{'pages'} : null,
        isset($publicationArray->{'note'}) ? $publicationArray->{'note'} : null,
        isset($publicationArray->{'abstract'}) ? $publicationArray->{'abstract'} : null,
        isset($publicationArray->{'keywords'}) ? $publicationArray->{'keywords'} : null,
        isset($publicationArray->{'series'}) ? $publicationArray->{'series'} : null,
        isset($publicationArray->{'localite'}) ? $publicationArray->{'localite'} : null,
        isset($publicationArray->{'publisher'}) ? $publicationArray->{'publisher'} : null,
        isset($publicationArray->{'editor'}) ? $publicationArray->{'editor'} : null,
        isset($publicationArray->{'pdf'}) ? $publicationArray->{'pdf'} : null,
        isset($publicationArray->{'date_display'}) ? $publicationArray->{'date_display'} : null,
        isset($publicationArray->{'categorie_id'}) ? $publicationArray->{'categorie_id'} : null,
    ));

    return new Response('Publication created', 200);
});

$app->get('/publications', function () use ($app) {
    $sqlRequest = 'SELECT * FROM publication';
    $query = $app['db']->executeQuery($sqlRequest);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No publications', 400);
    }
    $publications = array();
    foreach ($results as $row) {
		
        array_push($publications, $row);
    }
	
    $jsonPublications = json_encode($publications);

    return new Response($jsonPublications, 200);
});

// Tri de la plus recente a la plus ancienne
$app->get('/publications/date', function () use ($app) {
    $sqlRequest = 'SELECT * FROM publication ORDER BY date DESC';
    $query = $app['db']->executeQuery($sqlRequest);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No publications', 400);
    }
    $publications = array();
    foreach ($results as $row) {
        array_push($publications, $row);
    }
    $jsonPublications = json_encode($publications);

    return new Response($jsonPublications, 200);
});

$app->get('/publications/categorie', function () use ($app) {
    $sqlRequest = 'SELECT * FROM publication ORDER BY categorie_id';
    $query = $app['db']->executeQuery($sqlRequest);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No publications', 400);
    }
    $publications = array();
    foreach ($results as $row) {
        array_push($publications, $row);
    }
    $jsonPublications = json_encode($publications);

    return new Response($jsonPublications, 200);
});

$app->get('/publications/count', function () use ($app) {
    $req = 'SELECT COUNT(*) FROM publication';
    $result = $app['db']->fetchAssoc($req);
    $countValue = json_encode($result);

    return new Response($countValue, 200);
});

$app->get('/admin/publications/filter', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $publicationArray = json_decode($request->getContent());
    if (!isset($publicationArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $publicationArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    if (!array_key_exists('reference', $publicationArray) || !array_key_exists('auteurs', $publicationArray)
        || !array_key_exists('titre', $publicationArray) || !array_key_exists('journal', $publicationArray)
        || !array_key_exists('volume', $publicationArray) || !array_key_exists('number', $publicationArray)
        || !array_key_exists('pages', $publicationArray) || !array_key_exists('note', $publicationArray)
        || !array_key_exists('abstract', $publicationArray) || !array_key_exists('keywords', $publicationArray)
        || !array_key_exists('series', $publicationArray) || !array_key_exists('localite', $publicationArray)
        || !array_key_exists('publisher', $publicationArray) || !array_key_exists('editor', $publicationArray)
        || !array_key_exists('pdf', $publicationArray) || !array_key_exists('date_display', $publicationArray) ) {
        return new Response('Some attributes are missing', 404);
    }
    $sqlRequest = 'SELECT * FROM publication WHERE 1';
    $values = array();
    if (null != $publicationArray->{'reference'}) {
        $sqlRequest .= " AND (reference LIKE ?)";
        array_push($values, '%'. $publicationArray->{'reference'} .'%');
    }
    if (null != $publicationArray->{'auteurs'}) {
        $sqlRequest .= ' AND (auteurs LIKE ?)';
        array_push($values, '%'. $publicationArray->{'auteurs'} .'%');
    }
    if (null != $publicationArray->{'titre'}) {
        $sqlRequest .= ' AND (titre LIKE ?)';
        array_push($values, '%'. $publicationArray->{'titre'} .'%');
    }
    if (null != $publicationArray->{'journal'}) {
        $sqlRequest .= ' AND (journal LIKE ?)';
        array_push($values, '%'. $publicationArray->{'journal'} .'%');
    }
    if (null != $publicationArray->{'volume'}) {
        $sqlRequest .= ' AND (volume LIKE ?)';
        array_push($values, '%'. $publicationArray->{'volume'} .'%');
    }
    if (null != $publicationArray->{'number'}) {
        $sqlRequest .= ' AND (number LIKE ?)';
        array_push($values, '%'. $publicationArray->{'number'} .'%');
    }
    if (null != $publicationArray->{'pages'}) {
        $sqlRequest .= ' AND (pages LIKE ?)';
        array_push($values, '%'. $publicationArray->{'pages'} .'%');
    }
    if (null != $publicationArray->{'note'}) {
        $sqlRequest .= ' AND (note LIKE ?)';
        array_push($values, '%'. $publicationArray->{'note'} .'%');
    }
    if (null != $publicationArray->{'abstract'}) {
        $sqlRequest .= ' AND (abstract LIKE ?)';
        array_push($values, '%'. $publicationArray->{'abstract'} .'%');
    }
    if (null != $publicationArray->{'keywords'}) {
        $sqlRequest .= ' AND (keywords LIKE ?)';
        array_push($values, '%'. $publicationArray->{'keywords'} .'%');
    }
    if (null != $publicationArray->{'series'}) {
        $sqlRequest .= ' AND (series LIKE ?)';
        array_push($values, '%'. $publicationArray->{'series'} .'%');
    }
    if (null != $publicationArray->{'localite'}) {
        $sqlRequest .= ' AND (localite LIKE ?)';
        array_push($values, '%'. $publicationArray->{'localite'} .'%');
    }
    if (null != $publicationArray->{'publisher'}) {
        $sqlRequest .= ' AND (publisher LIKE ?)';
        array_push($values, '%'. $publicationArray->{'publisher'} .'%');
    }
    if (null != $publicationArray->{'editor'}) {
        $sqlRequest .= ' AND (editor LIKE ?)';
        array_push($values, '%'. $publicationArray->{'editor'} .'%');
    }
    if (null != $publicationArray->{'pdf'}) {
        $sqlRequest .= ' AND (pdf LIKE ?)';
        array_push($values, '%'. $publicationArray->{'pdf'} .'%');
    }
    if (null != $publicationArray->{'date_display'}) {
        $sqlRequest .= ' AND (date_display LIKE ?)';
        array_push($values, '%'. $publicationArray->{'date_display'} .'%');
    }
    $query = $app['db']->executeQuery($sqlRequest, $values);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No publications', 400);
    }
    $publications = array();
    foreach ($results as $publication) {
        array_push($publications, $publication);
    }
    $jsonPublications = json_encode($publications);

    return new Response($jsonPublications, 200);
});

$app->get('/admin/publications/asc', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $attributeArray = json_decode($request->getContent());
    if (!isset($attributeArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $attributeArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    if (!isset($attributeArray->{'column'})) {
        return new Response('Attribute column not here', 404);
    }
    $sqlRequest = 'SELECT * FROM publication ORDER BY ' . $attributeArray->{'column'};
    $query = $app['db']->executeQuery($sqlRequest);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No publications', 400);
    }
    $publications = array();
    foreach ($results as $row) {
        array_push($publications, $row);
    }
    $jsonPublications = json_encode($publications);

    return new Response($jsonPublications, 200);
});

$app->get('/admin/publications/desc', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $attributeArray = json_decode($request->getContent());
    if (!isset($attributeArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $attributeArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    if (!isset($attributeArray->{'column'})) {
        return new Response('Attribute column not here', 404);
    }
    $sqlRequest = 'SELECT * FROM publication ORDER BY ' . $attributeArray->{'column'} . ' DESC';
    $query = $app['db']->executeQuery($sqlRequest);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No publications', 400);
    }
    $publications = array();
    foreach ($results as $row) {
        array_push($publications, $row);
    }
    $jsonPublications = json_encode($publications);

    return new Response($jsonPublications, 200);
});

$app->get('/admin/publications/{id}', function (Request $request, $id) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $attributeArray = json_decode($request->getContent());
    if (!isset($attributeArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $attributeArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    $sqlRequest = 'SELECT * FROM publication WHERE ID = ?';
    $result = $app['db']->fetchAssoc($sqlRequest, array((int) $id));
    if (null == $result) {
        return new Response('Publication doesn\'t exist', 400);
    }
    $jsonPublications = json_encode($result);

    return new Response($jsonPublications, 200);
});

$app->put('/admin/publications/{id}', function (Request $request, $id) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $publicationArray = json_decode($request->getContent());
    if (!isset($publicationArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $publicationArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    $sqlRequest = 'SELECT * FROM publication WHERE ID = ?';
    $result = $app['db']->fetchAssoc($sqlRequest, array((int) $id));
    if (null == $result) {
        return new Response('Publication doesn\'t exist', 400);
    }
    $categorieArray = json_decode($request->getContent());
    if (!isset($categorieArray->{'reference'})) {
        return new Response('Attribute reference not here', 404);
    }
    $sqlRequest = 'UPDATE publication SET reference = ?';
    $values = array($categorieArray->{'reference'});
    if (isset($categorieArray->{'auteurs'})) {
        $sqlRequest .= ', auteurs = ?';
        array_push($values, $categorieArray->{'auteurs'});
    }
    if (isset($categorieArray->{'titre'})) {
        $sqlRequest .= ', titre = ?';
        array_push($values, $categorieArray->{'titre'});
    }
    if (isset($categorieArray->{'date'})) {
        $sqlRequest .= ', date = ?';
        array_push($values, $categorieArray->{'date'});
    }
    if (isset($categorieArray->{'journal'})) {
        $sqlRequest .= ', journal = ?';
        array_push($values, $categorieArray->{'journal'});
    }
    if (isset($categorieArray->{'volume'})) {
        $sqlRequest .= ', volume = ?';
        array_push($values, $categorieArray->{'volume'});
    }
    if (isset($categorieArray->{'number'})) {
        $sqlRequest .= ', number = ?';
        array_push($values, $categorieArray->{'number'});
    }
    if (isset($categorieArray->{'pages'})) {
        $sqlRequest .= ', pages = ?';
        array_push($values, $categorieArray->{'pages'});
    }
    if (isset($categorieArray->{'note'})) {
        $sqlRequest .= ', note = ?';
        array_push($values, $categorieArray->{'note'});
    }
    if (isset($categorieArray->{'abstract'})) {
        $sqlRequest .= ', abstract = ?';
        array_push($values, $categorieArray->{'abstract'});
    }
    if (isset($categorieArray->{'keywords'})) {
        $sqlRequest .= ', keywords = ?';
        array_push($values, $categorieArray->{'keywords'});
    }
    if (isset($categorieArray->{'series'})) {
        $sqlRequest .= ', series = ?';
        array_push($values, $categorieArray->{'series'});
    }
    if (isset($categorieArray->{'localite'})) {
        $sqlRequest .= ', localite = ?';
        array_push($values, $categorieArray->{'localite'});
    }
    if (isset($categorieArray->{'publisher'})) {
        $sqlRequest .= ', publisher = ?';
        array_push($values, $categorieArray->{'publisher'});
    }
    if (isset($categorieArray->{'editor'})) {
        $sqlRequest .= ', editor = ?';
        array_push($values, $categorieArray->{'editor'});
    }
    if (isset($categorieArray->{'pdf'})) {
        $sqlRequest .= ', pdf = ?';
        array_push($values, $categorieArray->{'pdf'});
    }
    if (isset($categorieArray->{'date_display'})) {
        $sqlRequest .= ', date_display = ?';
        array_push($values, $categorieArray->{'date_display'});
    }
    if (isset($categorieArray->{'categorie_id'})) {
        $sqlRequest .= ', categorie_id = ?';
        array_push($values, $categorieArray->{'categorie_id'});
    }
    $sqlRequest .= ' WHERE ID = ?';
    array_push($values, $id);
    $app['db']->executeUpdate($sqlRequest, $values);

    return new Response('Publication updated', 200);
});

$app->delete('/admin/publications/{id}', function (Request $request, $id) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $publicationArray = json_decode($request->getContent());
    if (!isset($publicationArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $publicationArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    $sqlRequest = 'SELECT * FROM publication WHERE ID = ?';
    $result = $app['db']->fetchAssoc($sqlRequest, array((int) $id));
    if (null == $result) {
        return new Response('Publication doesn\'t exist', 400);
    }
    $sqlRequest = 'DELETE FROM publication WHERE ID = ?';
    $app['db']->executeUpdate($sqlRequest, array((int) $id));

    return new Response('Publication deleted', 200);
});

$app->delete('/admin/publications', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $publicationArray = json_decode($request->getContent());
    if (!isset($publicationArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $publicationArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    $sqlRequest = 'DELETE FROM publication WHERE 1';
    $app['db']->executeUpdate($sqlRequest);

    return new Response('Publications deleted', 200);
});

return $app;
