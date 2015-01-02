<!DOCTYPE html>

<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Menu;
use app\librairies\FonctionsCurl;
use app\librairies\FonctionsMenus;

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



$rs = array();

try{
$rs = FonctionsMenus::getMenusActifs($language);
}
catch(Exception $e)
{
	
}

if($language=='fr')
{
	$connexion = 'Connexion';
	$deconnexion = 'Déconnexion';
	$GRubriques = 'Gestion Rubriques';
	$GPublications = 'Gestion Publications';
	$logo = 'Changer logo';
}
else
{
	$connexion = 'Login';
	$deconnexion = 'Logout';
	$GRubriques = 'Section management';
	$GPublications = 'Publications management';
	$logo = 'Manage logo';
}


?>
<?php $this->beginPage() ?>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" type="text/css" media="all" href="css/styles.css">
          <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>

      <script type="text/javascript" src="js/publication-index.js"></script>

    <link rel="stylesheet" href="../web/css/pop-up.css">
</head>
<body>

<?php $this->beginBody() ?>

    <div class="wrap">
	<img src="uploads/logo.png" alt="logo" style="width:20%; margin-left:-20%;padding-bottom:30px;margin-top:20px;">
	<div id="language">
	<a href="?r=site/index&locale=fr"><img src="images/flag-fr.png" /></a> 
	<a href="?r=site/index&locale=en"><img src="images/flag-en.png" /></a>
	</div>
        <?php
            NavBar::begin([
                //'brandLabel' => 'Site enseignant chercheur',
				
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse',
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
						
						FonctionsMenus::listerRubriques($rs, $titre, $language)

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
						
						FonctionsMenus::listerRubriques($rs, $titre, $language)
						
						],
					]);
						
					}
				}

				echo Nav::widget([
					'options' => ['class' => 'navbar-nav navbar-left'],
					'items' => [
						['label' => 'Publications', 'url' => ['/site/publications']],

						['label' => $connexion, 'url' => ['/site/login']],						

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
					
					FonctionsMenus::listerRubriques($rs, $titre, $language)

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
					
					FonctionsMenus::listerRubriques($rs, $titre, $language)
					
					],
				]);
					
				}
			}

			echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
					['label' => 'Publications', 'url' => ['/site/publications']],
					['label' => '|'],
					['label' => $logo, 'url' => ['/site/logo']],
					['label' => $GRubriques, 'url' => ['/rubriques/index']],
					['label' => $GPublications, 'url' => ['/publication/index']], 
						
						['label' => $deconnexion.' (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
			}
			
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>
</br></br>
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

  <script type="text/javascript" src="js/jquery.tablesorter.js"></script>  
  <script type="text/javascript" src="js/effet.js"></script>
