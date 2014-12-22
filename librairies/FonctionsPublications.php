<?php
namespace app\librairies;
use app\models\Publication;
use app\models\Categorie;
use Yii;
class FonctionsPublications
{


	
	
	static function getPubliParId($token,$id)
	{


		$publication = json_decode(FonctionsCurl::getPublicationById($token,$id),true);

		return new Publication(['ID'=>$publication['ID'],'reference'=>$publication['reference'],'auteurs'=>$publication['auteurs'],'titre'=>$publication['titre'],'date'=>$publication['date'],'journal'=>$publication['journal'],'volume'=>$publication['volume'],'number'=>$publication['number'],'pages'=>$publication['pages'],'note'=>$publication['note'],'abstract'=>$publication['abstract'],'keywords'=>$publication['keywords'],'series'=>$publication['series'],'localite'=>$publication['localite'],'publisher'=>$publication['publisher'],'editor'=>$publication['editor'],'pdf'=>$publication['pdf'],'date_display'=>$publication['date_display'],'categorie_id'=>$publication['categorie_id']]);
	}

	static function getCategParId($id)
	{

		$categorie = json_decode(FonctionsCurl::getCategorieById($id),true);
		return new Categorie(['ID'=>$categorie['ID'],'name_fr'=>$categorie['name_fr'],'name_en'=>$categorie['name_en']]);	

	}

	static function getPublicationParDate()
	{
		$publications = json_decode(FonctionsCurl::getAllPublicationsByDate(),true);
		return $publications;
	}
	
	static function getPublicationParCategorie($idCat)
	{
		$publications = json_decode(FonctionsCurl::getAllPublications(),true);
		$mesPublis = array();
		foreach($publications as $publi)
		{
			if($publi['categorie_id'] == $idCat)
			{
				$mesPublis[] = $publi;
			}
		}
		return $mesPublis;
	}
	
	static function getPublicationParAnnee($annee)
	{
		$publications = json_decode(FonctionsCurl::getAllPublications(),true);
		$mesPublis = array();
		foreach($publications as $publi)
		{
			$anneePubli = substr($publi['date'], 0, 4);
			if($anneePubli == $annee)
			{
				$mesPublis[] = $publi;
			}
		}
		return $mesPublis;
	}


	static function getTabPublications($language)
	{
		$publications = json_decode(FonctionsCurl::getAllPublications(),true);
		if($language=='fr')
		{
		echo"Supprimer toutes les publications: <input type='checkbox' id='select-all'>";
		}
		else
		{
		echo"delete all publications: <input type='checkbox' id='select-all'>";
		}
		echo"<div id='gestion-table'>";
		echo"<table id='keywords' cellspacing='0' cellpadding='0'>";
	    echo"<thead>";
	      echo"<tr>";
	        echo"<th class='ref'><span>reference</span></th>";
	        echo"<th class='auteurs'><span>auteurs</span></th>";
	        echo"<th class='titre'><span>titre</span></th>";
	        echo"<th class='date'><span>date</span></th>";
	        echo"<th class='journal'><span>journal</span></th>";
	        echo"<th class='volume'><span>volume</span></th>";
	        echo"<th class='number'><span>number</span></th>";
	        echo"<th class='pages'><span>pages</span></th>";
	        echo"<th class='note'><span>note</span></th>";
	        echo"<th class='abstract'><span>abstract</span></th>";
	        echo"<th class='keywords'><span>keywords</span></th>";
	        echo"<th class='series'><span>series</span></th>";
	        echo"<th class='localite'><span>localite</span></th>";
	        echo"<th class='publisher'><span>publisher</span></th>";
	        echo"<th class='editor'><span>editor</span></th>";
	        echo"<th class='date_display'><span>date display</span></th>";
	        echo"<th class='categorie_id'><span>categorie id</span></th>";
	        echo"<th><span>Actions</span></th>";
	        
	      echo"</tr>";
	    echo"</thead>";
	    echo"<tbody>";
	    foreach($publications as $unePubli)
	    {
	    	echo"<tr>";
	    	echo"<td class='ref'>".addslashes($unePubli['reference'])."</td>";
	    	echo"<td class='auteurs'>".addslashes(substr($unePubli['auteurs'], 0,30))."</td>";
	    	echo"<td class='titre'>".addslashes(substr($unePubli['titre'], 0,30))."</td>";
	    	echo"<td class='date'>".$unePubli['date']."</td>";
	    	echo"<td class='journal'>".addslashes(substr($unePubli['journal'], 0,30))."</td>";
	    	echo"<td class='volume'>".addslashes($unePubli['volume'])."</td>";
	    	echo"<td class='number'>".addslashes($unePubli['number'])."</td>";
	    	echo"<td class='pages'>".addslashes($unePubli['pages'])."</td>";
	    	echo"<td class='note'>".addslashes(substr($unePubli['note'], 0, 30))."</td>";
	    	echo"<td class='abstract'>".addslashes($unePubli['abstract'])."</td>";
	    	echo"<td class='keywords'>".addslashes(substr($unePubli['keywords'], 0, 30))."</td>";
	    	echo"<td class='series'>".addslashes($unePubli['series'])."</td>";
	    	echo"<td class='localite'>".addslashes($unePubli['localite'])."</td>";
	    	echo"<td class='publisher'>".addslashes($unePubli['publisher'])."</td>";
	    	echo"<td class='editor'>".addslashes($unePubli['editor'])."</td>";
	    	echo"<td class='date_display'>".addslashes($unePubli['date_display'])."</td>";
	    	echo"<td class='categorie_id'>".$unePubli['categorie_id']."</td>";
	    	echo"<td>";
	    	echo"<a href=index.php?r=publication/view&id=$unePubli[ID]><img src='images/loupe.png'/></a>";
	    	echo"<input type='image' value=$unePubli[ID] id='up' src='images/crayon.png'>";
	    	echo"</td>";
	    	echo"<td>";
	    	echo"<input type='checkbox' name='selection' value=$unePubli[ID]>";
	    	echo"</td>";
	    	echo"</tr>";
	    }
	    echo"</tbody>";
	    echo"<tfoot>";
	      echo"<tr>";
	        echo"<th class='ref'><span>reference</span></th>";
	        echo"<th class='auteurs'><span>auteurs</span></th>";
	        echo"<th class='titre'><span>titre</span></th>";
	        echo"<th class='date'><span>date</span></th>";
	        echo"<th class='journal'><span>journal</span></th>";
	        echo"<th class='volume'><span>volume</span></th>";
	        echo"<th class='number'><span>number</span></th>";
	        echo"<th class='pages'><span>pages</span></th>";
	        echo"<th class='note'><span>note</span></th>";
	        echo"<th class='abstract'><span>abstract</span></th>";
	        echo"<th class='keywords'><span>keywords</span></th>";
	        echo"<th class='series'><span>series</span></th>";
	        echo"<th class='localite'><span>localite</span></th>";
	        echo"<th class='publisher'><span>publisher</span></th>";
	        echo"<th class='editor'><span>editor</span></th>";
	        echo"<th class='date_display'><span>date display</span></th>";
	        echo"<th class='categorie_id'><span>categorie id</span></th>";
	        echo"<th><span>Actions</span></th>";
	      echo"</tr>";
	    echo"</tfoot>";
     
    echo"</tbody>";
  echo"</table>";
  echo"</div>";


	}
}

?>
