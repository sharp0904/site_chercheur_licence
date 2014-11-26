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
        $searchModel = new RubriquesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	/** Met à jour l'id_menu de Rubriques renvoi sur cette rubrique */
    public function actionMaj($id, $menu_id)
    {
		$modelR = $this->findModel($id);
		$modelR->attributes=array('menu_id'=>$menu_id);
		$modelR->save();
        return $this->redirect(['view',
            'id' => $modelR->id,
        ]);
    }
    
	/**
     * Displays a single Rubrique model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Rubrique model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelR = new Rubrique();
        $modelM = new Menu();

        if ($modelR->load(Yii::$app->request->post()) && $modelR->save() && $modelM->load(Yii::$app->request->post()) && $modelM->save()) {
            
            $this->redirect(['maj', 'id' => $modelR->id, 'menu_id' => $modelM->id]);
        } else {
            return $this->render('create', [
                'modelR' => $modelR,
                'modelM' => $modelM,
            ]);
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
        $modelR = $this->findModel($id);
        $modelM = MenuController::findModel($modelR->menu_id);
        

        if ($modelR->load(Yii::$app->request->post()) && $modelR->save() && $modelM->load(Yii::$app->request->post()) && $modelM->save()) {
            return $this->redirect(['maj', 'id' => $modelR->id, 'menu_id' => $modelM->id]);
        } else {
            return $this->render('update', [
                'modelR' => $modelR,
                'modelM' => $modelM,
            ]);
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
		$modelR = $this->findModel($id);
		$modelM = MenuController::findModel($modelR->menu_id);
        $idMenu = $modelM->id;
        $this->findModel($id)->delete();
        MenuController::findModel($idMenu)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Rubrique model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rubrique the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected static function findModel($id)
    {
        if (($model = Rubrique::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
