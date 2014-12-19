<?php
namespace librairies;
use Yii;
use yii\codeception\TestCase;
use app\librairies\FonctionsRubriques;
use app\librairies\FonctionsCurl;
use app\models\Rubrique;
use app\models\Menu;
use app\controllers\RubriquesController;
use yii\web\Curl;


class FonctionsRubriquesTest extends TestCase
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
    public function testRubriqueParIdRubriqueOk()
    {
		$uneRubrique = new Rubrique(['ID'=>'5','date_creation'=>'2014-12-16','date_modification'=>'2014-12-16','content_fr'=>'Accueil','content_en'=>'Home','menu_id'=>'5']);
		$this->assertEquals($uneRubrique, FonctionsRubriques::getRubriqueParidentifiant(5,'fr'));
    }
    
    public function testRubriqueParIdMenuOk()
    {
		$uneRubrique = new Rubrique(['ID'=>'5','date_creation'=>'2014-12-16','date_modification'=>'2014-12-16','content_fr'=>'Accueil','content_en'=>'Home','menu_id'=>'5']);
		$this->assertEquals($uneRubrique, FonctionsRubriques::getRubriqueParid(5,'fr'));
    }
    
    /**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Rubrique doesn't exist
     */
    public function testRubriqueParIdRubriqueInexistant()
    {
		FonctionsRubriques::getRubriqueParidentifiant(78,'fr');
    }
    
    /**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Rubrique doesn't exist
     */
    public function testRubriqueParIdRubriqueString()
    {
		FonctionsRubriques::getRubriqueParidentifiant('ppppp','fr');
    }
    
    /**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Rubrique doesn't exist
     */
    public function testRubriqueParIdMenuInexistant()
    {
		FonctionsRubriques::getRubriqueParid(115,'fr');
    }
    
    /**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Rubrique doesn't exist
     */
    public function testRubriqueParIdMenuString()
    {
		FonctionsRubriques::getRubriqueParid('ppppp','fr');
    }
    
    public function testContentRubriqueParIdFR()
    {
		$rubri = Rubrique::find()->where(['ID' => 5])->one();
		$this->assertEquals($rubri->content_fr, FonctionsRubriques::getContentRubriqueParid(5,'fr'));
    }
    
    /**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Rubrique doesn't exist
     */
    public function testContentRubriqueParIdInexistant()
    {
		$rubri = Rubrique::find()->where(['ID' => 5])->one();
		$this->assertEquals($rubri->content_fr, FonctionsRubriques::getContentRubriqueParid(8,'fr'));
    }
    
    /**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Rubrique doesn't exist
     */
    public function testContentRubriqueParIdString()
    {
		$rubri = Rubrique::find()->where(['ID' => 5])->one();
		$this->assertEquals($rubri->content_fr, FonctionsRubriques::getContentRubriqueParid('cinq','fr'));
    }
    
    public function testFirstRubrique()
    {
		$firstRubri = Rubrique::find()->one();
		$arrayFirstRubri = array();
		foreach($firstRubri as $key=>$value)
		{
			$arrayFirstRubri[$key] = $value;
		}
		
		$firstRubriJson = FonctionsRubriques::getFirstRubrique();
		$arrayFirstRubriJson = array();
		foreach($firstRubriJson as $key=>$value)
		{
			$arrayFirstRubriJson[$key] = $value;
		}
		$this->assertEquals($arrayFirstRubri, $arrayFirstRubriJson);
	}
	

}
