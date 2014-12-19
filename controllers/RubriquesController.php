<?php

namespace app\controllers;

use Yii;
use app\models\Rubrique;
use app\models\RubriquesSearch;
use app\models\Menu;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\librairies\FonctionsCurl;
use app\librairies\FonctionsRubriques;
use app\librairies\FonctionsMenus;

/**
 * RubriquesController implements the CRUD actions for Rubrique model.
 */
class RubriquesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Rubrique models.
     * @return mixed
     */
    public function actionIndex()
    {
		if(!Yii::$app->user->isGuest)
		{
			$searchModel = new RubriquesSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}
		else
		{
			return $this->redirect('index.php');
		}
    }

	
    
	/**
     * Displays a single Rubrique model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		if(!Yii::$app->user->isGuest)
		{
			FonctionsRubriques::getRubriqueParidentifiant($id);
			return $this->render('view', [
				'model' => FonctionsRubriques::getRubriqueParidentifiant($id),

			]);
		}
		else
		{
			return $this->redirect('index.php');
		}
    }


    /**
     * Creates a new Rubrique model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if(!Yii::$app->user->isGuest)
		{
			$session = Yii::$app->session;
			$session->open();
			$token = $session->get('token');
			
			$modelR = new Rubrique();
			$modelM = new Menu();
			if ($modelR->load(Yii::$app->request->post()) && $modelM->load(Yii::$app->request->post())) {
				try
				{
					FonctionsCurl::CreateRubrique($token,$modelM->titre_fr,$modelM->titre_en,$modelM->actif,$modelM->position,$modelR->content_fr,$modelR->content_en);
				}
				catch()
				{
				}
				return $this->redirect(['index']);
			} else {
				return $this->render('create', [
					'modelR' => $modelR,
					'modelM' => $modelM,
				]);
			}
		}
		else
		{
			return $this->redirect('index.php');
		}
    }

    /**
     * Updates an existing Rubrique model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		if(!Yii::$app->user->isGuest)
		{
			$session = Yii::$app->session;
			$session->open();
			$token = $session->get('token');


			$modelR = FonctionsRubriques::getRubriqueParidentifiant($id);
			$modelM = FonctionsMenus::getMenuById($modelR->menu_id);
			 
			if ($modelR->load(Yii::$app->request->post()) && $modelM->load(Yii::$app->request->post())) {
				FonctionsCurl::UpdateRubrique($token,$modelM->ID,$modelM->titre_fr,$modelM->titre_en,$modelM->actif,$modelM->position,$modelR->content_fr,$modelR->content_en);
				return $this->redirect(['index']);
			} else {
				return $this->render('update', [
					'modelR' => $modelR,
					'modelM' => $modelM,
				]);
			}
		}
		else
		{
			return $thid->redirect('index.php');
		}
    }

    /**
     * Deletes an existing Rubrique model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		if(!Yii::$app->user->isGuest)
		{
			$session = Yii::$app->session;
			$session->open();
			$token = $session->get('token');


			$modelR = FonctionsRubriques::getRubriqueParidentifiant($id);
			$modelM = FonctionsMenus::getMenuById($modelR->menu_id);
			$idMenu = $modelM->ID;


			FonctionsCurl::DeleteRubrique($token,$idMenu);
			return $this->redirect(['index']);
		}
		else
		{
			return $thid->redirect('index.php');
		}
    }


    public function actionDeletemulti()
    {
        
        if(!Yii::$app->user->isGuest)
		{
			$session = Yii::$app->session;
			$session->open();
			$token = $session->get('token');

			if (isset($_POST['keylist'])) {
				$champSelec = $_POST['keylist'];
				foreach($champSelec as $key => $value)
				{
					FonctionsCurl::DeleteRubrique($token,$value);
				}   
				return true;
			}
			return $this->redirect(['index']);
        }
        else
		{
			return $thid->redirect('index.php');
		}
    }

    /**
     * Finds the Rubrique model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rubrique the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = Rubrique::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
