<!DOCTYPE html>

<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Menu;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

$session = Yii::$app->session;

$session->open();
$language = $session->get('language');

if(!isset($language))
{
$language='fr';
}

function getMenus($locale = 'fr')
{
$list = Menu::find()->where(['actif' => '1'])->orderBy(['position' => SORT_ASC])->all();
		
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


function listerRubriques($rs,$titre,$locale='fr')
{
$res;
if($locale == 'fr')
{
$url = '/site/index&page='.getIdParTitreFR($titre);
		$res = ['label' => $titre, 'url' => [$url]];
}
elseif($locale == 'en')
{
$url = '/site/index&page='.getIdParTitreEN($titre);
		$res = ['label' => $titre, 'url' => [$url]];
}

	return $res;
}
	
function getIdParTitreFR($titreFR)
{
$rubrique = Menu::find()->where(['titre_fr' => $titreFR])->one();
return $rubrique->id;
}

function getIdParTitreEN($titreEN)
{
$rubrique = Menu::find()->where(['titre_en' => $titreEN])->one();
return $rubrique->id;
}





$rs = getMenus($language);

?>
<?php $this->beginPage() ?>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Site enseignant chercheur',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
			if(Yii::$app->user->isGuest)
			{
			
			if($language == 'fr')
			{
				foreach($rs as $titre)
				{
				echo Nav::widget([
					'options' => ['class' => 'navbar-nav navbar-left'],
					'items' => [
					
					listerRubriques($rs, $titre, $language)

					],
				]);
					
				}
			}
			elseif($language =='en')
			{
				foreach($rs as $titre)
				{
				echo Nav::widget([
					'options' => ['class' => 'navbar-nav navbar-left'],
					'items' => [					
					
					listerRubriques($rs, $titre, $language)
					
					],
				]);
					
				}
			}
			echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
					['label' => 'Publications', 'url' => ['/site/publications']],

                    ['label' => 'Login', 'url' => ['/site/login']],
					

                ],
            ]);
            NavBar::end();
			}
			else
			{
			
			if($language == 'fr')
			{
				foreach($rs as $titre)
				{
				echo Nav::widget([
					'options' => ['class' => 'navbar-nav navbar-left'],
					'items' => [
					
					listerRubriques($rs, $titre, $language)

					],
				]);
					
				}
			}
			elseif($language =='en')
			{
				foreach($rs as $titre)
				{
				echo Nav::widget([
					'options' => ['class' => 'navbar-nav navbar-left'],
					'items' => [					
					
					listerRubriques($rs, $titre, $language)
					
					],
				]);
					
				}
			}
			echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
					['label' => 'Publications', 'url' => ['/site/publications']],
					['label' => 'Gestion Menu', 'url' => ['/menu/index']],
					['label' => 'Gestion Rubriques', 'url' => ['/rubriques/index']], 
						
						['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
			}
			
			//code d'origine 
			
            /*echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
						['label' => 'Gestion Menu', 'url' => ['/menu']],
						['label' => 'Gestion Rubriques', 'url' => ['/rubriques']],
                ],
            ]);
            NavBar::end();*/
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
