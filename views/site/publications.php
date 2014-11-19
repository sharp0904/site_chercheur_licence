<?php

use yii\helpers\Html;
use app\models\Rubrique;
use yii\helpers\Url;
use app\models\Publication;
use app\models\Categorie;
use yii\jui\Dialog;


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

function getCategorie($id)
{
$cat= Categorie::find()->where(['ID' => $id])->one();
return $cat->name_en;
}


$rs = getPublications();
$tex = "";

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
echo "<div><span class='publi-ref'>".$publication->reference."</span>";
echo"<span class='publi-authors'>".$publication->auteurs."</span>, ";
echo"<span class='publi-titre'>".$publication->titre."</span>, ";
echo"<span class='publi-cat' type ='hidden'>".getCategorie($publication->categorie_id)."</span>, ";


$tex = '$("#dial-tex").text("");$("#dial-tex").html("@"+$(this).parent().parent().parent().find(".publi-cat").html() +"{");'; 
$tex .= '$("#dial-tex").append($(this).parent().parent().parent().find(".publi-ref").html() +"<br/>");';
$tex .= '$("#dial-tex").append("Authors = {" +$(this).parent().parent().parent().find(".publi-authors").html() +"}<br/>");';
$tex .= '$("#dial-tex").append("Title = {" +$(this).parent().parent().parent().find(".publi-titre").html() +"}<br/>");'; 

if($publication->journal != null)
{
echo"<span class='publi-journal'>".$publication->journal."</span>, ";
$tex .= '$("#dial-tex").append("Journal = {" +$(this).parent().parent().parent().find(".publi-journal").html() +"}<br/>");'; 

}
if($publication->volume != null)
{
echo"<span class='publi-volume'>".$publication->volume."</span>, ";
$tex .= '$("#dial-tex").append("Volume = {" +$(this).parent().parent().parent().find(".publi-volume").html() +"}<br/>");'; 
}
if($publication->number != null)
{
echo"<span class='publi-number'>".$publication->number."</span>, ";
$tex .= '$("#dial-tex").append("Number = {" +$(this).parent().parent().parent().find(".publi-number").html() +"}<br/>");'; 

}
if($publication->pages != null)
{
echo"<span class='publi-pages'>".$publication->pages."</span>, ";
$tex .= '$("#dial-tex").append("Pages = {" +$(this).parent().parent().parent().find(".publi-pages").html() +"}<br/>");'; 

}
if($publication->editor != null)
{
echo"<span class='publi-editor'>".$publication->editor."</span>, ";
$tex .= '$("#dial-tex").append("Editor = {" +$(this).parent().parent().parent().find(".publi-editor").html() +"}<br/>");'; 

}

if($publication->series != null)
{
echo"<span class='publi-series'>".$publication->series."</span>, ";
$tex .= '$("#dial-tex").append("Series = {" +$(this).parent().parent().parent().find(".publi-series").html() +"}<br/>");'; 

}
if($publication->localite != null)
{
echo"<span class='publi-localite'>".$publication->localite."</span>, ";
$tex .= '$("#dial-tex").append("Localite = {" +$(this).parent().parent().parent().find(".publi-localite").html() +"}<br/>");'; 

}
if($publication->publisher != null)
{
echo"<span class='publi-publisher'>".$publication->publisher."</span>, ";
$tex .= '$("#dial-tex").append("Publisher = {" +$(this).parent().parent().parent().find(".publi-publisher").html() +"}<br/>");'; 

}
if($publication->note != null)
{
echo"<span class='publi-note'>".$publication->note."</span>, ";
$tex .= '$("#dial-tex").append("Note = {" +$(this).parent().parent().parent().find(".publi-note").html() +"}<br/>");'; 

}
if($publication->abstract != null)
{
echo"<span class='publi-abstract'>".$publication->abstract."</span><br> ";
$tex .= '$("#dial-tex").append("Abstract = {" +$(this).parent().parent().parent().find(".publi-abstract").html() +"}<br/>");'; 

}
if($publication->keywords != null)
{
echo"<span class='publi-keywords'>".$publication->keywords."</span>, ";
$tex .= '$("#dial-tex").append("Keywords = {" +$(this).parent().parent().parent().find(".publi-keywords").html() +"}<br/>");'; 

}


if($publication->pdf != null)
{
echo"<tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0'>";
echo"<tbody><tr><td align='left' style='vertical-align: top;'>";
echo"<img src='images/icon-tex.png' class='cursor-pointer'></td>";
echo"<td align='left' style='vertical-align: top;'><a href='uploads/".$publication->pdf.".pdf'><img border='0' src='images/icon-pdf.png' alt='Download PDF'></a></td>";
}
echo '<br/>';
echo Html::a('BibTeX', '#', array(
   'onclick'=>$tex.'$("#dial-tex").append(",}");$("#dial-tex").dialog("open"); return false', 
));
echo"</div></div></td></tr>";


echo"</table></td></tr></tbody>";


echo"</table></td></tr><tr><td align='left' style='vertical-align: top;'>";

}


?></table></table>
<?php Dialog::begin([
	'id' => 'dial-tex',
    'clientOptions' => [
		'title'=>'BibTeX',
		'autoOpen'=>false,
		'modal'=>true,
		'width' => 'auto',
		'height' => 'auto',
    ],
]);


Dialog::end();   ?>

</div>
</div>
