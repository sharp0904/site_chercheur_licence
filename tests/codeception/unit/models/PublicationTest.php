<?php

use Yii;
use yii\codeception\TestCase;
use app\models\Publication;
use app\controllers\PublicationController;
use app\models\Bibtex;
use Codeception\Specify;

class PublicationTest extends TestCase
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
    public function testPubliSansReference()
    {
		$model = new Publication([
		'auteurs' => 'un auteur',
		'titre' => 'Au bord de l\'autoroute',
		'date' => '2014-05-12',
		'categorie_id' => 1,
            
        ]);

        $this->specify('La référence est obligatoire', function () use ($model) {
            $this->assertFalse($model->validate(['reference']));
        });
    }
    
    public function testPubliSansAuteur()
    {
		$model = new Publication([
		'reference' => 'C3PO',
		'titre' => 'un titre',
		'date' => '2014-05-12',
		'categorie_id' => 1,
            
        ]);

        $this->specify('L\'auteur est obligatoire', function () use ($model) {
            $this->assertFalse($model->validate(['auteurs']));
        });
    }
    
    public function testPubliSansTitre()
    {
		$model = new Publication([
		'reference' => 'H42',
		'auteurs' => 'un auteur',
		'date' => '2014-05-12',
		'categorie_id' => 1,
            
        ]);

        $this->specify('Le titre est obligatoire', function () use ($model) {
            $this->assertFalse($model->validate(['titre']));
        });
    }
    
    public function testPubliSansCategorie()
    {
		$model = new Publication([
		'reference' => 'H42',
		'auteurs' => 'un auteur',
		'date' => '2014-05-12',
            
        ]);

        $this->specify('La categorie est obligatoire', function () use ($model) {
            $this->assertFalse($model->validate(['categorie_id']));
        });
    }
    
    public function testPubliCategorieString()
    {
		$model = new Publication([
		'reference' => 'H42',
		'auteurs' => 'un auteur',
		'date' => '2014-05-12',
		'categorie_id' => 'un',
            
        ]);

        $this->specify('La categorie doit être un entier', function () use ($model) {
            $this->assertFalse($model->validate(['categorie_id']));
        });
    }
    
    public function testPubliSansDate()
    {
		$model = new Publication([
		'reference' => 'H42',
		'auteurs' => 'un auteur',
		'titre' => 'Au bord de l\'autoroute',
		'categorie_id' => 1,
            
        ]);

        $this->specify('La date est obligatoire', function () use ($model) {
            $this->assertFalse($model->validate(['date']));
        });
    }
    
    public function testPubliDateIncorrect()
    {
		$model = new Publication([
		'reference' => 'C3PO',
		'auteurs' => 'un auteur',
		'titre' => 'Au bord de l\'autoroute',
		'date' => '10-10-2014',
		'categorie_id' => 1,
            
        ]);

        $this->specify('Le champ date doit être une date au format yyyy-mm-dd', function () use ($model) {
            $this->assertFalse($model->validate(['date']));
        });
    }
    
    public function testPubliChampNul()
    {
		$model = new Publication([
		'reference' => 'H42',
		'auteurs' => 'un auteur',
		'date' => '2014-05-12',
		'categorie_id' => 1,
		'journal' => null,
            
        ]);

        $this->specify('Mis à part "reference, auteurs, date, categorie_id", les autre champs peuvent être nuls', function () use ($model) {
            $this->assertTrue($model->validate(['journal', 'volume', 'number', 'pages', 'note', 'abstract', 'keywords',
            'series', 'localite', 'publisher', 'editor', 'pdf', 'date_display']));
        });
    }
    
    public function testUplaodBibtexNull()
    {
		$bib = new Bibtex();
		$fichier = $bib->Bibtex;
		$this->assertEquals(PublicationController::uploadBibtex($fichier), false);
    }

}
