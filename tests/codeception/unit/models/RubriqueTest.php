<?php

use Yii;
use yii\codeception\TestCase;
use app\models\Rubrique	;
use Codeception\Specify;

class RubriqueTest extends TestCase
{
	
	use Specify;
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
    public function testRubriqueMauvaisesDates()
    {
		$model = new Rubrique([
            'date_modification' => '2014-09-',
            'content_fr' => 'Contenu Francais',
            'content_en' => 'Contenu Anglais',
            'menu_id' => '100',
        ]);

        $this->specify('Les dates ne doivent pas être validées', function () use ($model) {
            $this->assertFalse($model->validate(['date_creation']));
            $this->assertFalse($model->validate(['date_modification']));
        });
    }
    
    public function testRubriqueMenuIdString()
    {
		$model = new Rubrique([
			'date_modification' => '2014-09-12',
            'date_modification' => '2014-09-12',
            'content_fr' => 'Contenu Francais',
            'content_en' => 'Contenu Anglais',
            'menu_id' => '100',
        ]);

        $this->specify('Le menu_id doit être un entier', function () use ($model) {
            $this->assertFalse(is_int($model->menu_id));
        });
    }
    
    public function testRubriqueCaractereSpeciauxDansContenu()
    {
		$model = new Rubrique([
			'date_modification' => '2014-09-12',
            'date_modification' => '2014-09-12',
            'content_fr' => ' Contenu Francais 123_"ê$£+-*/&~[}` ',
            'content_en' => 'Contenu Anglais 123_"ê$£+-*/&~[}`',
            'menu_id' => '100',
        ]);

        $this->specify('Les caractères speciaux sont tolérés dans les contents', function () use ($model) {
            $this->assertTrue($model->validate(['content_fr']));
            $this->assertTrue($model->validate(['content_en']));
        });
    }
    
    public function testRubriqueOK()
    {
		$model = new Rubrique([
			'date_creation' => '2014-09-12',
            'date_modification' => '2014-09-12',
            'content_fr' => 'Contenu Francais',
            'content_en' => 'Contenu Anglais',
            'menu_id' => 100,
        ]);

        $this->specify('Tous les champs sont valides', function () use ($model) {
			$this->assertTrue($model->validate(['date_creation']));
            $this->assertTrue($model->validate(['date_modification']));
            $this->assertTrue(is_int($model->menu_id));
        });
    }
    
}
