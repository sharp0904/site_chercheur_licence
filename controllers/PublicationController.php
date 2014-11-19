<?php

namespace app\controllers;

use Yii;
use app\models\Publication;
use app\models\PublicationSearch;
use app\librairies\Structures_BibTex;
use app\librairies\Validation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;



/**
 * PublicationController implements the CRUD actions for Publication model.
 */
class PublicationController extends Controller
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
     * Lists all Publication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PublicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Publication model.
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
     * Creates a new Publication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Publication();

		     
		
		 
        if ($model->load(Yii::$app->request->post())) {
		
		if (Yii::$app->request->isPost) {
		if(($model->pdf != null))
		{
		$model->pdf = UploadedFile::getInstance($model, 'pdf');
                $model->pdf->saveAs('uploads/' . $model->pdf->baseName . '.' . $model->pdf->extension);
				$model->attributes=array('pdf'=>$model->pdf->baseName);
		}
            
        }
		
		
		 $model->save();
            return $this->redirect(['view', 'id' => $model->ID]);
			
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	

    /**
     * Updates an existing Publication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Publication model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Publication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Publication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Publication::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
	/**
     * Cette action permet d'uploader un fichier bibtex afin de créer une ou plusieurs
     * publications à partir des données du fichier.
     *
     * @param FILE uploadbibtex Le fichier bibtex uploadé.
     */
	 /*
	 
	 
	 //$model->setAttribute("pdf","test");
	 
	 
	 
    public function uploadBibtex()
    {
            // Validation du fichier bibtex
            // On verifie que le fichier uploadé est un fichier bibtex.
            $valid_file = new Validation($_FILES);
            $valid_file->add_rules('uploadbibtex', 'upload::valid', 'upload::required', 'upload::type[bib]');
            if( ! $valid_file->validate() )
            {
                throw new Exception(Kohana::lang('exception.0009'), 0009);
            }

            // On récupère les données
            $uploadfile = '../useruploads/bibtex/'.basename($_FILES['uploadbibtex']['name']);

            // On déplace le fichier dans le dossier d'upload
            if (move_uploaded_file($_FILES['uploadbibtex']['tmp_name'], $uploadfile))
            {
                // On charge le fichier bibtex
                $bibtex = new Structures_BibTex_Core();
                $ret    = $bibtex->loadFile($uploadfile);
                if (PEAR::isError($ret))
                {
                    throw new Exception(Kohana::lang('exception.0010'), 0010);
                }
                
                // On parse le fichier bibtex afin de remplir la structure.
                $bibtex->parse();
                
                $mdl = new Publication_Model();
                foreach ($bibtex->data as $datas)
                {
                    // On créer un objet Publication à partir des données bibtex
                    $publication = new Publication_Metier();
                    $publication = Publication_Metier::mappingBibtex($datas);
                    $mdl->createPublication($publication);
                }     
            }
            else
            {
                throw new Exception(Kohana::lang('exception.0007'), 0007);
            }
    }

	*/
	
	
}
