<?php

use yii\helpers\Html;
use app\models\Rubrique;
use yii\helpers\Url;
use app\models\Publication;
use app\models\Categorie;
use yii\jui\Dialog;
use app\librairies\FonctionsPublications;

include('fonctions_tri_publi.php');


$session = Yii::$app->session;
if (isset($_GET["locale"])) {
    $session->set('language', $_GET["locale"]);
}

$language = $session->get('language');





$tex = "";

if (isset($_GET["tri"])) {
    if($_GET['tri'] == 'cat')
	{
		$tri = 'cat';
	}
	elseif($_GET['tri'] == 'date')
	{
		$tri = 'date';
	}
	else
	{
		$tri = 'cat';
	}
}
else
{
	$tri = 'cat';
}



/* @var $this yii\web\View */
$this->title = 'Site enseignant chercheur';

?>

<div class="site-index">
<a href="?r=site/publications&tri=date"><img src="images/icon-sort-date.png" /></a> 
<a href="?r=site/publications&tri=cat"><img src="images/icon-sort.png" /></a> 
</br></br>

<?php

	if($tri == 'cat')
	{
		try{
		triPubliParCategorie($language);
		}
	catch(Exception $e)
	{
		echo("Aucune publication");
	}
	}
	elseif($tri== 'date')
	{

		try{
		triPubliParDate();
		}
	catch(Exception $e)
	{
		echo("Aucune publication");
	}

	}
	else
	{
	echo 'veuillez choisir une méthode de tri des publications';
	}

?>
</div></div>
<?php Dialog::begin([
	'id' => 'dial-tex',
    'clientOptions' => [
		'title'=>'BibTeX',
		'autoOpen'=>false,
		'modal'=>true,
		'width' => 'auto',
		'height' => 'auto',
		'show' => 'blind',
		'hide' => 'blind',
    ],
]);
Dialog::end();
?>

<?php
Dialog::begin([
	'id' => 'detail-publi',
    'clientOptions' => [
		'title'=>'Détails',
		'autoOpen'=>false,
		'modal'=>true,
		'width' => 'auto',
		'height' => 'auto',
		'show' => 'blind',
		'hide' => 'blind',
    ],
]);
Dialog::end();   ?>


