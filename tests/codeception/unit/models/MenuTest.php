<?php

use Yii;
use yii\codeception\TestCase;
use app\models\Menu;
use Codeception\Specify;

class MenuTest extends TestCase
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
    public function testMenuSansTitreFr()
    {
		$model = new Menu([
		'titre_en' => 'I\'m a title!',
		'actif' => 1,
		'position' => 1,            
        ]);

        $this->specify('Le titre fr est obligatoire', function () use ($model) {
            $this->assertFalse($model->validate(['titre_fr']));
        });
    }
    
    public function testMenuSansTitreEn()
    {
		$model = new Menu([
		'titre_fr' => 'Je suis un titre!',
		'actif' => 1,
		'position' => 1,            
        ]);

        $this->specify('Le titre en est obligatoire', function () use ($model) {
            $this->assertFalse($model->validate(['titre_en']));
        });
    }
    
    public function testMenuSansChampActif()
    {
		$model = new Menu([
		'titre_fr' => 'Je suis un titre!',
		'titre_en' => 'I\'m a title!',
		'position' => 1,            
        ]);

        $this->specify('Le titre fr est obligatoire', function () use ($model) {
            $this->assertFalse($model->validate(['actif']));
        });
    }
    
    public function testMenuSansChampPosition()
    {
		$model = new Menu([
		'titre_fr' => 'Je suis un titre',
		'titre_en' => 'I\'m a title!',
		'actif' => 1,
        ]);

        $this->specify('Le titre fr est obligatoire', function () use ($model) {
            $this->assertFalse($model->validate(['position']));
        });
    }
    
    public function testMenuLongueurTitre()
    {
		$model = new Menu([
		'titre_fr' => 'Je suis un titre de plus de 20 caractères!',
		'titre_en' => 'I\'m a title with more than 20 print!',
		'actif' => 1,
		'position' => 1,            
        ]);

        $this->specify('Les titres ne doivent pas depasser 20 caractères', function () use ($model) {
            $this->assertFalse($model->validate(['titre_fr']));
            $this->assertFalse($model->validate(['titre_en']));
        });
    }

}
