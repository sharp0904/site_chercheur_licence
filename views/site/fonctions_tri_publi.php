<?php

use yii\helpers\Html;
use app\models\Rubrique;
use yii\helpers\Url;
use app\models\Publication;
use app\models\Categorie;
use app\librairies\FonctionsCurl;
use app\librairies\FonctionsCategories;
use app\librairies\FonctionsPublications;



function getCategories()
{
	$list = json_decode(FonctionsCurl::getAllCategories(),true);
	return $list;
}

function getCategoriePubli($id)
{

	$cat= FonctionsPublications::getCategParId($id);
	return $cat->name_en;
}


function getAnnees()
{
	$publications = FonctionsPublications::getPublicationParDate();
	$annee = array();
	foreach($publications as $publi)
		{
			array_push($annee,substr($publi['date'], 0, 4));
		}
	$annee=array_unique($annee);
	return $annee;
	
}

function getPubliByCateg($idCateg)
{
	$list = FonctionsPublications::getPublicationParCategorie($idCateg);
	return $list;
}

function getPubliByAnnee($annee)
{

	$list = FonctionsPublications::getPublicationParAnnee($annee);
	return $list;
}

function triPubliParCategorie($rs)
{
	$categories = getCategories();
	$publiByCateg= array();
	$detail = "";
	foreach ($categories as $c)
	{
		echo"<div class='publications-section' style='position: relative; overflow: hidden;'>";
		echo"<div class='publications-section-title'>".$c['name_fr']."</div></div></td></tr>";
		$publiByCateg = getPubliByCateg($c['ID']);
		foreach($publiByCateg as $publication)
		{
			echo"<tbody><tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0' class='publications-item'>";
			echo"<tbody><tr><td align='left' style='vertical-align: top;'><div class='gwt-HTML' style='white-space: normal;'>";
			echo "<div>[<span class='publi-ref'>".$publication['reference']."</span>]";
			echo"<span class='publi-authors'> ".$publication['auteurs']." </span>, ";
			echo"<span class='publi-titre'> ".$publication['titre']." </span>";
			echo"<span class='publi-cat'>".getCategoriePubli($publication['categorie_id'])."</span>, ";
			echo"<span class='publi-year' type ='hidden'>".substr($publication['date'], 0, 4)."</span>, ";
			echo"<span class='publi-month' type ='hidden'>".substr($publication['date'], 5, 2)."</span>, ";
			
			$tex = '$("#dial-tex").text("");$("#dial-tex").html("@"+$(this).parent().parent().parent().find(".publi-cat").html() +"{");'; 
			$tex .= '$("#dial-tex").append($(this).parent().parent().parent().find(".publi-ref").html() +",<br/>");';
			$tex .= '$("#dial-tex").append("Author = {" +$(this).parent().parent().parent().find(".publi-authors").html() +"},<br/>");';
			$tex .= '$("#dial-tex").append("Title = {" +$(this).parent().parent().parent().find(".publi-titre").html() +"},<br/>");'; 
			$tex .= '$("#dial-tex").append("Year = {" +$(this).parent().parent().parent().find(".publi-year").html() +"},<br/>");'; 
			$tex .= '$("#dial-tex").append("Month = {" +$(this).parent().parent().parent().find(".publi-month").html() +"},<br/>");'; 
			
			$detail = '$("#detail-publi").append("<div id = \'titre-content-popup\'>Référence: </div>"+$(this).parent().parent().parent().find(".publi-ref").html());';
			$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Auteurs: </div>"+$(this).parent().parent().parent().find(".publi-authors").html());';
			$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Titre: </div>"+$(this).parent().parent().parent().find(".publi-titre").html());';

			if($publication['journal'] != null)
			{
				echo"<span class='publi-journal'>".$publication['journal']."</span>, ";
				if($publication['categorie_id'] == 1){
					$tex .= '$("#dial-tex").append("Journal = {" +$(this).parent().parent().parent().find(".publi-journal").html() +"},<br/>");';
					$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Titre du journal: </div>"+$(this).parent().parent().parent().find(".publi-journal").html());';
				} 
				elseif($publication['categorie_id'] == 2){
					$tex .= '$("#dial-tex").append("Booktitle = {" +$(this).parent().parent().parent().find(".publi-journal").html() +"},<br/>");';
					$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Titre du livre: </div>"+$(this).parent().parent().parent().find(".publi-journal").html());';
				}
			}
			if($publication['publisher'] != null)
			{
				echo"<span class='publi-publisher'>".$publication['publisher']."</span>, ";
				$tex .= '$("#dial-tex").append("Publisher = {" +$(this).parent().parent().parent().find(".publi-publisher").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Maison d\'édition: </div>"+$(this).parent().parent().parent().find(".publi-publisher").html());';
			}
			if($publication['volume'] != null)
			{
				echo"<span class='publi-volume'>".$publication['volume']."</span>, ";
				$tex .= '$("#dial-tex").append("Volume = {" +$(this).parent().parent().parent().find(".publi-volume").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Volume: </div>"+$(this).parent().parent().parent().find(".publi-volume").html());';
			}
			if($publication['number'] != null)
			{
				echo"<span class='publi-number'>".$publication['number']."</span>, ";
				$tex .= '$("#dial-tex").append("Number = {" +$(this).parent().parent().parent().find(".publi-number").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Numéro: </div>"+$(this).parent().parent().parent().find(".publi-number").html());';
			}
			if($publication['pages'] != null)
			{
				echo"<span class='publi-pages'>".$publication['pages']."</span>, ";
				$tex .= '$("#dial-tex").append("Pages = {" +$(this).parent().parent().parent().find(".publi-pages").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Page(s): </div>"+$(this).parent().parent().parent().find(".publi-pages").html());';
			}
			if($publication['editor'] != null)
			{
				echo"<span class='publi-editor'>".$publication['editor']."</span>, ";
				$tex .= '$("#dial-tex").append("Editor = {" +$(this).parent().parent().parent().find(".publi-editor").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Editeur: </div>"+$(this).parent().parent().parent().find(".publi-editor").html());';
			}

			if($publication['series'] != null)
			{
				echo"<span class='publi-series'>".$publication['series']."</span>, ";
				$tex .= '$("#dial-tex").append("Series = {" +$(this).parent().parent().parent().find(".publi-series").html() +"},<br/>");';
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Serie: </div>"+$(this).parent().parent().parent().find(".publi-series").html());'; 
			}
			if($publication['localite'] != null)
			{
				echo"<span class='publi-localite'>".$publication['localite']."</span>, ";
				$tex .= '$("#dial-tex").append("Address = {" +$(this).parent().parent().parent().find(".publi-localite").html() +"},<br/>");';
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Adresse: </div>"+$(this).parent().parent().parent().find(".publi-localite").html());'; 
			}
			
			if($publication['note'] != null)
			{
				echo"<div class='publi-note'><br/>".$publication['note']."</div>, ";
				$tex .= '$("#dial-tex").append("Note = {" +$(this).parent().parent().parent().find(".publi-note").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Note: </div>"+$(this).parent().parent().parent().find(".publi-note").html());'; 
			}
			if($publication['abstract'] != null)
			{
				echo"<span class='publi-abstract'>".$publication['abstract']."</span><br> ";
				$tex .= '$("#dial-tex").append("Abstract = {" +$(this).parent().parent().parent().find(".publi-abstract").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Résumé: </div>"+$(this).parent().parent().parent().find(".publi-abstract").html());';
			}
			if($publication['keywords'] != null)
			{
				echo"<span class='publi-keywords'>Mots clefs : ".$publication['keywords']."</span>, ";
				$tex .= '$("#dial-tex").append("Keywords = {" +$(this).parent().parent().parent().find(".publi-keywords").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Mots-clés: </div>"+$(this).parent().parent().parent().find(".publi-keywords").html());';
			}
			echo '<br/>';
			if($publication['pdf'] != null)
			{
				echo"<tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0'>";
				echo"<tbody><tr><td align='left' style='vertical-align: top;'>";
				echo"</td>";
				echo"<td align='left' style='vertical-align: top;'><a href='uploads/".$publication['pdf'].".pdf'><img border='0' src='images/icon-pdf.png' alt='Download PDF'></a></td>";
			}
			echo Html::a('Détails de la publication', '#', array(
						   'onclick'=>'$("#detail-publi").text("");'.$detail.'$("#detail-publi").dialog("open"); return false', 
			));
			echo Html::a('<img src="images/icon-tex.png" class="cursor-pointer">', '#', array(
			   'onclick'=>$tex.'$("#dial-tex").append(",}");$("#dial-tex").dialog("open"); return false', 
));
			
				echo"</td></div></div></td></tr>";
				echo"</table></td></tr></tbody>";
				echo"</table></td></tr><tr><td align='left' style='vertical-align: top;'><br/>";
			}
	}
}

function triPubliParDate($rs)
{
	$annees = GetAnnees();
	$publiByCateg= array();
	$detail = "";
	foreach ($annees as $a)
	{
		echo"<div class='publications-section' style='position: relative; overflow: hidden;'>";
		echo"<div class='publications-section-title'>".$a."</div></div></td></tr>";
		$publiByAnnee = getPubliByAnnee($a);
		foreach($publiByAnnee as $publication)
		{
		
			echo"<tbody><tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0' class='publications-item'>";
			echo"<tbody><tr><td align='left' style='vertical-align: top;'><div class='gwt-HTML' style='white-space: normal;'>";
			echo "<div>[<span class='publi-ref'>".$publication['reference']."</span>]";
			echo"<span class='publi-authors'> ".$publication['auteurs']." </span>, ";
			echo"<span class='publi-titre'> ".$publication['titre']." </span>";
			echo"<span class='publi-cat'>".getCategoriePubli($publication['categorie_id'])."</span>, ";
			echo"<span class='publi-year' type ='hidden'>".substr($publication['date'], 0, 4)."</span>, ";
			echo"<span class='publi-month' type ='hidden'>".substr($publication['date'], 5, 2)."</span>, ";
			
			$tex = '$("#dial-tex").text("");$("#dial-tex").html("@"+$(this).parent().parent().parent().find(".publi-cat").html() +"{");'; 
			$tex .= '$("#dial-tex").append($(this).parent().parent().parent().find(".publi-ref").html() +",<br/>");';
			$tex .= '$("#dial-tex").append("Author = {" +$(this).parent().parent().parent().find(".publi-authors").html() +"},<br/>");';
			$tex .= '$("#dial-tex").append("Title = {" +$(this).parent().parent().parent().find(".publi-titre").html() +"},<br/>");'; 
			$tex .= '$("#dial-tex").append("Year = {" +$(this).parent().parent().parent().find(".publi-year").html() +"},<br/>");'; 
			$tex .= '$("#dial-tex").append("Month = {" +$(this).parent().parent().parent().find(".publi-month").html() +"},<br/>");'; 
			
			$detail = '$("#detail-publi").append("<div id = \'titre-content-popup\'>Référence: </div>"+$(this).parent().parent().parent().find(".publi-ref").html());';
			$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Auteurs: </div>"+$(this).parent().parent().parent().find(".publi-authors").html());';
			$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Titre: </div>"+$(this).parent().parent().parent().find(".publi-titre").html());';

			if($publication['journal'] != null)
			{
				echo"<span class='publi-journal'>".$publication['journal']."</span>, ";
				if($publication['categorie_id'] == 1){
					$tex .= '$("#dial-tex").append("Journal = {" +$(this).parent().parent().parent().find(".publi-journal").html() +"},<br/>");';
					$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Titre du journal: </div>"+$(this).parent().parent().parent().find(".publi-journal").html());';
				} 
				elseif($publication['categorie_id'] == 2){
					$tex .= '$("#dial-tex").append("Booktitle = {" +$(this).parent().parent().parent().find(".publi-journal").html() +"},<br/>");';
					$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Titre du livre: </div>"+$(this).parent().parent().parent().find(".publi-journal").html());';
				}
			}
			if($publication['publisher'] != null)
			{
				echo"<span class='publi-publisher'>".$publication['publisher']."</span>, ";
				$tex .= '$("#dial-tex").append("Publisher = {" +$(this).parent().parent().parent().find(".publi-publisher").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Maison d\'édition: </div>"+$(this).parent().parent().parent().find(".publi-publisher").html());';
			}
			if($publication['volume'] != null)
			{
				echo"<span class='publi-volume'>".$publication['volume']."</span>, ";
				$tex .= '$("#dial-tex").append("Volume = {" +$(this).parent().parent().parent().find(".publi-volume").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Volume: </div>"+$(this).parent().parent().parent().find(".publi-volume").html());';
			}
			if($publication['number'] != null)
			{
				echo"<span class='publi-number'>".$publication['number']."</span>, ";
				$tex .= '$("#dial-tex").append("Number = {" +$(this).parent().parent().parent().find(".publi-number").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Numéro: </div>"+$(this).parent().parent().parent().find(".publi-number").html());';
			}
			if($publication['pages'] != null)
			{
				echo"<span class='publi-pages'>".$publication['pages']."</span>, ";
				$tex .= '$("#dial-tex").append("Pages = {" +$(this).parent().parent().parent().find(".publi-pages").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Page(s): </div>"+$(this).parent().parent().parent().find(".publi-pages").html());';
			}
			if($publication['editor'] != null)
			{
				echo"<span class='publi-editor'>".$publication['editor']."</span>, ";
				$tex .= '$("#dial-tex").append("Editor = {" +$(this).parent().parent().parent().find(".publi-editor").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Editeur: </div>"+$(this).parent().parent().parent().find(".publi-editor").html());';
			}

			if($publication['series'] != null)
			{
				echo"<span class='publi-series'>".$publication['series']."</span>, ";
				$tex .= '$("#dial-tex").append("Series = {" +$(this).parent().parent().parent().find(".publi-series").html() +"},<br/>");';
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Serie: </div>"+$(this).parent().parent().parent().find(".publi-series").html());'; 
			}
			if($publication['localite'] != null)
			{
				echo"<span class='publi-localite'>".$publication['localite']."</span>, ";
				$tex .= '$("#dial-tex").append("Address = {" +$(this).parent().parent().parent().find(".publi-localite").html() +"},<br/>");';
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Adresse: </div>"+$(this).parent().parent().parent().find(".publi-localite").html());'; 
			}
			
			if($publication['note'] != null)
			{
				echo"<div class='publi-note'><br/>".$publication['note']."</div>, ";
				$tex .= '$("#dial-tex").append("Note = {" +$(this).parent().parent().parent().find(".publi-note").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Note: </div>"+$(this).parent().parent().parent().find(".publi-note").html());'; 
			}
			if($publication['abstract'] != null)
			{
				echo"<span class='publi-abstract'>".$publication['abstract']."</span><br> ";
				$tex .= '$("#dial-tex").append("Abstract = {" +$(this).parent().parent().parent().find(".publi-abstract").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Résumé: </div>"+$(this).parent().parent().parent().find(".publi-abstract").html());';
			}
			if($publication['keywords'] != null)
			{
				echo"<span class='publi-keywords'>Mots clefs : ".$publication['keywords']."</span>, ";
				$tex .= '$("#dial-tex").append("Keywords = {" +$(this).parent().parent().parent().find(".publi-keywords").html() +"},<br/>");'; 
				$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Mots-clés: </div>"+$(this).parent().parent().parent().find(".publi-keywords").html());';
			}
			echo '<br/>';
			if($publication['pdf'] != null)
			{
				echo"<tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0'>";
				echo"<tbody><tr><td align='left' style='vertical-align: top;'>";
				echo"</td>";
				echo"<td align='left' style='vertical-align: top;'><a href='uploads/".$publication['pdf'].".pdf'><img border='0' src='images/icon-pdf.png' alt='Download PDF'></a></td>";
			}
			echo Html::a('Détails de la publication', '#', array(
						   'onclick'=>'$("#detail-publi").text("");'.$detail.'$("#detail-publi").dialog("open"); return false', 
			));
			echo Html::a('<img src="images/icon-tex.png" class="cursor-pointer">', '#', array(
			   'onclick'=>$tex.'$("#dial-tex").append(",}");$("#dial-tex").dialog("open"); return false', 
));
			
				echo"</td></div></div></td></tr>";
				echo"</table></td></tr></tbody>";
				echo"</table></td></tr><tr><td align='left' style='vertical-align: top;'><br/>";
			}
	}
}
?>
