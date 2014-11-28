<?php
namespace Appli\Tests\Functional;

use Silex\WebTestCase;

class MenuTest extends WebTestCase
{
    public function createApplication()

    {
        $app = require __DIR__ . '/../../../../app/app.php';
        $app['debug'] = true;
        $app['session.test'] = true;

        return $app;
    }

    public function testGetAllMenuWithoutMenu()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/menus', array(), array(), array(
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

    public function testGetAllMenuActifWithoutMenuActif()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/menus/actif', array(), array(), array(
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

    public function testGetAllMenuWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/menus');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testGetAllMenuActifWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/menus/actif');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testGetAllMenu()
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

        $client->request('POST', '/admin/rubrique', array(), array(), array(), '{"ID":1,"titre_fr":"Home","titre_en":"Home","actif":1,"position":2}');
        $client->request('POST', '/admin/rubrique', array(), array(), array(), '{"ID":2,"titre_fr":"Recherche","titre_en":"Research","actif":1,"position":3}');
        $client->request('GET', '/admin/menus');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"titre_fr":"Home","titre_en":"Home"', $client->getResponse()->getContent());
        $this->assertContains('"titre_fr":"Recherche","titre_en":"Research"', $client->getResponse()->getContent());

        $client->request('DELETE', '/admin/rubriques/1', array(), array(), array(), null);
        $client->request('DELETE', '/admin/rubriques/2', array(), array(), array(), null);
    }

    public function testGetAllMenuActif()
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

        $client->request('POST', '/admin/rubrique', array(), array(), array(), '{"ID":1,"titre_fr":"Home","titre_en":"Home","actif":1,"position":2}');
        $client->request('POST', '/admin/rubrique', array(), array(), array(), '{"ID":2,"titre_fr":"Recherche","titre_en":"Research","actif":1,"position":3}');
        $client->request('GET', '/admin/menus/actif');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('"titre_fr":"Home","titre_en":"Home"', $client->getResponse()->getContent());
        $this->assertContains('"titre_fr":"Recherche","titre_en":"Research"', $client->getResponse()->getContent());

        $client->request('DELETE', '/admin/rubriques/1', array(), array(), array(), null);
        $client->request('DELETE', '/admin/rubriques/2', array(), array(), array(), null);
    }

    public function testGetMenuByIdWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin/menus/2');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testGetMenuByNonExistingId()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin/menus/1000', array(), array(), array(
            'CONTENT_TYPE'  => 'fr'
        ), null);
        $buttonCrawlerNode = $crawler->selectButton('Envoyer');
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));
        $client->submit($form);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testGetMenusByExistingId()
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

        $client->request('POST', '/admin/rubrique', array(), array(), array(), '{"ID":3,"titre_fr":"Recherche","titre_en":"Research","actif":1,"position":3}');
        $client->request('GET', '/admin/menus/3');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('"titre_fr":"Recherche","titre_en":"Research"', $client->getResponse()->getContent());

        $client->request('DELETE', '/admin/rubriques/3', array(), array(), array(), null);
    }

}
