<?php

namespace Appli\Tests\Functional;

use Silex\WebTestCase;
use Appli\PasswordEncoder;

class RubriqueTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../app/app.php';
        $app['debug'] = true;

        return $app;
    }

    /**
     * Test GET /rubriques sans rubriques.
     */
    public function testGetAllRubriquesWithoutRubriques()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No rubriques', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/count sans rubriques.
     */
    public function testCountRubriquesWithoutRubriques()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/count');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"COUNT(*)":"0"}', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/first sans rubriques.
     */
    public function testGetFirstRubriqueByPositionWithoutRubriques()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/first');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No rubriques', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/asc sans rubriques.
     */
    public function testGetRubriquesASCWithoutRubriques()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/rubriques/asc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","column":"titre_en"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No rubriques', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/desc sans rubriques.
     */
    public function testGetRubriquesDESCWithoutRubriques()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/rubriques/desc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","column":"titre_en"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No rubriques', $client->getResponse()->getContent());
    }

    /**
     * Test POST /rubrique sans contenu.
     */
    public function testPostRubriqueWithoutContent()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/rubrique');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test POST /rubrique sans l'attribut a (pour la connexion).
     */
    public function testPostRubriqueWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/rubrique', array(), array(), array(),
            '{"titre_fr":"Enseignement","titre_en":"Teaching","actif":1}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test POST /rubrique avec l'attribut a faux.
     */
    public function testPostRubriqueWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/rubrique', array(), array(), array(),
            '{"a":"toto","titre_fr":"Enseignement","titre_en":"Teaching","actif":1}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test POST /rubrique sans l'attribut titre_fr.
     */
    public function testPostRubriqueWithoutTitreFrAttribute()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/rubrique', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_en":"Teaching","actif":1}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes titre_fr, titre_en or actif not here', $client->getResponse()->getContent());
    }

    /**
    * Test POST /rubrique sans l'attribut titre_en.
    */
    public function testPostRubriqueWithoutTitreEnAttribute()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/rubrique', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_fr":"Enseignement","actif":1}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes titre_fr, titre_en or actif not here', $client->getResponse()->getContent());
    }

    /**
     * Test POST /rubrique sans l'attribut actif.
     */
    public function testPostRubriqueWithoutActifAttribute()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/rubrique', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_fr":"Enseignement","titre_en":"Teaching"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes titre_fr, titre_en or actif not here', $client->getResponse()->getContent());
    }

    /**
     * Test POST /rubrique sans l'attribut ID.
     */
    public function testPostRubriqueWithoutId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/rubrique', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_fr":"Enseignement","titre_en":"Teaching","actif":1,"position":4,"content_fr":"Contenu","content_en":"Content"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Rubrique created', $client->getResponse()->getContent());
    }

    /**
     * Test POST /rubrique avec l'attribut ID.
     */
    public function testPostRubriqueWithId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/rubrique', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","ID":1,"titre_fr":"Enseignement","titre_en":"Teaching","actif":1,"position":1,"content_fr":"Contenu","content_en":"Content"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Rubrique created', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques ok.
     */
    public function testGetAllRubriques()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"titre_fr":"Enseignement","titre_en":"Teaching"', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/titre_fr sans contenu.
     */
    public function testGetAllRubriquesByTitreFRWithoutContent()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/titre_fr');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/titre_fr sans attribut titre_fr.
     */
    public function testGetAllRubriquesByTitreFRWithoutTitreFR()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/titre_fr', array(), array(), array(),
            '{"titre_en":"Teaching"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attribute titre_fr not here', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/titre_fr avec un attribut titre_fr inexistant.
     */
    public function testGetAllRubriquesByTitreFRWithoutExistingTitreFR()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/titre_fr', array(), array(), array(),
            '{"titre_fr":"Teaching"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No rubriques', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/titre_fr ok.
     */
    public function testGetAllRubriquesByTitreFRWithExistingTitreFR()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/titre_fr', array(), array(), array(),
            '{"titre_fr":"Enseignement"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"titre_fr":"Enseignement","titre_en":"Teaching"', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/titre_en sans contenu.
     */
    public function testGetAllRubriquesByTitreENWithoutContent()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/titre_en');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/titre_en sans attribut titre_en.
     */
    public function testGetAllRubriquesByTitreENWithoutTitreEN()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/titre_en', array(), array(), array(),
            '{"titre_fr":"Enseignement"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attribute titre_en not here', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/titre_en avec un attribut titre_en inexistant.
     */
    public function testGetAllRubriquesByTitreENWithoutExistingTitreEN()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/titre_en', array(), array(), array(),
            '{"titre_en":"Enseignement"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No rubriques', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/titre_en ok.
     */
    public function testGetAllRubriquesByTitreENWithExistingTitreEN()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/titre_en', array(), array(), array(),
            '{"titre_en":"Teaching"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"titre_fr":"Enseignement","titre_en":"Teaching"', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/count ok.
     */
    public function testCountRubrique()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/count');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"COUNT(*)":"2"}', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/first ok.
     */
    public function testGetFirstRubriqueByPosition()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/first');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('"titre_fr":"Enseignement","titre_en":"Teaching","actif":"1","position":"1"', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/id avec un id inexistant.
     */
    public function testGetRubriqueByIdWithoutExistingId()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/1000');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Rubrique doesn\'t exist', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/id avec un id existant.
     */
    public function testGetRubriqueByIdWithExistingId()
    {
        $client = $this->createClient();
        $client->request('GET', '/rubriques/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('"titre_fr":"Enseignement","titre_en":"Teaching"', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/filter sans contenu.
     */
    public function testGetRubriquesFilterWithoutContent()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/rubriques/filter');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/filter sans l'attribut a (pour la connexion).
     */
    public function testGetRubriquesFilterWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/rubriques/filter', array(), array(), array(),
            '{"titre_fr":"test","titre_en":null,"actif":"1","position":"6","date_creation":null,"date_modification":null,"content_fr":"Blabla","content_en":null}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/filter avec l'attribut a faux.
     */
    public function testGetRubriquesFilterWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/rubriques/filter', array(), array(), array(),
            '{"a":"toto","titre_fr":"test","titre_en":null,"actif":"1","position":"6","date_creation":null,"date_modification":null,"content_fr":"Blabla","content_en":null}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/filter sans l'attribut titre_fr.
     */
    public function testGetRubriquesFilterWithoutTitreFr()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/rubriques/filter', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_en":null,"actif":"1","position":"6","date_creation":"2014-11-24","date_modification":null,"content_fr":"impossible","content_en":null}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Some attributes are missing', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/filter sans rubriques existantes pour ces filtres.
     */
    public function testGetRubriquesFilterFalse()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/rubriques/filter', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_fr":"impossible","titre_en":null,"actif":"1","position":"6","date_creation":"2014-11-24","date_modification":null,"content_fr":"impossible","content_en":null}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No rubriques', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/filter ok.
     */
    public function testGetRubriquesFilter()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/rubriques/filter', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_fr":null,"titre_en":"Teach","actif":null,"position":null,"date_creation":null,"date_modification":null,"content_fr":null,"content_en":null}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"titre_fr":"Enseignement","titre_en":"Teaching"', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/asc sans contenu.
     */
    public function testGetRubriquesASCWithoutContent()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/rubriques/asc');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/asc sans l'attribut a (pour la connexion).
     */
    public function testGetRubriquesASCWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/rubriques/asc', array(), array(), array(),
            '{"column":"titre_fr"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/asc avec l'attribut a faux.
     */
    public function testGetRubriquesASCWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/rubriques/asc', array(), array(), array(),
            '{"column":"titre_fr"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/asc sans l'attribut column.
     */
    public function testGetRubriquesASCWithoutColumnAttributes()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/rubriques/asc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","column2":"titre_en"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attribute column not here', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/asc ok.
     */
    public function testGetRubriquesASC()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/rubriques/asc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","column":"titre_en"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"titre_fr":"Enseignement","titre_en":"Teaching"', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/desc sans contenu.
     */
    public function testGetRubriquesDESCWithoutContent()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/rubriques/desc');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/desc sans l'attribut a (pour la connexion).
     */
    public function testGetRubriquesDESCWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/rubriques/desc', array(), array(), array(),
            '{"column":"titre_fr"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/desc avec l'attribut a faux.
     */
    public function testGetRubriquesDESCWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/rubriques/desc', array(), array(), array(),
            '{"column":"titre_fr"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/desc sans l'attribut column.
     */
    public function testGetRubriquesDESCWithoutColumnAttributes()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/rubriques/desc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","column2":"titre_en"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attribute column not here', $client->getResponse()->getContent());
    }

    /**
     * Test GET /rubriques/desc ok.
     */
    public function testGetRubriquesDESC()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/rubriques/desc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","column":"titre_en"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"titre_fr":"Enseignement","titre_en":"Teaching"', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /rubriques/id sans contenu.
     */
    public function testPutRubriqueByIdWithoutContent()
    {
        $client = $this->createClient();
        $client->request('PUT', '/admin/rubriques/1');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /rubriques/id sans l'attribut a (pour la connexion).
     */
    public function testPutRubriqueByIdWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('PUT', '/admin/rubriques/1', array(), array(), array(),
            '{}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /rubriques/id avec l'attribut a faux.
     */
    public function testPutRubriqueByIdWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('PUT', '/admin/rubriques/1', array(), array(), array(),
            '{"a":"toto"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /rubriques/id avec un ID inexistant.
     */
    public function testPutRubriqueByIdWithoutExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/rubriques/1000', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_fr":"OutilsMaJ","titre_en":"ToolsMaj","actif":1,"position":5}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Menu doesn\'t exist', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /rubriques/id sans l'attribut titre_fr.
     */
    public function testPutRubriqueByIdWithoutTitreFr()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/rubriques/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_en":"ToolsMaj","actif":1,"position":5}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes titre_fr or titre_en not here', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /rubriques/id sans l'attribut titre_en.
     */
    public function testPutRubriqueByIdWithoutTitreEn()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/rubriques/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_fr":"OutilsMaJ","actif":1,"position":5}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes titre_fr or titre_en not here', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /rubriques/id ok.
     */
    public function testPutRubriqueById()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/rubriques/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_fr":"OutilsMaJ2","titre_en":"ToolsMaJ2"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Rubrique updated', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /rubriques/id avec attributs content_fr et content_en ok.
     */
    public function testPutRubriqueByIdWithContentFrEn()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/rubriques/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","titre_fr":"MaJContentFr","titre_en":"MaJContentEn", "content_fr":"update content_fr", "content_en":"update content_en"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Rubrique updated', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /rubriques/id sans contenu.
     */
    public function testDeleteRubriqueByIdWithoutContent()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/rubriques/1');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /rubriques/id sans l'attribut a (pour la connexion).
     */
    public function testDeleteRubriqueByIdWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/rubriques/1', array(), array(), array(),
            '{}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /rubriques/id avec l'attribut a faux.
     */
    public function testDeleteRubriqueByIdWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/rubriques/1', array(), array(), array(),
            '{"a":"toto"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /rubriques/id avec un ID inexistant.
     */
    public function testDeleteRubriqueByIdWithoutExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('DELETE', '/admin/rubriques/1000', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Menu doesn\'t exist', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /rubriques/id avec un ID existant.
     */
    public function testDeleteRubriqueByIdWithExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('DELETE', '/admin/rubriques/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Rubrique deleted', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /rubriques sans contenu.
     */
    public function testDeleteAllRubriquesWithoutContent()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/rubriques');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /rubriques sans l'attribut a (pour la connexion).
     */
    public function testDeleteAllRubriquesWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/rubriques', array(), array(), array(),
            '{}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /rubriques avec l'attribut a faux.
     */
    public function testDeleteAllRubriquesWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/rubriques', array(), array(), array(),
            '{"a":"toto"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /rubriques ok.
     */
    public function testDeleteAllCategories()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('DELETE', '/admin/rubriques', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Rubriques deleted', $client->getResponse()->getContent());
    }
}
