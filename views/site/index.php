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
echo"<p>";

	echo $rubrique->content_en;
	echo"</p>";

}
elseif($locale == 'fr')
{
echo"<p>";
	echo $rubrique->content_fr;
	echo"</p>";
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
		if(isset($language))
		{
			if($language=='fr')
			{
				echo "page inexistante";
			}
			else
			{
				echo "Not found";
			}
		}
		else
		{
			echo "page inexistante";
		}
	}
}
else
{
	if(isset($language))
	{
	getRubriqueParid($rubrique->menu_id,$language);
	}
	else
	{
	getRubriqueParid($rubrique->menu_id,'fr');
	}

}

?>   
   
</div>
