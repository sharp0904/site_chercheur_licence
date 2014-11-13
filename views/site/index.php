<?php

use yii\helpers\Html;
use app\models\Rubrique;
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->title = 'Site enseignant chercheur';

if (isset($_GET["page"])) {
    $idPage = $_GET["page"];
}

	
function getRubriqueParid($id)
{
$rubrique = Rubrique::find()->where(['menu_id' => $id])->one();
echo $rubrique->content_fr;
}
?>
<div class="site-index">

<?php

if(isset($idPage))
{
	try{
		getRubriqueParid($idPage);
	}
	catch(Exception $e)
	{
		echo "page inexistante";
		echo "id page ".$idPage;
	}
}
else
{
	getRubriqueParid(1);
}

?>   
   
</div>
