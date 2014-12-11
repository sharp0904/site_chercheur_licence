<?php

namespace Appli\Tests\Functional;

use Silex\WebTestCase;
use Appli\PasswordEncoder;

class PublicationTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../app/app.php';
        $app['debug'] = true;

        return $app;
    }

    /**
     * Test GET /publications sans publications.
     */
    public function testGetAllPublicationsWithoutPublications()
    {
        $client = $this->createClient();
        $client->request('GET', '/publications');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No publications', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/date sans publications.
     */
    public function testGetAllPublicationsByDateWithoutPublications()
    {
        $client = $this->createClient();
        $client->request('GET', '/publications/date');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No publications', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/categorie sans publications.
     */
    public function testGetAllPublicationsByCategorieWithoutPublications()
    {
        $client = $this->createClient();
        $client->request('GET', '/publications/categorie');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No publications', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/count sans publications.
     */
    public function testCountPublicationsWithoutPublications()
    {
        $client = $this->createClient();
        $client->request('GET', '/publications/count');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"COUNT(*)":"0"}', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/asc sans publications.
     */
    public function testGetPublicationsASCWithoutPublications()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/asc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","column":"auteurs"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No publications', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/desc sans publications.
     */
    public function testGetPublicationsDESCWithoutPublications()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/desc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","column":"auteurs"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No publications', $client->getResponse()->getContent());
    }

    /**
     * Test POST /publication sans contenu.
     */
    public function testPostPublicationWithoutContent()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/publication');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test POST /publication sans l'attribut a (pour la connexion).
     */
    public function testPostPublicationWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test POST /publication avec l'attribut a faux.
     */
    public function testPostPublicationWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"a":"toto","reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test POST /publication sans l'attribut reference.
     */
    public function testPostPublicationWithoutReferenceAttribute()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes reference, auteurs, titre or date not here', $client->getResponse()->getContent());
    }

    /**
     * Test POST /publication sans l'attribut auteurs.
     */
    public function testPostPublicationWithoutAuteursAttribute()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":"SR08a","titre":"Testabilite des services web", "date": "2008-05-01"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes reference, auteurs, titre or date not here', $client->getResponse()->getContent());
    }

    /**
     * Test POST /publication sans l'attribut titre.
     */
    public function testPostPublicationWithoutTitreAttribute()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "date": "2008-05-01"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes reference, auteurs, titre or date not here', $client->getResponse()->getContent());
    }

    /**
     * Test POST /publication sans l'attribut date.
     */
    public function testPostPublicationWithoutDateAttribute()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes reference, auteurs, titre or date not here', $client->getResponse()->getContent());
    }

    /**
     * Test POST /publication sans l'attribut ID.
     */
    public function testPostPublicationWithoutId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Publication created', $client->getResponse()->getContent());
    }

    /**
     * Test POST /publication avec l'attribut ID.
     */
    public function testPostPublicationWithId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","ID":1,"reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Publication created', $client->getResponse()->getContent());
    }

    /**
     * Test POST /publication avec l'attribut categorie_id correspondant a une categorie inexistante.
     */
    public function testPostPublicationWithNonExistingCategorieId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01", "categorie_id":1000}');

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * Test POST /publication avec l'attribut categorie_id correspondant a une categorie existante, tous les champs remplis.
     */
    public function testPostPublicationWithExistingCategorieIdAllFieldsFilled()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/categorie', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","ID":"1","name_fr":"Conferences nationales et internationales","name_en":"International and national conferences"}');
        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01", "journal": "Ingenierie des Systemes d\'Information RSTI", "volume": "Volume 13", "number": "number 3", "pages": "p. 35-58", "note": "aucune note", "abstract": "resume", "keywords": "test,services web", "series": "serie", "localite": "Clermont", "publisher": "ISI", "editor": "myEditor", "pdf": "useruploads/files/SR08a.pdf", "date_display": "May-June 2008", "categorie_id":1}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Publication created', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications ok.
     */
    public function testGetAllPublications()
    {
        $client = $this->createClient();
        $client->request('GET', '/publications');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('Testabilite des services web', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/date ok.
     */
    public function testGetAllPublicationByDate()
    {
        $client = $this->createClient();
        $client->request('GET', '/publications/date');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('Testabilite des services web', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/categorie ok.
     */
    public function testGetAllPublicationsByCategorie()
    {
        $client = $this->createClient();
        $client->request('GET', '/publications/categorie');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('Testabilite des services web', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/count ok.
     */
    public function testCountPublications()
    {
        $client = $this->createClient();
        $client->request('GET', '/publications/count');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"COUNT(*)":"3"}', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/filter sans contenu.
     */
    public function testGetPublicationsFilterWithoutContent()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/filter');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/filter sans l'attribut a (pour la connexion).
     */
    public function testGetPublicationsFilterWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/filter', array(), array(), array(),
            '{"reference":null,"auteurs":"S. Salva, A. Rollet","titre":null,"date":"2008","journal":null,"volume":null,"number":null,"pages":null,"note":"aucune note","abstract": null,"keywords":null,"series":"serie","localite":"Clermont","publisher":"ISI","editor":"myEditor","pdf":null,"date_display":null}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/filter avec l'attribut a faux.
     */
    public function testGetPublicationssFilterWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/filter', array(), array(), array(),
            '{"a":"toto","reference":null,"auteurs":"S. Salva, A. Rollet","titre":null,"date":"2008","journal":null,"volume":null,"number":null,"pages":null,"note":"aucune note","abstract": null,"keywords":null,"series":"serie","localite":"Clermont","publisher":"ISI","editor":"myEditor","pdf":null,"date_display":null}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/filter sans l'attribut reference.
     */
    public function testGetPublicationsFilterWithoutReference()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/filter', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","auteurs":"S. Salva, A. Rollet","titre":null,"date":"2008","journal":null,"volume":null,"number":null,"pages":null,"note":"aucune note","abstract": null,"keywords":null,"series":"serie","localite":"Clermont","publisher":"ISI","editor":"myEditor","pdf":null,"date_display":null}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Some attributes are missing', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/filter sans tous les attributs.
     */
    public function testGetPublicationsFilterWithoutOptionalFields()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/filter', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":null,"auteurs":"S. Salva, A. Rollet","titre":null,"date":"2008"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Some attributes are missing', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/filter sans publications existantes pour ces filtres.
     */
    public function testGetPublicationsFilterFalse()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/filter', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":"impossible","auteurs":"impossible","titre":"impossible","date":"5002","journal":null,"volume":null,"number":null,"pages":null,"note":null,"abstract": null,"keywords":null,"series":null,"localite":null,"publisher":null,"editor":null,"pdf":null,"date_display":null}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No publications', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/filter ok.
     */
    public function testGetPublicationsFilter()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/filter', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":null,"auteurs":"S. Salva, A. Rollet","titre":null,"date":"2008","journal":null,"volume":null,"number":null,"pages":null,"note":"aucune note","abstract": null,"keywords":null,"series":"serie","localite":"Clermont","publisher":"ISI","editor":"myEditor","pdf":null,"date_display":null}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"reference":"SR08a","auteurs":"S. Salva, A. Rollet","titre":"Testabilite des services web","date":"2008-05-01"', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/asc sans contenu.
     */
    public function testGetPublicationsASCWithoutContent()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/asc');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/asc sans l'attribut a (pour la connexion).
     */
    public function testGetPublicationsASCWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/asc', array(), array(), array(),
            '{"column":"auteurs"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/asc avec l'attribut a faux.
     */
    public function testGetPublicationsASCWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/asc', array(), array(), array(),
            '{"a":"toto","column":"auteurs"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/asc sans l'attribut column.
     */
    public function testGetPublicationsASCWithoutColumnAttributes()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/asc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","column2":"auteurs"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attribute column not here', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/asc ok.
     */
    public function testGetPublicationsASC()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/asc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","column":"auteurs"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"reference":"SR08a","auteurs"', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/desc sans contenu.
     */
    public function testGetPublicationsDESCWithoutContent()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/desc');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/desc sans l'attribut a (pour la connexion).
     */
    public function testGetPublicationsDESCWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/desc', array(), array(), array(),
            '{"column":"auteurs"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/desc avec l'attribut a faux.
     */
    public function testGetPublicationsDESCWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/desc', array(), array(), array(),
            '{"a":"toto","column":"auteurs"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/desc sans l'attribut column.
     */
    public function testGetPublicationsDESCWithoutColumnAttributes()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/desc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","column2":"auteurs"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attribute column not here', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/desc ok.
     */
    public function testGetPublicationsDESC()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/desc', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","column":"auteurs"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"reference":"SR08a","auteurs"', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/id sans contenu.
     */
    public function testGetPublicationByIdWithoutContent()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/1');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/id sans l'attribut a (pour la connexion).
     */
    public function testGetPublicationByIdWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/1', array(), array(), array(),
            '{}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/id avec l'attribut a faux.
     */
    public function testGetPublicationByIdWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/1', array(), array(), array(),
            '{"a":"toto"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/id avec un id inexistant.
     */
    public function testGetPublicationByIdWithoutExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/1000', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Publication doesn\'t exist', $client->getResponse()->getContent());
    }

    /**
     * Test GET /publications/id avec un id existant.
     */
    public function testGetPublicationByIdWithExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('GET', '/admin/publications/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Testabilite des services web', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /publications/id sans contenu.
     */
    public function testPutPublicationByIdWithoutContent()
    {
        $client = $this->createClient();
        $client->request('PUT', '/admin/publications/1');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /publications/id sans l'attribut a (pour la connexion).
     */
    public function testPutRubriqueByIdWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('PUT', '/admin/publications/1', array(), array(), array(),
            '{}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /publications/id avec l'attribut a faux.
     */
    public function testPutRubriqueByIdWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('PUT', '/admin/publications/1', array(), array(), array(),
            '{"a":"toto"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /publications/id sans l'attribut reference.
     */
    public function testPutPublicationByIdWithoutReferenceAttribute()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/publications/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attribute reference not here', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /publications/id avec un id inexistant.
     */
    public function testPutPublicationByIdWithoutExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/publications/1000', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01", "categorie_id":2}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Publication doesn\'t exist', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /publications/id avec un id existant.
     */
    public function testPutPublicationByIdWithExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/publications/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":"SR8a", "titre":"Testabilite des services", "date": "2010-05-01"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Publication updated', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /publications/id avec un id existant, tous les champs remplis.
     */
    public function testPutPublicationByIdAllFieldsFilled()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/publications/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '","reference":"SR8a", "auteurs":"Se. Salva, A. Rollet", "titre":"Testabilite des services", "date": "2010-05-01", "journal": "Ingenierie des Systemes d\'Information", "volume": "Volume 131", "number": "number 13", "pages": "p. 35-70", "note": "debut", "abstract": "resume fini", "keywords": "test,services web, php", "series": "series", "localite": "Paris", "publisher": "S. Salva", "editor": "editor", "pdf": "useruploads/files/SR8a.pdf", "date_display": "May-July 2010", "categorie_id":1}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Publication updated', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /publications/id sans contenu.
     */
    public function testDeletePublicationByIdWithoutContent()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/publications/1');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /publications/id sans l'attribut a (pour la connexion).
     */
    public function testDeletePublicationByIdWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/publications/1', array(), array(), array(),
            '{}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /publications/id avec l'attribut a faux.
     */
    public function testDeletePublicationByIdWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/publications/1', array(), array(), array(),
            '{"a":"toto"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /publications/id avec un id inexistant.
     */
    public function testDeletePublicationByIdWithoutExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('DELETE', '/admin/publications/1000', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Publication doesn\'t exist', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /publications/id avec un id existant.
     */
    public function testDeletePublicationByIdWithExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('DELETE', '/admin/publications/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Publication deleted', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /publications sans contenu.
     */
    public function testDeleteAllPublicationsWithoutContent()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/publications');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /publications sans l'attribut a (pour la connexion).
     */
    public function testDeleteAllPublicationsWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/publications', array(), array(), array(),
            '{}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /publications avec l'attribut a faux.
     */
    public function testDeleteAllPublicationsWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/publications', array(), array(), array(),
            '{"a":"toto"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /publications ok.
     */
    public function testDeleteAllPublications()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('DELETE', '/admin/publications', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Publications deleted', $client->getResponse()->getContent());

        // Supprime les categories crees.
        $client->request('DELETE', '/admin/categories', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') . '"}');
    }
}
