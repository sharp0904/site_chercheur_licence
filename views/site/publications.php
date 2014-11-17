<?php

use yii\helpers\Html;
use app\models\Rubrique;
use yii\helpers\Url;
use app\models\Publication;
use app\models\Categorie;

include('fonctions_tri_publi.php');

$session = Yii::$app->session;
if (isset($_GET["locale"])) {
    $session->set('language', $_GET["locale"]);
}

$language = $session->get('language');





function getPublications()
{
$list = Publication::find()->orderBy(['categorie_id' => SORT_DESC])->all();
return $list;
}

$rs = getPublications();

/* @var $this yii\web\View */
$this->title = 'Site enseignant chercheur';

?>
<div class="site-index">
<a href="?r=site/index&locale=fr"><img src="images/flag-fr.png" /></a> 
<a href="?r=site/index&locale=en"><img src="images/flag-en.png" /></a> 
</br></br></br>
<table cellspacing="0" cellpadding="0" style="width: 90%;background-color:white;">
<tbody><tr>
<?php
triPubliParCategorie($rs);
?>
<td align="left" style="vertical-align: top;">
<table cellspacing="0" cellpadding="0" class="publications-items" style="width: 100%;">
<?php 

?></table></table>
</div>
</div>

</div>
