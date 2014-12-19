<?php

 namespace app\librairies;
use app\models\Menu;
use Yii;
class FonctionsMenus 
{


static function getMenusActifs($locale = 'fr')
{

$list = json_decode(FonctionsCurl::getAllMenusActifs(),true);
		$rs=array();
		if($locale == 'fr')
		{
			foreach($list as $item){
				$rs[]=$item['titre_fr'];
			}
		}
		elseif($locale == 'en')
		{
			foreach($list as $item){
				$rs[]=$item['titre_en'];
			}
		}
		
		return $rs;
}



static function listerRubriques($rs,$titre,$locale='fr')
{
$res;
if($locale == 'fr')
{
	$url = '/site/index&page='.FonctionsMenus::getIdParTitreFR($titre);
	$res = ['label' => $titre, 'url' => [$url]];
}
elseif($locale == 'en')
{
	$url = '/site/index&page='.FonctionsMenus::getIdParTitreEN($titre);
	$res = ['label' => $titre, 'url' => [$url]];
}

	return $res;
}
	
static function getIdParTitreFR($titreFR)
{
	$rubrique = json_decode(FonctionsCurl::getRubriqueByTitreFr($titreFR),true);
	return $rubrique[0]['menu_id'];
}
static function getIdParTitreEN($titreEN)
{
	$rubrique = json_decode(FonctionsCurl::getRubriqueByTitreEn($titreEN),true);
	return $rubrique[0]['menu_id'];
}

static function getMenuById($id)
{
	$menu = json_decode(FonctionsCurl::getMenuById($id),true);
	return new Menu(['ID'=>$menu['ID'], 'titre_fr'=>$menu['titre_fr'],'titre_en'=>$menu['titre_en'], 'actif'=>$menu['actif'],'position'=>$menu['position']]);
}
	

}


