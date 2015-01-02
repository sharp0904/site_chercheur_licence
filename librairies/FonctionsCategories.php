<?php

 namespace app\librairies;
use app\models\Publication;
use Yii;
class FonctionsCategories
{
	static function getAllCategories()
	{
		$categories = json_decode(FonctionsCurl::getAllCategories(), true);
		return $categories;
	}
	
	static function getNameCategoriesDePubliEN($id)
	{
		$categories = json_decode(FonctionsCurl::getAllCategories(), true);
		$name = "";
		foreach($categories as $cat)
		{
			if($cat['ID'] == $id)
			{
				$name = $cat['name_en'];
			}
		}
		return $name;
	}
	
}


?>
