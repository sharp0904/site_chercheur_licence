
<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Appli\PasswordEncoder;

$app->post('/admin/rubrique', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $rubriqueArray = json_decode($request->getContent());
    if (!isset($rubriqueArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $rubriqueArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    if (!isset($rubriqueArray->{'titre_fr'}) || !isset($rubriqueArray->{'titre_en'}) || !isset($rubriqueArray->{'actif'})) {
        return new Response('Attributes titre_fr, titre_en or actif not here', 404);
    }
    if (!isset($rubriqueArray->{'ID'})) {
        $sqlRequest = 'INSERT INTO menu VALUES (null, ?, ?, ?, ?)';
        $app['db']->executeUpdate($sqlRequest, array(
            $rubriqueArray->{'titre_fr'},
            $rubriqueArray->{'titre_en'},
            $rubriqueArray->{'actif'},
            isset($rubriqueArray->{'position'}) ? $rubriqueArray->{'position'} : null,
        ));
        $sqlRequest = "INSERT INTO rubrique VALUES (null, NOW(), NOW(), ?, ?, (SELECT max(ID) FROM menu))";
        $app['db']->executeUpdate($sqlRequest, array(
            isset($rubriqueArray->{'content_fr'}) ? $rubriqueArray->{'content_fr'} : null,
            isset($rubriqueArray->{'content_en'}) ? $rubriqueArray->{'content_en'} : null,
        ));

        return new Response('Rubrique created', 200);
    }
    $sqlRequest = 'INSERT INTO menu VALUES (?, ?, ?, ?, ?)';
    $app['db']->executeUpdate($sqlRequest, array(
        $rubriqueArray->{'ID'},
        $rubriqueArray->{'titre_fr'},
        $rubriqueArray->{'titre_en'},
        $rubriqueArray->{'actif'},
        isset($rubriqueArray->{'position'}) ? $rubriqueArray->{'position'} : null,
    ));
    $sqlRequest = "INSERT INTO rubrique VALUES (null, NOW(), NOW(), ?, ?, ?)";
    $app['db']->executeUpdate($sqlRequest, array(
        isset($rubriqueArray->{'content_fr'}) ? $rubriqueArray->{'content_fr'} : null,
        isset($rubriqueArray->{'content_en'}) ? $rubriqueArray->{'content_en'} : null,
        $rubriqueArray->{'ID'},
    ));

    return new Response('Rubrique created', 200);
});

$app->get('/rubriques', function () use ($app) {
    $query = $app['db']->executeQuery('SELECT * FROM menu, rubrique WHERE rubrique.menu_id = menu.ID');
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No rubriques', 400);
    }
    $rubriques = array();
    foreach ($results as $menu) {
        array_push($rubriques, $menu);
    }
    $jsonRubriques = json_encode($rubriques);

    return new Response($jsonRubriques, 200);
});

$app->get('/rubriques/titre_fr', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $rubriqueArray = json_decode($request->getContent());
    if (!isset($rubriqueArray->{'titre_fr'})) {
        return new Response('Attribute titre_fr not here', 404);
    }
    $query = $app['db']->executeQuery(
        'SELECT * FROM menu, rubrique WHERE rubrique.menu_id = menu.ID AND menu.titre_fr = ?', array($rubriqueArray->{'titre_fr'}));
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No rubriques', 400);
    }
    $rubriques = array();
    foreach ($results as $menu) {
        array_push($rubriques, $menu);
    }
    $jsonRubriques = json_encode($rubriques);

    return new Response($jsonRubriques, 200);
});

$app->get('/rubriques/titre_en', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $rubriqueArray = json_decode($request->getContent());
    if (!isset($rubriqueArray->{'titre_en'})) {
        return new Response('Attribute titre_en not here', 404);
    }
    $query = $app['db']->executeQuery('SELECT * FROM menu, rubrique WHERE rubrique.menu_id = menu.ID AND menu.titre_en = ?', array($rubriqueArray->{'titre_en'}));
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No rubriques', 400);
    }
    $rubriques = array();
    foreach ($results as $menu) {
        array_push($rubriques, $menu);
    }
    $jsonRubriques = json_encode($rubriques);

    return new Response($jsonRubriques, 200);
});

$app->get('/rubriques/count', function () use ($app) {
    $req = 'SELECT COUNT(*) FROM rubrique';
    $result = $app['db']->fetchAssoc($req);
    $countValue = json_encode($result);

    return new Response($countValue, 200);
});

$app->get('/rubriques/first', function () use ($app) {
    $request = 'SELECT * FROM menu, rubrique WHERE rubrique.menu_id = menu.ID ORDER BY menu.position';
    $query = $app['db']->executeQuery($request);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No rubriques', 400);
    }
    $rubrique = array();
    foreach ($results as $row) {
        array_push($rubrique, $row);
        $jsonRubrique = json_encode($rubrique);

        return new Response($jsonRubrique, 200);
    }
});

$app->get('/admin/rubriques/filter', function (Request $request) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $rubriqueArray = json_decode($request->getContent());
    if (!isset($rubriqueArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $rubriqueArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    if (!array_key_exists('titre_fr', $rubriqueArray) || !array_key_exists('titre_en', $rubriqueArray)
        || !array_key_exists('actif', $rubriqueArray) || !array_key_exists('position', $rubriqueArray)
        || !array_key_exists('date_creation', $rubriqueArray) || !array_key_exists('date_modification', $rubriqueArray)
        || !array_key_exists('content_fr', $rubriqueArray) || !array_key_exists('content_en', $rubriqueArray) ) {
        return new Response('Some attributes are missing', 404);
    }
    $sqlRequest = 'SELECT * FROM menu, rubrique WHERE rubrique.menu_id = menu.ID';
    $values = array();
    if (null != $rubriqueArray->{'titre_fr'}) {
        $sqlRequest .= " AND (titre_fr LIKE ?)";
        array_push($values, '%'. $rubriqueArray->{'titre_fr'} .'%');
    }
    if (null != $rubriqueArray->{'titre_en'}) {
        $sqlRequest .= ' AND (titre_en LIKE ?)';
        array_push($values, '%'. $rubriqueArray->{'titre_en'} .'%');
    }
    if (null != $rubriqueArray->{'actif'}) {
        $sqlRequest .= ' AND (actif LIKE ?)';
        array_push($values, '%'. $rubriqueArray->{'actif'} .'%');
    }
    if (null != $rubriqueArray->{'position'}) {
        $sqlRequest .= ' AND (position LIKE ?)';
        array_push($values, '%'. $rubriqueArray->{'position'} .'%');
    }
    if (null != $rubriqueArray->{'date_creation'}) {
        $sqlRequest .= ' AND (date_creation LIKE ?)';
        array_push($values, '%'. $rubriqueArray->{'date_creation'} .'%');
    }
    if (null != $rubriqueArray->{'date_modification'}) {
        $sqlRequest .= ' AND (date_modification LIKE ?)';
        array_push($values, '%'. $rubriqueArray->{'date_modification'} .'%');
    }
    if (null != $rubriqueArray->{'content_fr'}) {
        $sqlRequest .= ' AND (content_fr LIKE ?)';
        array_push($values, '%'. $rubriqueArray->{'content_fr'} .'%');
    }
    if (null != $rubriqueArray->{'content_en'}) {
        $sqlRequest .= ' AND (content_en LIKE ?)';
        array_push($values, '%'. $rubriqueArray->{'content_en'} .'%');
    }
    $query = $app['db']->executeQuery($sqlRequest, $values);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No rubriques', 400);
    }
    $rubriques = array();
    foreach ($results as $menu) {
        array_push($rubriques, $menu);
    }
    $jsonRubriques = json_encode($rubriques);

    return new Response($jsonRubriques, 200);
});

$app->get('/admin/rubriques/asc', function (Request $request) use ($app) {
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
    $sqlRequest = 'SELECT * FROM menu, rubrique WHERE rubrique.menu_id = menu.ID ORDER BY ' . $attributeArray->{'column'};
    $query = $app['db']->executeQuery($sqlRequest);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No rubriques', 400);
    }
    $rubriques = array();
    foreach ($results as $row) {
        array_push($rubriques, $row);
    }
    $jsonRubriques = json_encode($rubriques);

    return new Response($jsonRubriques, 200);
});

$app->get('/admin/rubriques/desc', function (Request $request) use ($app) {
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
    $sqlRequest = 'SELECT * FROM menu, rubrique WHERE rubrique.menu_id = menu.ID ORDER BY ' . $attributeArray->{'column'} . ' DESC';
    $query = $app['db']->executeQuery($sqlRequest);
    $results = $query->fetchAll();
    if (null == $results) {
        return new Response('No rubriques', 400);
    }
    $rubriques = array();
    foreach ($results as $row) {
        array_push($rubriques, $row);
    }
    $jsonRubriques = json_encode($rubriques);

    return new Response($jsonRubriques, 200);
});

$app->get('/rubriques/{id}', function ($id) use ($app) {
    $req = 'SELECT * FROM menu, rubrique WHERE rubrique.menu_id = menu.ID AND menu.ID = ?';
    $result = $app['db']->fetchAssoc($req, array((int) $id));
    if (null == $result) {
        return new Response('Rubrique doesn\'t exist', 400);
    }
    $jsonRubrique = json_encode($result);

    return new Response($jsonRubrique, 200);
});


$app->get('/rubriquesId/{id}', function ($id) use ($app) {
    $req = 'SELECT * FROM menu, rubrique WHERE rubrique.menu_id = menu.ID AND rubrique.id = ?';
    $result = $app['db']->fetchAssoc($req, array((int) $id));
    if (null == $result) {
        return new Response('Rubrique doesn\'t exist', 400);
    }
    $jsonRubrique = json_encode($result);

    return new Response($jsonRubrique, 200);
});

$app->put('/admin/rubriques/{id}', function (Request $request, $id) use ($app) {
    if (null == $request->getContent()) {
        return new Response('No content', 404);
    }
    $rubriqueArray = json_decode($request->getContent());
    if (!isset($rubriqueArray->{'a'})) {
        return new Response('Admin not connected', 403);
    }
    $encoder = new PasswordEncoder();
    if ($encoder->encodePassword('Admin connected') !== $rubriqueArray->{'a'}) {
        return new Response('Admin not connected', 403);
    }
    $sqlRequest = 'SELECT * FROM menu WHERE ID = ?';
    $result = $app['db']->fetchAssoc($sqlRequest, array((int) $id));
    if (null == $result) {
        return new Response('Menu doesn\'t exist', 400);
    }
    if (!isset($rubriqueArray->{'titre_fr'}) || !isset($rubriqueArray->{'titre_en'})) {
        return new Response('Attributes titre_fr or titre_en not here', 404);
    }
    $sqlRequest = 'UPDATE menu SET titre_fr = ?, titre_en = ?';
    $values = array($rubriqueArray->{'titre_fr'}, $rubriqueArray->{'titre_en'});
    if (isset($rubriqueArray->{'actif'})) {
        $sqlRequest .= ', actif = ?';
        array_push($values, $rubriqueArray->{'actif'});
    }
    if (isset($rubriqueArray->{'position'})) {
        $sqlRequest .= ', position = ?';
        array_push($values, $rubriqueArray->{'position'});
    }
    $sqlRequest .= ' WHERE ID = ?';
    array_push($values, $id);
    $app['db']->executeUpdate($sqlRequest, $values);
    $sqlRequest = 'UPDATE rubrique SET date_modification = NOW()';
    $values2 = array();
    if (isset($rubriqueArray->{'content_fr'})) {
        $sqlRequest .= ', content_fr = ?';
        array_push($values2, $rubriqueArray->{'content_fr'});
    }
    if (isset($rubriqueArray->{'content_en'})) {
        $sqlRequest .= ', content_en = ?';
        array_push($values2, $rubriqueArray->{'content_en'});
    }
    $sqlRequest .= ' WHERE menu_id = ?';
    array_push($values2, $id);
    $app['db']->executeUpdate($sqlRequest, $values2);

    return new Response('Rubrique updated', 200);
});

$app->delete('/admin/rubriques/{id}', function (Request $request, $id) use ($app) {
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
    $sqlRequest = 'SELECT * FROM menu WHERE ID = ?';
    $result = $app['db']->fetchAssoc($sqlRequest, array((int) $id));
    if (null == $result) {
        return new Response('Menu doesn\'t exist', 400);
    }
    $sqlRequest = 'DELETE FROM rubrique WHERE menu_id = ?';
    $app['db']->executeUpdate($sqlRequest, array((int) $id));
    $sqlRequest = 'DELETE FROM menu WHERE ID = ?';
    $app['db']->executeUpdate($sqlRequest, array((int) $id));

    return new Response('Rubrique deleted', 200);
});

$app->delete('/admin/rubriques', function (Request $request) use ($app) {
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
    $sqlRequest = 'DELETE FROM rubrique WHERE 1';
    $app['db']->executeUpdate($sqlRequest);
    $sqlRequest = 'DELETE FROM menu WHERE 1';
    $app['db']->executeUpdate($sqlRequest);

    return new Response('Rubriques deleted', 200);
});

return $app;
