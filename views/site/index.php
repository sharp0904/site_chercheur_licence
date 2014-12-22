<?php

use yii\helpers\Html;
use app\models\Rubrique;
use app\models\Menu;
use yii\helpers\Url;
use app\librairies\FonctionsRubriques;

$session = Yii::$app->session;

if (isset($_GET["locale"])) {
    $session->set('language', $_GET["locale"]);
}
if(isset($session['language']))
{
$language = $session->get('language');
}
else
{
    $session->set('language', 'fr');
    $language = $session->get('language');
}


/* @var $this yii\web\View */
$this->title = 'Site enseignant chercheur';

if (isset($_GET["page"])) {
    $idPage = $_GET["page"];
}
$menu = new Menu(['ID' => '108', 'titre_fr' => 'Aucune rubrique', 'titre_en'=> 'No section', 'actif'=>0]);
$rubrique = new Rubrique(['ID'=>'108', 'content_fr'=>'Aucune rubrique', 'content_en'=>"No section"]);

?>
<div class="site-index">
 
</br></br></br>
<div id="maRubrique">
<?php
try{
	$rubrique = FonctionsRubriques::getFirstRubrique();
}
catch(Exception $e)
{
	if($language =='fr')
	{
		echo 'Aucune rubrique';
	}
	else
	{
		echo 'No section';
	}
}
if(isset($idPage))
{
	try{
		
		
		echo(FonctionsRubriques::getContentRubriqueParid($idPage, $language));
		
	}
	catch(Exception $e)
	{
		if(isset($language))
		{
			if($language=='fr')
			{
				echo "page inexistante";
			}
			else
			{
				echo "Not found";
			}
		}
		else
		{
			echo "page inexistante";
		}
	}
}
else
{
	if(isset($language))
	{
	echo(FonctionsRubriques::getContentRubriqueParid($rubrique->menu_id,$language));
	}
	else
	{
	echo(FonctionsRubriques::getContentRubriqueParid($rubrique->menu_id,'fr'));
	}

}

?>   
</div>
</div>
