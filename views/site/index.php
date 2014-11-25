<?php

use yii\helpers\Html;
use app\models\Rubrique;
use yii\helpers\Url;


$session = Yii::$app->session;

if (isset($_GET["locale"])) {
    $session->set('language', $_GET["locale"]);
}
if(isset($session['language']))
{
$language = $session->get('language');
}
else
{
    $session->set('language', 'fr');
    $language = $session->get('language');
}


/* @var $this yii\web\View */
$this->title = 'Site enseignant chercheur';

if (isset($_GET["page"])) {
    $idPage = $_GET["page"];
}
$rubrique = Rubrique::find(array('order'=>'menu_id ASC'))->one();


	
function getRubriqueParid($id, $locale = 'fr')
{

$rubrique = Rubrique::find()->where(['menu_id' => $id])->one();

if($locale == 'en')
{
	echo $rubrique->content_en;
}
elseif($locale == 'fr')
{
	echo $rubrique->content_fr;
}
}
?>
<div class="site-index">
<a href="?r=site/index&locale=fr"><img src="images/flag-fr.png" /></a> 
<a href="?r=site/index&locale=en"><img src="images/flag-en.png" /></a> 
</br></br></br>
<?php


if(isset($idPage))
{
	try{
		
		echo '<div class="text-contener" >';
		echo '<div class="text-content" >';
		getRubriqueParid($idPage, $language);
		echo '</div></div>';
	}
	catch(Exception $e)
	{
		echo "page inexistante";
	}
}
else
{
	echo '<div class="text-contener" >';
	echo '<div class="text-content" >';
	getRubriqueParid($rubrique->menu_id,$language);
	echo '</div></div>';
}

?>   
   
</div>
