<?php
namespace app\librairies;
use app\models\Rubrique;
use Yii;
class FonctionsRubriques
{


	
	static function getRubriqueParid($id, $locale = 'fr')
	{

		$rubrique = json_decode(FonctionsCurl::getRubriqueById($id),true);

		return new Rubrique(['ID'=>$rubrique['ID'],'date_creation'=>$rubrique['date_creation'],'date_modification'=>$rubrique['date_modification'],'content_fr'=>$rubrique['content_fr'],'content_en'=>$rubrique['content_en'],'menu_id'=>$rubrique['menu_id']]);
	}

	static function getRubriqueParidentifiant($id, $locale = 'fr')
	{

		$rubrique = json_decode(FonctionsCurl::getRubriqueByIdentifiant($id),true);

		return new Rubrique(['ID'=>$rubrique['ID'],'date_creation'=>$rubrique['date_creation'],'date_modification'=>$rubrique['date_modification'],'content_fr'=>$rubrique['content_fr'],'content_en'=>$rubrique['content_en'],'menu_id'=>$rubrique['menu_id']]);
	}

	static function getFirstRubrique()
	{

		$rubrique = json_decode(FonctionsCurl::getFirstRubrique(),true);
		if($rubrique == false)
		{
			return $rubrique;
		}
		return new Rubrique(['ID'=>$rubrique[0]['ID'],'date_creation'=>$rubrique[0]['date_creation'],'date_modification'=>$rubrique[0]['date_modification'],'content_fr'=>$rubrique[0]['content_fr'],'content_en'=>$rubrique[0]['content_en'],'menu_id'=>$rubrique[0]['menu_id']]);
	}

	static function getAllRubriques()
	{
		$rubrique = json_decode(FonctionsCurl::getAllRubriques(),true);
		return $rubrique;	
	}


	static function getContentRubriqueParid($id, $locale = 'fr')
	{
		$rubrique = json_decode(FonctionsCurl::getRubriqueById($id),true);
		if($locale == 'en')
		{
			return $rubrique['content_en'];
		}
		elseif($locale == 'fr')
		{	
			return $rubrique['content_fr'];
		}
	}

	static function getTabRubriques()
	{
		$rubriques = FonctionsRubriques::getAllRubriques();


		echo"<div id='gestion-table'>";
		echo"<table id='keywords' cellspacing='0' cellpadding='0'>";
	    echo"<thead>";
	      echo"<tr>";
	        echo"<th><span>id</span></th>";
	        echo"<th class='titrefr'><span>titre_fr</span></th>";
	        echo"<th class='titreen'><span>titre_en</span></th>";
	        echo"<th class='contentfr'><span>content_fr</span></th>";
	        echo"<th class='contenten'><span>content_en</span></th>";
	        echo"<th class='dateCreation'><span>Date Creation</span></th>";
	        echo"<th class='dateModification'><span>Date Modification</span></th>";
	         echo"<th><span>Actions</span></th>";
	      echo"</tr>";
	    echo"</thead>";
	    echo"<tbody>";
	    foreach($rubriques as $uneRubrique)
	    {
	    	echo"<tr>";
	    	echo"<td class='lalign'>".$uneRubrique['ID']."</td>";
	    	echo"<td class='titrefr'>".addslashes($uneRubrique['titre_fr'])."</td>";
	    	echo"<td class='titreen'>".addslashes($uneRubrique['titre_en'])."</td>";
	    	echo"<td class='contentfr'>".addslashes(substr($uneRubrique['content_fr'], 0,100))."</td>";
	    	echo"<td class='contenten'>".addslashes(substr($uneRubrique['content_en'],0,100))."</td>";
	    	echo"<td class='dateCreation'>".$uneRubrique['date_creation']."</td>";
	    	echo"<td class='dateModification'>".$uneRubrique['date_modification']."</td>";
	    	echo"<td>";
	    	echo"<a href=index.php?r=rubriques/view&id=$uneRubrique[ID]><img src='images/loupe.png' style='width:32px;'/></a>";
	    	echo"<a href=index.php?r=rubriques/update&id=$uneRubrique[ID]><img src='images/crayon.png'/></a>";
	    	echo"</td>";
	    	echo"<td>";
	    	echo"<input type='checkbox' name='selection' value=$uneRubrique[menu_id]>";
	    	echo"</td>";
	    	echo"</tr>";
	    }
	    echo"</tbody>";
	    echo"<tfoot>";
	      echo"<tr>";
	         echo"<th><span>id</span></th>";
	        echo"<th class='titrefr'><span>titre_fr</span></th>";
	        echo"<th class='titreen'><span>titre_en</span></th>";
	        echo"<th class='contentfr'><span>content_fr</span></th>";
	        echo"<th class='contenten'><span>content_en</span></th>";
	        echo"<th class='dateCreation'><span>Date Creation</span></th>";
	        echo"<th class='dateModification'><span>Date Modification</span></th>";
	       	echo"<th><span>Actions</span></th>";
	      echo"</tr>";
	    echo"</tfoot>";
     
    echo"</tbody>";
  echo"</table>";
  echo"</div>";

	}
}


