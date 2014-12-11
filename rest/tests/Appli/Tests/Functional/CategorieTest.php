<?php

namespace Appli\Tests\Functional;

use Silex\WebTestCase;
use Appli\PasswordEncoder;

class CategoriesTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../app/app.php';
        $app['debug'] = true;

        return $app;
    }

    /**
     * Test GET /categories sans categories.
     */
    public function testGetAllCategoriesWithoutCategories()
    {
        $client = $this->createClient();
        $client->request('GET', '/categories');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('No categories', $client->getResponse()->getContent());
    }

    /**
     * Test POST /categorie sans contenu.
     */
    public function testPostCategorieWithoutContent()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/categorie');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test POST /categorie sans l'attribut a (pour la connexion).
     */
    public function testPostCategorieWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/categorie', array(), array(), array(),
            '{"name_fr":"Conferences nationales et internationales","name_en":"International and national conferences"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test POST /categorie avec l'attribut a faux.
     */
    public function testPostCategorieWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/categorie', array(), array(), array(),
            '{"a":"toto","name_fr":"Conferences nationales et internationales","name_en":"International and national conferences"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test POST /categorie sans l'attribut name_fr.
     */
    public function testPostCategorieWithoutNameFrAttribute()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/categorie', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","name_en":"International and national conferences"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes name_fr or name_en not here', $client->getResponse()->getContent());
    }

    /**
     * Test POST /categorie sans l'attribut name_en.
     */
    public function testPostCategorieWithoutNameEnAttribute()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/categorie', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","name_fr":"Conferences nationales et internationales"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes name_fr or name_en not here', $client->getResponse()->getContent());
    }

    /**
     * Test POST /categorie sans l'attribut ID.
     */
    public function testPostCategorieWithoutId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/categorie', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","name_fr":"Conferences nationales et internationales","name_en":"International and national conferences"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Categorie created', $client->getResponse()->getContent());
    }

    /**
     * Test POST /categorie avec l'attribut ID.
     */
    public function testPostCategorieWithId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('POST', '/admin/categorie', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","ID":"1","name_fr":"Conferences nationales et internationales","name_en":"International and national conferences"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Categorie created', $client->getResponse()->getContent());
    }

    /**
     * Test GET /categories ok.
     */
    public function testGetAllCategories()
    {
        $client = $this->createClient();
        $client->request('GET', '/categories');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('[{', $client->getResponse()->getContent());
        $this->assertContains('International and national conferences', $client->getResponse()->getContent());
    }

    /**
     * Test GET /categories/id avec un ID inexistant.
     */
    public function testGetCategorieByIDWithoutExistingId()
    {
        $client = $this->createClient();
        $client->request('GET', '/categories/1000');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Categorie doesn\'t exist', $client->getResponse()->getContent());
    }

    /**
     * Test GET /categories/id avec un ID existant.
     */
    public function testGetCategorieByIdWithExistingId()
    {
        $client = $this->createClient();
        $client->request('GET', '/categories/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"ID":"1","name_fr":"Conferences nationales et internationales","name_en":"International and national conferences"}', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /categories/id sans contenu.
     */
    public function testPutCategorieByIdWithoutContent()
    {
        $client = $this->createClient();
        $client->request('PUT', '/admin/categories/1');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /categories/id sans l'attribut a (pour la connexion).
     */
    public function testPutCategorieByIdWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('PUT', '/admin/categories/1', array(), array(), array(),
            '{}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /categories/id avec l'attribut a faux.
     */
    public function testPutCategorieByIdWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('PUT', '/admin/categories/1', array(), array(), array(),
            '{"a":"toto"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /categories/id avec un ID inexistant.
     */
    public function testPutCategorieByIdWithoutExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/categories/1000', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Categorie doesn\'t exist', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /categories/id sans l'attribut name_fr.
     */
    public function testPutCategorieByIdWithoutNameFr()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/categories/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","name_en":"International conferences"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes name_fr or name_en not here', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /categories/id sans l'attribut name_en.
     */
    public function testPutCategorieByIdWithoutNameEn()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/categories/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","name_fr":"Conferences internationales"}');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Attributes name_fr or name_en not here', $client->getResponse()->getContent());
    }

    /**
     * Test PUT /categories/id ok.
     */
    public function testPutCategorieById()
    {
       $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('PUT', '/admin/categories/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'","name_fr":"Conferences internationales","name_en":"International conferences"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Categorie updated', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /categories/id sans contenu.
     */
    public function testDeleteCategorieByIdWithoutContent()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/categories/1');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /categories/id sans l'attribut a (pour la connexion).
     */
    public function testDeleteCategorieByIdWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/categories/1', array(), array(), array(),
            '{}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /categories/id avec l'attribut a faux.
     */
    public function testDeleteCategorieByIdWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/categories/1', array(), array(), array(),
            '{"a":"toto"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /categories/id avec un ID inexistant.
     */
    public function testDeleteCategorieByIdWithoutExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('DELETE', '/admin/categories/1000', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Categorie doesn\'t exist', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /categories/id avec un ID existant.
     */
    public function testDeleteCategorieByIdWithExistingId()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('DELETE', '/admin/categories/1', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Categorie deleted', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /categories sans contenu.
     */
    public function testDeleteCategoriesWithoutContent()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/categories');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('No content', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /categories sans l'attribut a (pour la connexion).
     */
    public function testDeleteCategoriesWithoutAAttribute()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/categories', array(), array(), array(),
            '{}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /categories avec l'attribut a faux.
     */
    public function testDeleteCategoriesWithAAttributeFalse()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/admin/categories', array(), array(), array(),
            '{"a":"toto"}');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertEquals('Admin not connected', $client->getResponse()->getContent());
    }

    /**
     * Test DELETE /categories ok.
     */
    public function testDeleteCategories()
    {
        $client = $this->createClient();
        $encoder = new PasswordEncoder();
        $client->request('DELETE', '/admin/categories', array(), array(), array(),
            '{"a":"' . $encoder->encodePassword('Admin connected') .'"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Categories deleted', $client->getResponse()->getContent());
    }
}
