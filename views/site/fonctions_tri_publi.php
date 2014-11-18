<?php

use yii\helpers\Html;
use app\models\Rubrique;
use yii\helpers\Url;
use app\models\Publication;
use app\models\Categorie;

function getCategories()
{
	$list = Categorie::find()->all();
	
	return $list;
}

function getAnnees()
{
	$list = Publication::find()->orderBy(['date' => SORT_DESC])->all();
	$annee = array();
	foreach($list as $publi)
	{
		$t = $publi->date;
		$t = substr($t,0,4);
		$annee[] = $t;
	}
	$tabSansDoublon= array();
	foreach ($annee as $dates) 
	{
	   if (!in_array($dates, $tabSansDoublon))
	   {
		$tabSansDoublon[]=$dates;
	   }
	}

	return $tabSansDoublon;
	
}

function getPubliByCateg($idCateg)
{
	$list = Publication::find()->where(['categorie_id' => $idCateg])->orderBy(['categorie_id' => SORT_DESC])->all();
	return $list;
}

function getPubliByAnnee($annee)
{

	$list = Publication::find()->where(['like', 'date', $annee])->orderBy(['date' => SORT_DESC])->all();
	return $list;
}

function triPubliParCategorie($rs)
{
	$categories = getCategories();
	$publiByCateg= array();
	foreach ($categories as $c)
	{
		echo"<tr><td align='left' style='vertical-align: top;'>";
		echo"<div class='publications-section' style='position: relative; overflow: hidden;'>";
		echo"<div class='publications-section-title'>".$c->name_fr."</div></div></td></tr>";
		$publiByCateg = getPubliByCateg($c->ID);
		foreach($publiByCateg as $publication)
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
	}
}

function triPubliParDate($rs)
{
	$annees = GetAnnees();
	$publiByCateg= array();
	foreach ($annees as $a)
	{
		echo"<tr><td align='left' style='vertical-align: top;'>";
		echo"<div class='publications-section' style='position: relative; overflow: hidden;'>";
		echo"<div class='publications-section-title'>".$a."</div></div></td></tr>";
		$publiByAnnee = getPubliByAnnee($a);
		foreach($publiByAnnee as $publication)
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
	}
	
	
}

?>