<?php
namespace librairies;
use Yii;
use yii\codeception\TestCase;
use app\librairies\FonctionsPublications;
use app\librairies\FonctionsCurl;
use app\models\Publication;
use app\models\Categorie;
use app\controllers\PublicationController;
use yii\web\Curl;


class FonctionsPublicationsTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
		
    }

    protected function _after()
    {
    }

    public function testGetPublicationParId()
    {
		$session = Yii::$app->session;
		$session->open();
		$session->set('token','WU8nb/rCD6JgtiyxTW3ZP+s4n9Vg9liUllh5bZLoLQhAMMoCaHE72nYLQSsw12uhkgWJLDmgMmZVD+aIk6BsZw==');
		$token = $session->get('token');
		
		$publi = new Publication(['ID' =>'3330', 'reference' => 'C3PO', 'auteurs' => 'Marcel', 'titre' => 'Don\'t delete', 'date' => '1421-01-01', 'journal' => 'Utile pour tester les fonctions', 'volume' => '', 'number' => '', 'pages' => '', 'note' => '', 'abstract' => '', 'keywords' => '','series' => '', 'localite' => '','publisher' => '', 'editor' => '', 'pdf' => null, 'date_display' => '', 'categorie_id' => '1']);
		$this->assertEquals($publi, FonctionsPublications::getPubliParId($token,3330));
	}
	
	/**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Publication doesn't exist
     */
	public function testGetPublicationMauvaisId()
    {
		$session = Yii::$app->session;
		$session->open();
		$session->set('token','WU8nb/rCD6JgtiyxTW3ZP+s4n9Vg9liUllh5bZLoLQhAMMoCaHE72nYLQSsw12uhkgWJLDmgMmZVD+aIk6BsZw==');
		$token = $session->get('token');
		
		FonctionsPublications::getPubliParId($token,1337);
	}
	
	/**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Admin not connected
     */
	public function testGetPublicationMauvaisToken()
    {
		$session = Yii::$app->session;
		$session->open();
		$session->set('token','JeSuisUnMauvaisToken');
		$token = $session->get('token');
		
		FonctionsPublications::getPubliParId($token,3330);
	}
	
	public function testGetCategorieParId()
    {	
		$categ = new Categorie(['ID' => '1', 'name_fr' => 'Article', 'name_en' => 'Article']);
		$this->assertEquals($categ, FonctionsPublications::getCategParId(1));
	}	
	
	/**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Categorie doesn't exist
     */
	public function testGetCategorieMauvaisId()
    {	
		FonctionsPublications::getCategParId(9);
	}
	
	/**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Categorie doesn't exist
     */
	public function testGetCategorieStringId()
    {	
		FonctionsPublications::getCategParId('neuf');
	}
    

}
