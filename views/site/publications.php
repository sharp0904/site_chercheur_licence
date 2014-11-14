<?php

use yii\helpers\Html;
use app\models\Rubrique;
use yii\helpers\Url;
use app\models\Publication;


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

/* @var $this yii\web\View */
$this->title = 'Site enseignant chercheur';

?>
<div class="site-index">
<a href="?r=site/index&locale=fr"><img src="images/flag-fr.png" /></a> 
<a href="?r=site/index&locale=en"><img src="images/flag-en.png" /></a> 
</br></br></br>
<table cellspacing="0" cellpadding="0" style="width: 90%;background-color:white;">
<tbody><tr>
<td align="left" style="vertical-align: top;">
<div class="publications-section" style="position: relative; overflow: hidden;">
<div class="publications-section-title">Journaux Nationaux et Internationaux</div>
</td></tr><tr>
<td align="left" style="vertical-align: top;">
<table cellspacing="0" cellpadding="0" class="publications-items" style="width: 100%;">
<?php 
foreach($rs as $publication)
{
echo"<tbody><tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0' class='publications-item'>";
echo"<tbody><tr><td align='left' style='vertical-align: top;'><div class='gwt-HTML' style='white-space: normal;'>";
echo "<div><span class='publi-ref'>[".$publication->reference."]</span>";
echo"<span class='publi-authors'>".$publication->auteurs."</span>, ";
echo"<span class='publi-titre'>".$publication->titre."</span>, ";
if($publication->journal != null)
{
echo"<span class='publi-booktitle'>".$publication->journal."</span>, ";
}
if($publication->volume != null)
{
echo"<span class='publi-volume'>".$publication->volume."</span>, ";
}
if($publication->number != null)
{
echo"<span class='publi-number'>".$publication->number."</span>, ";
}
if($publication->pages != null)
{
echo"<span class='publi-pages'>".$publication->pages."</span>, ";
}
if($publication->editor != null)
{
echo"<span class='publi-editor'>".$publication->editor."</span>, ";
}

if($publication->series != null)
{
echo"<span class='publi-series'>".$publication->series."</span>, ";
}
if($publication->localite != null)
{
echo"<span class='publi-localite'>".$publication->localite."</span>, ";
}
if($publication->publisher != null)
{
echo"<span class='publi-publisher'>".$publication->publisher."</span>, ";
}
if($publication->note != null)
{
echo"<span class='publi-note'>".$publication->note."</span>, ";
}
if($publication->abstract != null)
{
echo"<span class='publi-abstract'>".$publication->abstract."</span><br> ";
}
if($publication->keywords != null)
{
echo"<span class='publi-keywords'>".$publication->keywords."</span>, ";
}
if($publication->pdf != null)
{
echo"<tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0'>";
echo"<tbody><tr><td align='left' style='vertical-align: top;'>";
echo"<img src='images/icon-tex.png' class='cursor-pointer'></td>";
echo"<td align='left' style='vertical-align: top;'><a href='uploads/".$publication->pdf.".pdf'><img border='0' src='images/icon-pdf.png' alt='Download PDF'></a></td>";
}
echo"</div></div></td></tr>";

echo"</table></td></tr></tbody>";
echo"</table></td></tr><tr><td align='left' style='vertical-align: top;'>";
}
?></table></table>
</div>
</div>

</div>
