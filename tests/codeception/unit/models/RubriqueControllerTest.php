<?php
namespace models;

use Yii;
use yii\codeception\TestCase;
use app\models\Rubrique;
use app\controllers\RubriquesController;
use Codeception\Specify;
use app\librairies\FonctionsRubriques;

class RubriqueControllerTest extends TestCase
{
	use Specify;
    /**
     * @var \UnitTester
     */
    protected $model;

    protected function _before()
    {
		
    }

    protected function _after()
    {
		
    }
    

    // tests
    public function test()
    {
		$model = $this->getMock('app\models\Rubrique', ['validate']);
		$model->attributes = [
			'ID' => '74',
            'date_creation' => '2014-09-08',
            'date_modification' => '2014-09-08',
            'content_fr' => 'poulipoulou',
            'content_en' => 'caloulilu',
            'menu_id' => '100',
        ];
        //$this->assertEquals(FonctionsRubriques::getRubriqueParid($model->ID, 'fr'), $model);
		             
    }

}
