<?php
namespace librairies;

use Yii;
use yii\codeception\TestCase;
use app\models\Rubrique;
use app\controllers\RubriquesController;
use Codeception\Specify;
use app\librairies\FonctionsCurl;
use app\librairies\FonctionsRubriques;


class FonctionsCurlTest extends TestCase
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

	

    // tests
    public function testCreateRubrique()
    {
		$session = Yii::$app->session;
		$session->open();
		$session->set('token','WU8nb/rCD6JgtiyxTW3ZP+s4n9Vg9liUllh5bZLoLQhAMMoCaHE72nYLQSsw12uhkgWJLDmgMmZVD+aIk6BsZw==');
		$token = $session->get('token');
		
		$lastRubri;	
		FonctionsCurl::CreateRubrique($token,'Mon titre Fr','Mon titre En',1,2,'Mon content Fr','Mon content En');
		$tabRubri = FonctionsRubriques::getAllRubriques();
		foreach($tabRubri as $rubri)
		{
			$lastRubri = $rubri;
		}
		$this->assertEquals($lastRubri['titre_fr'], 'Mon titre Fr');
    }

    public function testUpdateRubrique()
    {
		$session = Yii::$app->session;
		$session->open();
		$session->set('token','WU8nb/rCD6JgtiyxTW3ZP+s4n9Vg9liUllh5bZLoLQhAMMoCaHE72nYLQSsw12uhkgWJLDmgMmZVD+aIk6BsZw==');
		$token = $session->get('token');
		
		$lastRubri;	
		$tabRubri = FonctionsRubriques::getAllRubriques();
		foreach($tabRubri as $rubri)
		{
			$lastRubri = $rubri;
		}
		FonctionsCurl::UpdateRubrique($token, $lastRubri['ID'], 'France','England',1,2,'Le contenu il est français!','The content is in English!');
		$tabRubri = FonctionsRubriques::getAllRubriques();
		foreach($tabRubri as $rubri)
		{
			$lastRubri = $rubri;
		}
		$this->assertEquals($lastRubri['content_en'], 'The content is in English!');
    }
    
    /**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Rubrique doesn't exist
     */
    public function testDeleteRubrique()
    {
		$session = Yii::$app->session;
		$session->open();
		$session->set('token','WU8nb/rCD6JgtiyxTW3ZP+s4n9Vg9liUllh5bZLoLQhAMMoCaHE72nYLQSsw12uhkgWJLDmgMmZVD+aIk6BsZw==');
		$token = $session->get('token');
		
		$lastRubri;	
		$tabRubri = FonctionsRubriques::getAllRubriques();
		foreach($tabRubri as $rubri)
		{
			$lastRubri = $rubri;
		}
		FonctionsCurl::DeleteRubrique($token, $lastRubri['ID']);
		FonctionsRubriques::getRubriqueParid($lastRubri['ID']);
    }
    
    public function testCreateRubriqueActifString()
    {
		$session = Yii::$app->session;
		$session->open();
		$session->set('token','WU8nb/rCD6JgtiyxTW3ZP+s4n9Vg9liUllh5bZLoLQhAMMoCaHE72nYLQSsw12uhkgWJLDmgMmZVD+aIk6BsZw==');
		$token = $session->get('token');
		
		$lastRubri;	
		FonctionsCurl::CreateRubrique($token,'Mon titre Fr','Mon titre En','un',2,'Mon content Fr','Mon content En');
		$tabRubri = FonctionsRubriques::getAllRubriques();
		foreach($tabRubri as $rubri)
		{
			$lastRubri = $rubri;
		}
		$this->assertEquals($lastRubri['actif'], 0);
    }
    
    public function testCreateRubriquePositionString()
    {
		$session = Yii::$app->session;
		$session->open();
		$session->set('token','WU8nb/rCD6JgtiyxTW3ZP+s4n9Vg9liUllh5bZLoLQhAMMoCaHE72nYLQSsw12uhkgWJLDmgMmZVD+aIk6BsZw==');
		$token = $session->get('token');
		
		$lastRubri;	
		FonctionsCurl::CreateRubrique($token,'Mon titre Fr','Mon titre En',1,'Deux','Mon content Fr','Mon content En');
		$tabRubri = FonctionsRubriques::getAllRubriques();
		foreach($tabRubri as $rubri)
		{
			$lastRubri = $rubri;
		}
		$this->assertEquals($lastRubri['actif'], 1);
    }

}
