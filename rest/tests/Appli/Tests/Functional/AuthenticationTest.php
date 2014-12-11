<?php

namespace Appli\Tests\Functional;

use Silex\WebTestCase;
use Appli\PasswordEncoder;

class AuthenticationTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../app/app.php';
        $app['debug'] = true;

        return $app;
    }

    /**
     * Test page login sans contenu.
     */
    public function testLoginPageWithoutContent()
    {
        $client = $this->createClient();
        $client->request('POST', '/login');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test page login sans l'attribut username.
     */
    public function testLoginPageWithoutUsernameAttribute()
    {
        $client = $this->createClient();
        $client->request('POST', '/login', array(), array(), array(),
            '{"password":"admin"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes username or password not here', $client->getResponse()->getContent());
    }

    /**
     * Test page login sans l'attribut password.
     */
    public function testLoginPageWithoutPasswordAttribute()
    {
        $client = $this->createClient();
        $client->request('POST', '/login', array(), array(), array(),
            '{"username":"admin"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes username or password not here', $client->getResponse()->getContent());
    }

    /**
     * Test page login avec un username inexistant.
     */
    public function testLoginPageWithNonExistingUser()
    {
        $client = $this->createClient();
        $client->request('POST', '/login', array(), array(), array(),
            '{"username":"toto","password":"admin"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('User don\'t exist', $client->getResponse()->getContent());
    }

    /**
     * Test page login avec un password faux par rapport a l'username.
     */
    public function testLoginPageWithFalsePassword()
    {
        $client = $this->createClient();
        $client->request('POST', '/login', array(), array(), array(),
            '{"username":"admin","password":"toto"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test page login avec username et password valide.
     */
    public function testLoginPageWithCorrectPassword()
    {
        $client = $this->createClient();
        $client->request('POST', '/login', array(), array(), array(),
            '{"username":"admin","password":"admin"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $encoder = new PasswordEncoder();
        $this->assertEquals($encoder->encodePassword('Admin connected'), $client->getResponse()->getContent());
    }
}
