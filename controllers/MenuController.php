<?php

namespace app\controllers;

use Yii;
use app\models\Menu;
use app\models\Rubrique;
use app\models\MenuSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
		if(!Yii::$app->user->isGuest)
		{
			$searchModel = new MenuSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}
		else
		{
			return $this->goHome();
		}
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		if(!Yii::$app->user->isGuest)
		{
			return $this->render('view', [
				'model' => $this->findModel($id),
			]);
		}
		else
		{
			return $this->goHome();
		}
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if(!Yii::$app->user->isGuest)
		{
        $modelM = new Menu();        
			if ($modelM->load(Yii::$app->request->post()) && $modelM->save()) {
				
				return $this->redirect(['view', 'id' => $modelM->id]);
			} else {
				return $this->render('create', [
					'modelM' => $modelM,
				]);
			}
		}
		else
		{
			return $this->goHome();
		}
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		if(!Yii::$app->user->isGuest)
		{
			$modelM = $this->findModel($id);

			if ($modelM->load(Yii::$app->request->post()) && $modelM->save()) {
				return $this->redirect(['view', 'id' => $modelM->id]);
			} else {
				return $this->render('update', [
					'modelM' => $modelM,

				]);
			}
		}
		else
		{
			return $this->goHome();
		}
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		if(!Yii::$app->user->isGuest)
		{
			$this->findModel($id)->delete();

			return $this->redirect(['index']);
		}
		else
		{
			return $this->goHome();
		}
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
