<?php
namespace Appli\Tests\Functional;

use Silex\WebTestCase;

class PublicationTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../app/app.php';
        $app['debug'] = true;
        $app['session.test'] = true;

        return $app;
    }

    public function testGetAllPublicationsWithoutPublications()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testCountPublicationWithoutPublications()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications/count', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"COUNT(*)":"0"}', $client->getResponse()->getContent());
    }

    public function testGetPublicationsDateWithoutPublications()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications/date', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetPublicationsCategorieWithoutPublications()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications/categorie', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetPublicationsOrderByAttributeWithColumnAttributeWithoutPublications()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('GET', '/admin/publications/asc', array(), array(), array(), '{"column":"auteurs"}');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetPublicationsOrderByAttributeDESCWithColumnAttributeWithoutPublications()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('GET', '/admin/publications/desc', array(), array(), array(), '{"column":"auteurs"}');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testPostPublicationWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/publication');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testPostPublicationWithoutContent()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('POST', '/admin/publication', array(), array(), array(), null);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testPostPublicationWithoutReference()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('POST', '/admin/publication', array(), array(), array(), '{"auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01"}');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testPostPublicationWithoutAuteurs()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('POST', '/admin/publication', array(), array(), array(), '{"reference":"SR08a", "titre":"Testabilite des services web", "date": "2008-05-01"}');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testPostPublicationWithoutTitre()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('POST', '/admin/publication', array(), array(), array(), '{"reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "date": "2008-05-01"}');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testPostPublicationWithoutDate()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('POST', '/admin/publication', array(), array(), array(), '{"reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web"}');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testPostPublicationWithoutID()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('POST', '/admin/publication', array(), array(), array(), '{"reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01"}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testPostPublicationWithID()
    {
    $client = $this->createClient();
    $crawler = $client->request('GET', '/admin', array(), array(), array(
        'CONTENT_TYPE'  => 'en'
    ), null);
    $buttonCrawlerNode = $crawler->selectButton('Submit');
    $form = $buttonCrawlerNode->form(array(
        '_username' => 'admin',
        '_password' => 'admin',
    ));
    $client->submit($form);

    $client->request('POST', '/admin/publication', array(), array(), array(), '{"ID":2, "reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01"}');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
    $this->assertEquals(null, $client->getResponse()->getContent());
}

    public function testPostPublicationWithNonExistingCategorieID()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('POST', '/admin/publication', array(), array(), array(), '{"reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01", "categorie_id":1000}');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    public function testPostPublicationWithExistingCategorieID()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('POST', '/admin/categorie', array(), array(), array(), '{"ID":2,"name_fr":"Conferences nationales et internationales","name_en":"International and national conferences"}');

        $client->request('POST', '/admin/publication', array(), array(), array(), '{"reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01", "categorie_id":2}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testPostPublicationWithExistingCategorieIDAllFieldsFilled()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('POST', '/admin/categorie', array(), array(), array(), '{"ID":2,"name_fr":"Conferences nationales et internationales","name_en":"International and national conferences"}');

        $client->request('POST', '/admin/publication', array(), array(), array(),
            '{"reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01", "journal": "Ingenierie des Systemes d\'Information RSTI", "volume": "Volume 13", "number": "number 3", "pages": "p. 35-58", "note": "aucune note", "abstract": "resume", "keywords": "test,services web", "series": "serie", "localite": "Clermont", "publisher": "ISI", "editor": "myEditor", "pdf": "useruploads/files/SR08a.pdf", "date_display": "May-June 2008", "categorie_id":2}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetAllPublicationsWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testGetAllPublications()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('Testabilite des services web', $client->getResponse()->getContent());
    }

    public function testGetPublicationDateWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/date');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testGetPublicationDate()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications/date', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotNull($client->getResponse()->getContent());
    }

    public function testGetPublicationCategorieWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/categorie');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testGetPublicationCategorie()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications/categorie', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotNull($client->getResponse()->getContent());
    }

    public function testCountPublicationsWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/count');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testCountPublications()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications/count', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"COUNT(*)":"4"}', $client->getResponse()->getContent());
    }

    public function testGetPublicationsOrderByAttributeWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/asc');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testGetPublicationsOrderByAttributeWithoutContent()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications/asc', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetPublicationsOrderByAttributeWithoutColumnAttribute()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('GET', '/admin/publications/asc', array(), array(), array(), '{"column2":"auteurs"}');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetPublicationsOrderByAttribute()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);
        $client->request('POST', '/admin/publication', array(), array(), array(), '{"reference":"SR08a", "auteurs":"A. Rollet", "titre":"Testabilite des services web", "date": "2012-05-01", "categorie_id":2}');
        $client->request('GET', '/admin/publications/asc', array(), array(), array(), '{"column":"auteurs"}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"reference":"SR08a","auteurs":"A. Rollet"', $client->getResponse()->getContent());
    }

    public function testGetPublicationsOrderByAttributeDESCWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/desc');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testGetPublicationsOrderByAttributeDESCWithoutContent()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications/desc', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetPublicationsOrderByAttributeDESCWithoutColumnAttribute()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('GET', '/admin/publications/desc', array(), array(), array(), '{"column2":"auteurs"}');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetPublicationsOrderByAttributeDESC()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);
        $client->request('POST', '/admin/publication', array(), array(), array(), '{"reference":"SR08a", "auteurs":"A. Rollet", "titre":"Testabilite des services web", "date": "2012-05-01", "categorie_id":2}');
        $client->request('GET', '/admin/publications/desc', array(), array(), array(), '{"column":"auteurs"}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"reference":"SR08a","auteurs":"A. Rollet"', $client->getResponse()->getContent());
    }

    public function testGetPublicationByIdWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/1');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testGetPublicationsByNonExistingId()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications/1000', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetPublicationsByExistingId()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/publications/2', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Testabilite des services web', $client->getResponse()->getContent());
    }

    public function testGetFilterPublicationsWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/publications/filter');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testGetFilterPublicationsWithoutContent()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
        'CONTENT_TYPE' => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
        '_username' => 'admin',
        '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('GET', '/admin/publications/filter', array(), array(), array(), null);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetFilterPublicationsWithoutReference()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'fr'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Envoyer');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('GET', '/admin/publications/filter', array(), array(), array(), '{"auteurs":"S. Salva, A. Rollet","titre":null,"date":"2008","journal":null,"volume":null,"number":null,"pages":null,"note":"aucune note","abstract": null,"keywords":null,"series":"serie","localite":"Clermont","publisher":"ISI","editor":"myEditor","pdf":null,"date_display":null}');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

     public function testGetFilterPublicationsWithoutOptionalFields()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'fr'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Envoyer');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('GET', '/admin/rubriques/filter', array(), array(), array(), '{"reference":null,"auteurs":"S. Salva, A. Rollet","titre":null,"date":"2008"}');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetFilterPublicationsNull()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'fr'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Envoyer');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('GET', '/admin/publications/filter', array(), array(), array(), '{"reference":"impossible","auteurs":"impossible","titre":"impossible","date":"5002","journal":null,"volume":null,"number":null,"pages":null,"note":null,"abstract": null,"keywords":null,"series":null,"localite":null,"publisher":null,"editor":null,"pdf":null,"date_display":null}');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetFilterPublications()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'fr'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Envoyer');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('GET', '/admin/publications/filter', array(), array(), array(), '{"reference":null,"auteurs":"S. Salva, A. Rollet","titre":null,"date":"2008","journal":null,"volume":null,"number":null,"pages":null,"note":"aucune note","abstract": null,"keywords":null,"series":"serie","localite":"Clermont","publisher":"ISI","editor":"myEditor","pdf":null,"date_display":null}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"reference":"SR08a","auteurs":"S. Salva, A. Rollet","titre":"Testabilite des services web","date":"2008-05-01"', $client->getResponse()->getContent());
   }

    public function testUpdatePublicationWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('PUT', '/admin/publications/2');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testUpdatePublicationWithoutContent()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('PUT', '/admin/publications/2', array(), array(), array(), null);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testUpdatePublicationByNonExistingId()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('PUT', '/admin/publications/1000', array(), array(), array(), '{"reference":"SR08a", "auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web", "date": "2008-05-01", "categorie_id":2}');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testUpdatePublicationWithoutReference()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('PUT', '/admin/publications/2', array(), array(), array(), '{"auteurs":"S. Salva, A. Rollet", "titre":"Testabilite des services web"}');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testUpdatePublication()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('PUT', '/admin/publications/2', array(), array(), array(), '{"reference":"SR8a", "titre":"Testabilite des services", "date": "2010-05-01"}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testUpdatePublicationAllFieldsFilled()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('POST', '/admin/categorie', array(), array(), array(), '{"ID":1,"name_fr":"Conferences internationales","name_en":"International conferences"}');
        $client->request('PUT', '/admin/publications/2', array(), array(), array(),
            '{"reference":"SR8a", "auteurs":"Se. Salva, A. Rollet", "titre":"Testabilite des services", "date": "2010-05-01", "journal": "Ingenierie des Systemes d\'Information", "volume": "Volume 131", "number": "number 13", "pages": "p. 35-70", "note": "debut", "abstract": "resume fini", "keywords": "test,services web, php", "series": "series", "localite": "Paris", "publisher": "S. Salva", "editor": "editor", "pdf": "useruploads/files/SR8a.pdf", "date_display": "May-July 2010", "categorie_id":1}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testDeletePublicationWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/publications/2');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testDeletePublicationByNonExistingId()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('DELETE', '/admin/publications/1000', array(), array(), array(), null);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testDeletePublicationByExistingId()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('DELETE', '/admin/publications/2', array(), array(), array(), null);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testDeleteAllPublicationWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/publications');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testDeleteAllPublication()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $client->request('DELETE', '/admin/publications', array(), array(), array(), null);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());

        //Supprime la categorie cree dans les tests de cette page
        $client->request('DELETE', '/admin/categories', array(), array(), array(), null);
    }
}
