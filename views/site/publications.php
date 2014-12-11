<?php

use yii\helpers\Html;
use app\models\Rubrique;
use yii\helpers\Url;
use app\models\Publication;
use app\models\Categorie;
use yii\jui\Dialog;


include('fonctions_tri_publi.php');

$session = Yii::$app->session;
if (isset($_GET["locale"])) {
    $session->set('language', $_GET["locale"]);
}

$language = $session->get('language');


function getPublications()
{
	$list = Publication::find()->orderBy(['date' => SORT_DESC])->all();
	return $list;
}


$rs = getPublications();
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
<a href="?r=site/index&locale=fr"><img src="images/flag-fr.png" /></a> 
<a href="?r=site/index&locale=en"><img src="images/flag-en.png" /></a> 
</br>
<a href="?r=site/publications&tri=cat"><img src="images/icon-sort.png" /></a> 
<a href="?r=site/publications&tri=date"><img src="images/icon-sort-date.png" /></a> 
</br></br>
<table cellspacing="0" cellpadding="0" style="width: 90%;background-color:white;">
<tbody><tr>
<?php
if($tri == 'cat')
{
	triPubliParCategorie($rs);
}
elseif($tri== 'date')
{
	triPubliParDate($rs);
}
else
{
echo 'veuillez choisir une méthode de tri des publications';
}
?></tr>
</tbody></table>
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
</div>
</div>

</div>
