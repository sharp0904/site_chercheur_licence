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
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     */
    public function testUploadBibtexTableauVide()
    {
		$bib = new Bibtex();
		$fichier = $bib->Bibtex;
		PublicationController::uploadBibtex($fichier);
    }
    
	/**
     * @expectedException yii\web\NotFoundHttpException
     */
    public function testMappingBibtexAvecTableauNull()
    {
		$tab = null;
		PublicationController::mappingBibtex($tab);
    }
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     */
    public function testMappingBibtexSansTitre()
    {
		$tab = array('cite' => 'S1NG', 'author' => '{De La Soul}');
		PublicationController::mappingBibtex($tab);
    }
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     */
    public function testMappingBibtexTitreNull()
    {
		$tab = array('cite' => 'S1NG', 'author' => '{De La Soul}', 'titre' => null);
		PublicationController::mappingBibtex($tab);
    }
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     */
    public function testMappingBibtexSansAuteur()
    {
		$tab = array('cite' => 'S1NG', 'title' => '{Me, Myself and I}');
		PublicationController::mappingBibtex($tab);
    }
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     */
    public function testMappingBibtexAuteurNull()
    {
		$tab = array('cite' => 'S1NG', 'title' => '{Me, Myself and I}', 'author' => null);
		PublicationController::mappingBibtex($tab);
    }
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     */
    public function testMappingBibtexSansCite()
    {
		$tab = array('title' => '{Me, Myself and I}', 'author' => '{De La Soul}');
		PublicationController::mappingBibtex($tab);
    }
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     */
    public function testMappingBibtexCiteNull()
    {
		$tab = array('title' => '{Me, Myself and I}', 'author' => '{De La Soul}', 'cite' => null);
		PublicationController::mappingBibtex($tab);
    }
    
    public function testMappingBibtexAvecCleYearNonPresente()
    {
		$tab = array('cite' => 'S1NG', 'title' => '{Me, Myself and I}', 'author' => '{De La Soul}');
		$publiController = PublicationController::mappingBibtex($tab);
		$this->assertEquals(date('Y')."-01-01", $publiController->date);
    }
    
    public function testMappingBibtexCleYearNull()
    {
		$tab = array('cite' => 'S1NG', 'title' => '{Me, Myself and I}', 'author' => '{De La Soul}', 'year' => null);
		$publiController = PublicationController::mappingBibtex($tab);
		$this->assertEquals(date('Y')."-01-01", $publiController->date);
    }
    
    public function testMappingBibtexCleYearSansMois()
    {
		$tab = array('cite' => 'S1NG', 'title' => '{Me, Myself and I}', 'author' => '{De La Soul}', 'year' => '{2013}');
		$publiController = PublicationController::mappingBibtex($tab);
		$this->assertEquals( "2013-01-01", $publiController->date);
    }
    
    public function testMappingBibtexCleYearAvecMois()
    {
		$tab = array('cite' => 'S1NG', 'title' => '{Me, Myself and I}', 'author' => '{De La Soul}', 'year' => '{2013}', 'month' => '{05}');
		$publiController = PublicationController::mappingBibtex($tab);
		$this->assertEquals( "2013-05-01", $publiController->date);
    }
    
    public function testMappingBibtexCleYearString()
    {
		$tab = array('cite' => 'S1NG', 'title' => '{Me, Myself and I}', 'author' => '{De La Soul}', 'year' => '{old}');
		$publiController = PublicationController::mappingBibtex($tab);
		$this->assertEquals( date('Y')."-01-01", $publiController->date);
    }
    
    public function testMappingBibtexCleMonthString()
    {
		$tab = array('cite' => 'S1NG', 'title' => '{Me, Myself and I}', 'author' => '{De La Soul}', 'year' => '{2012}', 'month' => '{school}');
		$publiController = PublicationController::mappingBibtex($tab);
		$this->assertEquals( "2012-01-01", $publiController->date);
    }
    
    public function testMappingBibtexCleYearVide()
    {
		$tab = array('cite' => 'S1NG', 'title' => '{Me, Myself and I}', 'author' => '{De La Soul}', 'year' => '{}');
		$publiController = PublicationController::mappingBibtex($tab);
		$this->assertEquals( date('Y')."-01-01", $publiController->date);
    }
    
    public function testMappingBibtexCleMonthVide()
    {
		$tab = array('cite' => 'S1NG', 'title' => '{Me, Myself and I}', 'author' => '{De La Soul}', 'year' => '{2011}', 'month' => '{}');
		$publiController = PublicationController::mappingBibtex($tab);
		$this->assertEquals( "2011-01-01", $publiController->date);
    }
    
    /**
     * @expectedException yii\web\NotFoundHttpException
     * @expectedExceptionMessage The requested page does not exist.
     */
    public function testFindModelNonExistant()
    {
		$publiController = PublicationController::findModel(1);
	}
	
	public function testFindModelOK()
    {
		$model = new Publication([
		'reference' => 'C3PO',
		'titre' => 'un titre',
		'auteurs' => 'un auteur',
		'date' => '2014-05-12',
		'categorie_id' => 1,
            
        ]);
        $model->save();
		$publiController = PublicationController::findModel($model->ID);
	}
	
	public function testDeleteMulti()
	{
		PublicationController::actionDeletemulti();
	}

}
