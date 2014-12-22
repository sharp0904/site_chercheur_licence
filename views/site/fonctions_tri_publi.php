
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



function afficheBibTex($publication)
{
	$tex = '$("#dial-tex").text("");$("#dial-tex").html("@"+$(this).parent().parent().parent().find(".publi-cat").html() +"{");'; 
	$tex .= '$("#dial-tex").append($(this).parent().parent().parent().find(".publi-ref").html() +"<br/>");';
	$tex .= '$("#dial-tex").append("Authors = {" +$(this).parent().parent().parent().find(".publi-authors").html() +"}<br/>");';
	$tex .= '$("#dial-tex").append("Title = {" +$(this).parent().parent().parent().find(".publi-titre").html() +"}<br/>");'; 
	if($publication['journal'] != null)
		{
			if($publication['categorie_id'] == 1){
				$tex .= '$("#dial-tex").append("Journal = {" +$(this).parent().parent().parent().find(".publi-journal").html() +"},<br/>");';
			} 
			elseif($publication['categorie_id'] == 2){
				$tex .= '$("#dial-tex").append("Booktitle = {" +$(this).parent().parent().parent().find(".publi-journal").html() +"},<br/>");';
			}
		}
	if($publication['volume'] != null)
	{
		$tex .= '$("#dial-tex").append("Volume = {" +$(this).parent().parent().parent().find(".publi-volume").html() +"}<br/>");'; 
	}
	if($publication['number'] != null)
	{
		$tex .= '$("#dial-tex").append("Number = {" +$(this).parent().parent().parent().find(".publi-number").html() +"}<br/>");'; 
	}
	if($publication['pages'] != null)
	{
		$tex .= '$("#dial-tex").append("Pages = {" +$(this).parent().parent().parent().find(".publi-pages").html() +"}<br/>");'; 
	}
	if($publication['editor'] != null)
	{
		$tex .= '$("#dial-tex").append("Editor = {" +$(this).parent().parent().parent().find(".publi-editor").html() +"}<br/>");'; 
	}
	if($publication['series'] != null)
	{
		$tex .= '$("#dial-tex").append("Series = {" +$(this).parent().parent().parent().find(".publi-series").html() +"}<br/>");'; 
	}
	if($publication['localite'] != null)
	{
		$tex .= '$("#dial-tex").append("Localite = {" +$(this).parent().parent().parent().find(".publi-localite").html() +"}<br/>");'; 
	}
	if($publication['publisher'] != null)
	{
		$tex .= '$("#dial-tex").append("Publisher = {" +$(this).parent().parent().parent().find(".publi-publisher").html() +"}<br/>");'; 
	}
	if($publication['note'] != null)
	{
		$tex .= '$("#dial-tex").append("Note = {" +$(this).parent().parent().parent().find(".publi-note").html() +"}<br/>");'; 
	}
	if($publication['abstract'] != null)
	{
		$tex .= '$("#dial-tex").append("Abstract = {" +$(this).parent().parent().parent().find(".publi-abstract").html() +"}<br/>");'; 
	}
	if($publication['keywords'] != null)
	{
		$tex .= '$("#dial-tex").append("Keywords = {" +$(this).parent().parent().parent().find(".publi-keywords").html() +"}<br/>");'; 
	}
	return $tex;
}

function afficheDetailPubliFR($publication)
{

	$detail = '$("#detail-publi").append("<div id = \'titre-content-popup\'>Référence: </div>"+$(this).parent().parent().parent().find(".publi-ref").html());';
	$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Auteurs: </div>"+$(this).parent().parent().parent().find(".publi-authors").html());';
	$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Titre: </div>"+$(this).parent().parent().parent().find(".publi-titre").html());';
	if($publication['journal'] != null)
			{
				if($publication['categorie_id'] == 1){
					$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Titre du journal: </div>"+$(this).parent().parent().parent().find(".publi-journal").html());';
				} 
				elseif($publication['categorie_id'] == 2){
					$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Titre du livre: </div>"+$(this).parent().parent().parent().find(".publi-journal").html());';
				}
			}
	if($publication['volume'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Volume: </div>"+$(this).parent().parent().parent().find(".publi-volume").html());';
	}
	if($publication['number'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Numéro: </div>"+$(this).parent().parent().parent().find(".publi-number").html());';

	}
	if($publication['pages'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Pages: </div>"+$(this).parent().parent().parent().find(".publi-pages").html());';

	}
	if($publication['editor'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Editeur: </div>"+$(this).parent().parent().parent().find(".publi-editor").html());';

	}
	if($publication['series'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Serie: </div>"+$(this).parent().parent().parent().find(".publi-series").html());';

	}
	if($publication['localite'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Adresse: </div>"+$(this).parent().parent().parent().find(".publi-localite").html());'; 
	}
	if($publication['publisher'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Maison d\'édition: </div>"+$(this).parent().parent().parent().find(".publi-publisher").html());';

	}
	if($publication['note'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Note: </div>"+$(this).parent().parent().parent().find(".publi-note").html());'; 
	}
	if($publication['abstract'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Résumé: </div>"+$(this).parent().parent().parent().find(".publi-abstract").html());';
	}
	if($publication['keywords'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Mots-clés: </div>"+$(this).parent().parent().parent().find(".publi-keywords").html());';
	}
	return $detail;

}
function afficheDetailPubliEN($publication)
{

	$detail = '$("#detail-publi").append("<div id = \'titre-content-popup\'>Reference: </div>"+$(this).parent().parent().parent().find(".publi-ref").html());';
	$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Authors: </div>"+$(this).parent().parent().parent().find(".publi-authors").html());';
	$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Title: </div>"+$(this).parent().parent().parent().find(".publi-titre").html());';
	if($publication['journal'] != null)
			{
				if($publication['categorie_id'] == 1){
					$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Newstitle: </div>"+$(this).parent().parent().parent().find(".publi-journal").html());';
				} 
				elseif($publication['categorie_id'] == 2){
					$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Booktitle: </div>"+$(this).parent().parent().parent().find(".publi-journal").html());';
				}
			}
	if($publication['volume'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Volume: </div>"+$(this).parent().parent().parent().find(".publi-volume").html());';
	}
	if($publication['number'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Number: </div>"+$(this).parent().parent().parent().find(".publi-number").html());';

	}
	if($publication['pages'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Pages: </div>"+$(this).parent().parent().parent().find(".publi-pages").html());';

	}
	if($publication['editor'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Editor: </div>"+$(this).parent().parent().parent().find(".publi-editor").html());';

	}
	if($publication['series'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Series: </div>"+$(this).parent().parent().parent().find(".publi-series").html());';

	}
	if($publication['localite'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Adress: </div>"+$(this).parent().parent().parent().find(".publi-localite").html());'; 
	}
	if($publication['publisher'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Publisher: </div>"+$(this).parent().parent().parent().find(".publi-publisher").html());';

	}
	if($publication['note'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Note: </div>"+$(this).parent().parent().parent().find(".publi-note").html());'; 
	}
	if($publication['abstract'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Abstract: </div>"+$(this).parent().parent().parent().find(".publi-abstract").html());';
	}
	if($publication['keywords'] != null)
	{
		$detail .= '$("#detail-publi").append("<div id = \'titre-content-popup\'>Keywords: </div>"+$(this).parent().parent().parent().find(".publi-keywords").html());';
	}
	return $detail;

}
function triPubliParCategorie($language)
{
	$categories = getCategories();
	$publiByCateg= array();
	echo"<div class='systeme_onglets'>";
	echo"<div class='onglets'>";
	foreach ($categories as $c)
	{
		if($language=='fr')
		{
			$name = $c['name_fr'];
		}
		else
		{
			$name=$c['name_en'];
		}
		?>
	<span class='onglet_0 onglet' id='onglet_<?php echo $name?>' onclick="javascript:change_onglet('<?php echo $name?>');"><?php echo $name?></span>
		<?php
	}
	echo"</div><div class='contenu_onglets'>";
	foreach ($categories as $c)
	{
		if($language=='fr')
		{
			$name = $c['name_fr'];
		}
		else
		{
			$name=$c['name_en'];
		}
		echo"<div class='contenu_onglet' id='contenu_onglet_".$name."'>";

		$publiByCateg = getPubliByCateg($c['ID']);
		foreach($publiByCateg as $publication)
		{
			echo"<tbody><tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0' class='publications-item'>";
			echo"<tbody><tr><td align='left' style='vertical-align: top;'>";
			echo "<div><span class='publi-ref'>[".$publication['reference']."]</span> ";
			echo"<span class='publi-authors'>".$publication['auteurs']."</span>, ";
			echo"<span class='publi-titre'>".$publication['titre']."</span>, ";
			echo"<span class='publi-cat' type ='hidden'>".getCategoriePubli($publication['categorie_id'])."</span>, ";

			if($publication['journal'] != null)
			{
				echo"<span class='publi-journal'>".$publication['journal']."</span>, ";
			}
			if($publication['volume'] != null)
			{
				echo"<span class='publi-volume'>".$publication['volume']."</span>, ";
			}
			if($publication['number'] != null)
			{
				echo"<span class='publi-number'>".$publication['number']."</span>, ";
			}
			if($publication['pages'] != null)
			{
				echo"<span class='publi-pages'>".$publication['pages']."</span>, ";
			}
			if($publication['editor'] != null)
			{
				echo"<span class='publi-editor'>".$publication['editor']."</span>, ";
			}
			if($publication['series'] != null)
			{
				echo"<span class='publi-series'>".$publication['series']."</span>, ";
			}
			if($publication['localite'] != null)
			{
				echo"<span class='publi-localite'>".$publication['localite']."</span>, ";
			}
			if($publication['publisher'] != null)
			{
				echo"<span class='publi-publisher'>".$publication['publisher']."</span>, ";
			}
			if($publication['note'] != null)
			{
				echo"<span class='publi-note' style='display:none'>".$publication['note']."</span>, ";
			}
			if($publication['abstract'] != null)
			{
				echo"<span class='publi-abstract' style='display:none'>".$publication['abstract']."</span><br> ";
			}
			if($publication['keywords'] != null)
			{
				echo"</br>";
				echo"<span class='publi-keywords'>keywords : ".$publication['keywords']."</span>, ";
			}
			if($publication['pdf'] != null)
			{
				echo"<tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0'>";
				echo"<tbody><tr><td align='left' style='vertical-align: top;'>";
				echo"</td>";
				echo"<td align='left' style='vertical-align: top;'><a href='uploads/".$publication['pdf'].".pdf'><img border='0' src='images/icon-pdf.png' alt='Download PDF'></a></td>";
			}
			$tex = afficheBibTex($publication);
			if($language=='fr')
			{
				$detail = afficheDetailPubliFR($publication);
			}
			else
			{
				$detail = afficheDetailPubliEN($publication);
			}
			echo '<br/>';
			echo Html::a('DETAILS', '#', array(
						   'onclick'=>'$("#detail-publi").text("");'.$detail.'$("#detail-publi").dialog("open"); return false', 
			));
			echo Html::a('<img src="images/icon-tex.png" class="cursor-pointer">', '#', array(
			   'onclick'=>$tex.'$("#dial-tex").append(",}");$("#dial-tex").dialog("open"); return false', 
			));
				echo"</td></tr>";
				echo"</table></td></tr></tbody>";
				echo"</table></td></tr><tr><td align='left' style='vertical-align: top;'>";

		}
			echo"</div>";
	}
	echo"</div></div></div>";
	?>
		<script type="text/javascript">
		//<!--
		var anc_onglet = 'Article';
		change_onglet(anc_onglet);
		//-->
		</script>

	<?php
}

function triPubliParDate()
{
	$annees = GetAnnees();
	$publiByCateg= array();
	$detail = "";

	foreach ($annees as $a)
	{
		
		echo"<div class='publications-section-title'>".$a;
		echo"<span style='margin-right:10%'>+</span></div></td></tr>";
		echo"<div class='publications-section'>";
		$publiByAnnee = getPubliByAnnee($a);
		foreach($publiByAnnee as $publication)
		{
		
			echo"<tbody><tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0' class='publications-item-date'>";
			echo"<tbody><tr><td align='left' style='vertical-align: top;'><div class='gwt-HTML' style='white-space: normal;'>";
			echo "<span class='publi-ref'>[".$publication['reference']."]</span> ";
			echo"<span class='publi-authors'>".$publication['auteurs']."</span>, ";
			echo"<span class='publi-titre'>".$publication['titre']." </span>";
			echo"<span class='publi-cat'>".getCategoriePubli($publication['categorie_id'])." </span>, ";
			echo"<span class='publi-year' type ='hidden'>".substr($publication['date'], 0, 4). "</span>, ";
			echo"<span class='publi-month' type ='hidden'>".substr($publication['date'], 5, 2). "</span>, ";
			
			
			if($publication['journal'] != null)
			{
				echo"<span class='publi-journal'>".$publication['journal']."</span>, ";
			}
			if($publication['publisher'] != null)
			{
				echo"<span class='publi-publisher'>".$publication['publisher']."</span>, ";
			}
			if($publication['volume'] != null)
			{
				echo"<span class='publi-volume'>".$publication['volume']."</span>, ";
			}
			if($publication['number'] != null)
			{
				echo"<span class='publi-number'>".$publication['number']."</span>, ";
			}
			if($publication['pages'] != null)
			{
				echo"<span class='publi-pages'>".$publication['pages']."</span>, ";
			}
			if($publication['editor'] != null)
			{
				echo"<span class='publi-editor'>".$publication['editor']."</span>, ";
			}

			if($publication['series'] != null)
			{
				echo"<span class='publi-series'>".$publication['series']."</span>, ";
			}
			if($publication['localite'] != null)
			{
				echo"<span class='publi-localite'>".$publication['localite']."</span>, ";
			}
			
			if($publication['note'] != null)
			{
				echo"<div class='publi-note' style='display:none'><br/>".$publication['note']."</div>, ";
			}
			if($publication['abstract'] != null)
			{
				echo"<span class='publi-abstract' style='display:none'>".$publication['abstract']."</span><br> ";
			}
			if($publication['keywords'] != null)
			{
				echo"</br>";
				echo"<span class='publi-keywords'>keywords : ".$publication['keywords']."</span>, ";
			}
			echo '<br/>';
			if($publication['pdf'] != null)
			{
				echo"<tr><td align='left' style='vertical-align: top;'><table cellspacing='0' cellpadding='0'>";
				echo"<tbody><tr><td align='left' style='vertical-align: top;'>";
				echo"</td>";

				echo"<td align='left' style='vertical-align: top;'><a href='uploads/".$publication['pdf'].".pdf'><img border='0' src='images/icon-pdf.png' alt='Download PDF'></a></td>";
			}
			$tex = afficheBibTex($publication);
			$detail = afficheDetailPubliFR($publication);
			echo Html::a('DETAILS', '#', array(
						   'onclick'=>'$("#detail-publi").text("");'.$detail.'$("#detail-publi").dialog("open"); return false', 
			));
			
			echo Html::a('<img src="images/icon-tex.png" class="cursor-pointer">', '#', array(
			   'onclick'=>$tex.'$("#dial-tex").append(",}");$("#dial-tex").dialog("open"); return false', 
			));
			
				echo"</td></div></div></td></tr>";
				echo"</table></td></tr></tbody>";
				echo"</table></td></tr><tr><td align='left' style='vertical-align: top;'>";
			}
			echo"</div>";
	}
	echo"</div>";
	echo"<script>$('.publications-section :first').show();</script>";

}
?>
<script>
function change_onglet(name)
{
document.getElementById('onglet_'+anc_onglet).className = 'onglet_0 onglet';
document.getElementById('onglet_'+name).className = 'onglet_1 onglet';
document.getElementById('contenu_onglet_'+anc_onglet).style.display = 'none';
document.getElementById('contenu_onglet_'+name).style.display = 'block';
anc_onglet = name;
}
</script>
