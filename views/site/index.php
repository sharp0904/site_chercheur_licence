<?php

use yii\helpers\Html;
use app\models\Rubrique;
use yii\helpers\Url;


$session = Yii::$app->session;


$language = $session->get('language');


/* @var $this yii\web\View */
$this->title = 'Site enseignant chercheur';

if (isset($_GET["page"])) {
    $idPage = $_GET["page"];
}

	
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

<?php

if(isset($idPage))
{
	try{
		getRubriqueParid($idPage, $language);
	}
	catch(Exception $e)
	{
		echo "page inexistante";
	}
}
else
{
	getRubriqueParid(1);
}

?>   
   
</div>
