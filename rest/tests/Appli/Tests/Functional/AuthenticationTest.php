<?php
namespace Appli\Tests\Functional;

use Silex\WebTestCase;

class AuthenticationTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../app/app.php';
        $app['debug'] = true;
        $app['session.test'] = true;

        return $app;
    }

    public function testInitialPage()
    {
        $client = $this->createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testLoginErrorLanguage()
    {
        $client = $this->createClient();
        $client->request('GET', '/login', array(), array(), array(
            'CONTENT_TYPE'  => 'it',

        ),   null);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testLoginCorrectLanguage()
    {
        $client = $this->createClient();
        $client->request('GET', '/login', array(), array(), array(
                'CONTENT_TYPE'  => 'fr',
            ), null);
        $this->assertNotEquals(400, $client->getResponse()->getStatusCode());
        $this->assertNotEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testDisplayLoginFormFR()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'fr',
        ), null);
        $this->assertContains('Veuillez vous identifier', $client->getResponse()->getContent());
        $this->assertContains('Identifiant', $client->getResponse()->getContent());
        $this->assertContains('Mot de passe', $client->getResponse()->getContent());
        $this->assertContains('Envoyer', $client->getResponse()->getContent());
    }

    public function testDisplayLoginFormEN()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/admin', array(), array(), array(
            'CONTENT_TYPE'  => 'en',
        ), null);
        $this->assertContains('Please identify', $client->getResponse()->getContent());
        $this->assertContains('Login', $client->getResponse()->getContent());
        $this->assertContains('Password', $client->getResponse()->getContent());
        $this->assertContains('Submit', $client->getResponse()->getContent());
    }

    public function testAdminPageWithoutConnection()
    {
        $client = $this->createClient();
        $client->request('GET', '/admin');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Language needed: French or English', $client->getResponse()->getContent());
    }

    public function testAdminPageFR()
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

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }

    public function testAdminPageEN()
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

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }
}
