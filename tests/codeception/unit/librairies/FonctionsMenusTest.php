<?php
namespace librairies;
use yii\codeception\TestCase;
use app\librairies\FonctionsMenus;
use app\librairies\FonctionsCurl;
use app\models\Menu;
use app\models\Rubrique;
use yii\web\Curl;


class FonctionsMenusTest extends TestCase
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
    public function testGetMenuById()
    {
		$menu = new Menu(['ID' => '5', 'titre_fr'=>'Accueil', 'titre_en'=>'Home', 'actif'=>'1', 'position'=>'1']);
		$this->assertEquals($menu, FonctionsMenus::getMenuById(5));
    }
    
    /**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Menu doesn't exist
     */
    public function testGetMenuByMauvaisId()
    {
		FonctionsMenus::getMenuById(94);
    }
    
    /**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage Menu doesn't exist
     */
    public function testGetMenuByStringId()
    {
		FonctionsMenus::getMenuById('cinq');
    }
    
    public function testGetIdParTitreFR()
    {
		$menu = Menu::find()->where(['titre_fr'=>'Accueil'])->one();
		$rubrique = Rubrique::find()->where(['menu_id'=>$menu->ID])->one();
		$this->assertEquals($rubrique->menu_id, FonctionsMenus::getIdParTitreFR('Accueil'));
	}
	
	/**
     * @expectedException yii\web\HttpException
     * @expectedExceptionMessage No rubriques
     */
	public function testGetIdParTitreFRInexistant()
    {
		FonctionsMenus::getIdParTitreFR('MaisCeTitreNExistePasSacrebleu!');
	}
	
	public function testGetMenusActifs()
	{
		$menu = Menu::find()->where(['actif'=>'1']);
		$tb = array();
		foreach($menu as $item){
			$tb[]=$item['titre_fr'];
		}
		$this->assertEquals($tb, FonctionsMenus::getMenusActifs('fr'));
	}

}
