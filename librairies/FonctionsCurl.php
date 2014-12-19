<?php
namespace app\librairies;

use yii\web\Curl;
use Yii;	

class FonctionsCurl 
{
	public static function cheminTest()
	{
		return('http://localhost/site-enseignant-chercheur/');
	}

	public static function cheminServeur()
	{
		return($_SERVER['SERVER_NAME'].''.dirname(dirname($_SERVER['PHP_SELF'])).'/');
	}
	


	//--------------------CATEGORIES----------------------------

	public static function getAllCategories()
	{
            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/categories');
 			return $response;
	}


	public static function getCategorieById($id)
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/categories/'.$id);
 			return $response;
	}

	//--------------------RUBRIQUES----------------------------


	public static function CreateRubrique($token,$titre_fr,$titre_en,$actif,$position,$content_fr,$content_en)
	{

            $donnes = array('a'=>$token,'titre_fr' => $titre_fr, 'titre_en' => $titre_en, 'actif'=>$actif, 'position'=>$position,'content_fr'=>$content_fr, 'content_en'=>$content_en);
            $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->post(FonctionsCurl::cheminTest().'rest/web/index.php/admin/rubrique', $tabJson);
 			return $response;
	}

	public static function UpdateRubrique($token,$id,$titre_fr,$titre_en,$actif,$position,$content_fr,$content_en)
	{

            $donnes = array('a'=>$token,'id'=>$id,'titre_fr' => $titre_fr, 'titre_en' => $titre_en, 'actif'=>$actif, 'position'=>$position,'content_fr'=>$content_fr, 'content_en'=>$content_en);
            $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->put(FonctionsCurl::cheminTest().'rest/web/index.php/admin/rubriques/'.$id, $tabJson);
 			return $response;
	}

	public static function DeleteRubrique($token,$id)
	{

			$donnes = array('a'=>$token);
            $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->delete(FonctionsCurl::cheminTest().'rest/web/index.php/admin/rubriques/'.$id,$tabJson);
 			return $response;
	}

	public static function getAllRubriques()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/rubriques');
 			return $response;
	}

	public static function getRubriqueById($id)
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/rubriques/'.$id);
 			return $response;
	}


	public static function getRubriqueByIdentifiant($id)
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/rubriquesId/'.$id);
 			return $response;
	}

	public static function getRubriqueByTitreEn($titre_en)
	{

		 $donnes = array('titre_en'=>$titre_en);
            $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/rubriques/titre_en', $tabJson);
 			return $response;

	}

	public static function getRubriqueByTitreFr($titre_fr)
	{

             $donnes = array('titre_fr'=>$titre_fr);
            $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/rubriques/titre_fr', $tabJson);
 			return $response;
	}

	public static function getRubriqueFiltree($token,$id,$titre_fr,$titre_en,$actif,$position,$date_creation,$date_modif,$content_fr,$content_en)
	{

            $donnes = array('a'=>$token,'ID'=>$id,'titre_fr' => $titre_fr, 'titre_en' => $titre_en, 'actif'=>$actif, 'position'=>$position,'date_creation'=>$date_creation, 'date_modification'=>$date_modif,'content_fr'=>$content_fr, 'content_en'=>$content_en);
            $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/admin/rubriques/filter', $tabJson);
 			return $response;
	}

	public static function getNbRubriques()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/rubriques/count');
 			return $response;
	}

	public static function getRubriquesAsc()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/rubriques/asc');
 			return $response;
	}

	public static function getRubriquesDesc()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/rubriques/desc');
 			return $response;
	}

	public static function getFirstRubrique()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/rubriques/first');
 			return $response;
	}







	//--------------------MENUS----------------------------


	public static function getAllMenus()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/menus');
 			return $response;
	}

	public static function getAllMenusActifs()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/menus/actif');
 			return $response;
	}

	public static function getMenuById($id)
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/menus/'.$id);
 			return $response;
	}


	//--------------------PUBLICATIONS----------------------------


	public static function CreatePublication($token,$reference,$auteurs,$titre,$date,$journal,$volume,$number,$pages,$note,$abstract,$keywords,$series,$localite,$publisher,$editor,$pdf,$date_display,$categorie_id)
	{

           $donnes = array('a'=>$token,'reference' => $reference, 'auteurs' => $auteurs, 'titre'=>$titre, 'date'=>$date,'journal'=>$journal, 'volume'=>$volume, 'number'=>$number,'pages'=>$pages,'note'=>$note,'abstract'=>$abstract,'keywords'=>$keywords,'series'=>$series,'localite'=>$localite,'publisher'=>$publisher,'editor'=>$editor,'pdf'=>$pdf,"date_display"=>$date_display,'categorie_id'=>$categorie_id);
            $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->post(FonctionsCurl::cheminTest().'rest/web/index.php/admin/publication', $tabJson);
 			return $response;
	}

	public static function UpdatePublication($token,$id,$reference,$auteurs,$titre,$date,$journal,$volume,$number,$pages,$note,$abstract,$keywords,$series,$localite,$publisher,$editor,$pdf,$date_display,$categorie_id)
	{

            $donnes = array('a'=>$token,'ID'=>$id,'reference' => $reference, 'auteurs' => $auteurs, 'titre'=>$titre, 'date'=>$date,'journal'=>$journal, 'volume'=>$volume, 'number'=>$number,'pages'=>$pages,'note'=>$note,'abstract'=>$abstract,'keywords'=>$keywords,'series'=>$series,'localite'=>$localite,'publisher'=>$publisher,'editor'=>$editor,'pdf'=>$pdf,"date_display"=>$date_display,'categorie_id'=>$categorie_id);
            $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->put(FonctionsCurl::cheminTest().'rest/web/admin/publications/'.$id, $tabJson);
 			return $response;
	}

	public static function DeletePublication($token,$id)
	{		
			$donnes = array('a'=>$token);
		    $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->delete(FonctionsCurl::cheminTest().'rest/web/admin/publications/'.$id, $tabJson);
 			return $response;
	}

	public static function getAllPublications()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/publications');
 			return $response;
	}

	public static function getPublicationById($token,$id)
	{
			$donnes = array('a'=>$token);
            $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/admin/publications/'.$id,$tabJson);
 			return $response;
	}

	public static function getPublicationsFiltrees($reference,$auteurs,$titre,$date,$journal,$volume,$number,$pages,$note,$abstract,$keywords,$series,$localite,$publisher,$editor,$pdf,$date_display,$categorie_id)
	{

            $donnes = array('reference' => $reference, 'auteurs' => $auteurs, 'titre'=>$titre, 'date'=>$date,'journal'=>$journal, 'volume'=>$volume, 'number'=>$number,'pages'=>$pages,'note'=>$note,'abstract'=>$abstract,'keywords'=>$keywords,'series'=>$series,'localite'=>$localite,'publisher'=>$publisher,'editor'=>$editor,'pdf'=>$pdf,"date_display"=>$date_display,'categorie_id'=>$categorie_id);
            $tabJson = json_encode($donnes);
            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/admin/publications/filter', $tabJson);
 			return $response;
	}

	public static function getAllPublicationsByDate()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/publications/date');
 			return $response;
	}

	public static function getAllPublicationsByCateg()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/publications/categorie');
 			return $response;
	}

	public static function getNbPublications()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/publications/count');
 			return $response;
	}

	public static function GetPubliTrieesAsc()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/publications/asc');
 			return $response;
	}

	public static function GetPubliTrieesDesc()
	{

            $curl = new Curl();
 			$response = $curl->get(FonctionsCurl::cheminTest().'rest/web/index.php/publications/desc');
 			return $response;
	}

	

}
