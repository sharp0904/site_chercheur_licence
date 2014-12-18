<?php

namespace app\controllers;

use Yii;
use app\models\Publication;
use app\models\PublicationSearch;
use app\librairies\Structures_BibTex_Core;
use app\models\Bibtex;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use app\librairies\FonctionsCurl;
use app\librairies\FonctionsPublications;


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
		
		if(!Yii::$app->user->isGuest)
		{
			$searchModel = new PublicationSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$model = new Bibtex();
			
				if (Yii::$app->request->isPost) {
					$model->Bibtex = UploadedFile::getInstance($model, 'Bibtex');
					if(isset($model->Bibtex) && $model->Bibtex->extension == 'bib')
					{
						$model->Bibtex->saveAs('uploads/bibtex/' . $model->Bibtex);
						PublicationController::uploadBibtex($model->Bibtex);
					}				
				}		
				return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'model' => $model,
				]);	
		}
		else
		{
			return $this->goHome();
		}
    }

    /**
     * Displays a single Publication model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		if(!Yii::$app->user->isGuest)
		{
			$session = Yii::$app->session;
			$session->open();
			$token = $session->get('token');
	
			return $this->render('view', [
				'model' => FonctionsPublications::getPubliParId($token,$id),
			]);
		}
		else
		{
			return $this->goHome();
		}
    }

    /**
     * Creates a new Publication model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
     public function actionCreate()
    {
		if(!Yii::$app->user->isGuest)
		{
			$session = Yii::$app->session;
			$session->open();
			$token = $session->get('token');

				$model = new Publication(); 
				if ($model->load(Yii::$app->request->post())) {		
					if (Yii::$app->request->isPost) {
						$model->pdf = UploadedFile::getInstance($model, 'pdf');
						if(isset($model->pdf->baseName))
						{
							$model->pdf->saveAs('uploads/' . $model->pdf->baseName . '.' . $model->pdf->extension);
							$model->attributes=array('pdf'=>$model->pdf->baseName);
						}
					}
					if(isset($_POST['month']))
					{
						$month = $_POST['month'];
					}
					else
					{
						$month = '01';
					}
					if(isset($_POST['year']))
					{
						$year = $_POST['year'];
					}
					else
					{
						$year = date('Y');
					}
					$date = $year.'-'.$month.'-01';
					$model->attributes=array('date'=>$date);
					FonctionsCurl::CreatePublication($token,$model->reference,$model->auteurs,$model->titre,$model->date,$model->journal,$model->volume,$model->number,$model->pages,$model->note,$model->abstract,$model->keywords,$model->series,$model->localite,$model->publisher,$model->editor,$model->pdf,$model->date_display,$model->categorie_id);
					return $this->redirect(['index']);
				} else {
					return $this->render('create', [
						'model' => $model,
					]);
				}
			}
		else
		{
			return $this->goHome();
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
		if(!Yii::$app->user->isGuest)
		{
			$session = Yii::$app->session;
			$session->open();
			$token = $session->get('token');
		   
			$model = FonctionsPublications::getPubliParId($token,$id);

			if ($model->load(Yii::$app->request->post())) {
				if (Yii::$app->request->isPost) {
					$model->pdf = UploadedFile::getInstance($model, 'pdf');
					if(isset($model->pdf->baseName))
					{
						$model->pdf->saveAs('uploads/' . $model->pdf->baseName . '.' . $model->pdf->extension);
						$model->attributes=array('pdf'=>$model->pdf->baseName);
					}
				}
				if(isset($_POST['month']))
				{
					$month = $_POST['month'];
				}
				else
				{
					$month = '01';
				}
				if(isset($_POST['year']))
				{
					$year = $_POST['year'];
				}
				else
				{
					$year = date('Y');
				}
				$date = $year.'-'.$month.'-01';
				$model->attributes=array('date'=>$date);

				
				FonctionsCurl::UpdatePublication($token,$model->ID,$model->reference,$model->auteurs,$model->titre,$model->date,$model->journal,$model->volume,$model->number,$model->pages,$model->note,$model->abstract,$model->keywords,$model->series,$model->localite,$model->publisher,$model->editor,$model->pdf,$model->date_display,$model->categorie_id);
				return $this->redirect(['view', 'id' => $model->ID]);
			} else {
				return $this->render('update', [
					'model' => $model,
				]);
			}
		}
		else
		{
			return $this->goHome();
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
		if(!Yii::$app->user->isGuest)
		{
			$session = Yii::$app->session;
			$session->open();
			$token = $session->get('token');

			FonctionsCurl::deletePublication($token,$id);

			return $this->redirect(['index']);
		}
		else
		{
			return $this->goHome();
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
					FonctionsCurl::deletePublication($token,$value);
				}	
				return true;
			}
			return $this->redirect(['index']);
		}
		else
		{
			return $this->goHome();
		}
    }

    /**
     * Finds the Publication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Publication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = Publication::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
    
    public function uploadBibtex($fichier)
    {    
		if($fichier != null)
		{
			if(!Yii::$app->user->isGuest)
			{
			
				$session = Yii::$app->session;
				$session->open();
				$token = $session->get('token');

				// On récupère les données
				$uploadfile = 'uploads/bibtex/'.$fichier;
				// On déplace le fichier dans le dossier d'upload
				if (file_exists($uploadfile))
				{
					// On charge le fichier bibtex
					$bibtex = new Structures_BibTex_Core();
					$ret = $bibtex->loadFile($uploadfile);
					
					
					// On parse le fichier bibtex afin de remplir la structure.
					$bibtex->parse();
					
					$model = new Publication();

					foreach ($bibtex->data as $datas)
					{
						// On créé un objet Publication à partir des données bibtex
						$model = $this->mappingBibtex($datas);
						FonctionsCurl::CreatePublication($token,$model->reference,$model->auteurs,$model->titre,$model->date,$model->journal,$model->volume,$model->number,$model->pages,$model->note,$model->abstract,$model->keywords,$model->series,$model->localite,$model->publisher,$model->editor,$model->pdf,$model->date_display,$model->categorie_id);
						//$model->save();                   
					}                   
				}
				else
				{
				   throw new NotFoundHttpException('Fichier Introuvable: '.$fichier);
				}
			}
			else
			{
				return $this->goHome();
			}
		}
		else
		{
			return $this->goHome();
		}
            
        }

    
	
	
	public static function mappingBibtex($tableau)
    {
        // On initialise les variables 
        $date = date('Y')."-01-01";
        $date_display = "";
        $journal = "";
        $volume = "";
        $number = "";
        $pages = "";
        $note = "";
        $abstract = "";
        $keywords = "";
        $series = "";
        $localite = "";
        $publisher = "";
        $editor = "";
        $categorie = "";
        $date_display = "";

        $entryType = "";        
        if (!empty($tableau) && isset($tableau["cite"]) && isset($tableau["author"]) && isset($tableau["title"]))
        {
			// Champs obligatoire
			$reference = $tableau["cite"];
			$auteurs = substr($tableau["author"], 1 ,-1);
			$auteurs = str_replace('é', 'e', $auteurs);
			$titre = substr($tableau["title"], 1 ,-1);
			
			// On formate la date
			if( array_key_exists('year', $tableau))
			{
				if(is_numeric(substr($tableau["year"], 1 ,-1)))
				{
					$date = substr($tableau["year"],1 ,-1);
					$date_display = substr($tableau["year"], 1, -1);                
					if(array_key_exists('month', $tableau) && is_numeric(substr($tableau["month"], 1 ,-1)))
					{
						$date .= '-'.substr($tableau["month"], 1, -1).'-01';
						$date_display .= substr($tableau["month"], 1, -1).' '.$date_display;
					}
					else
					{
						$date .= "-01-01";
					}
				}
			}
			
			// On récupère les autres données et on supprimme les { } des données
			foreach ($tableau as $key => $value)
			{
				if(!in_array($key, array('cite','author','title','year','month')))
				{
					if($key != 'entryType')
					{
						$$key = substr($value, 1, -1);
					}
					else{
						
						$$key = $value;
					}
				}
			}
			// On fait correspondre les variables du fichier bibtex et les attributs
			// de la publication
			if(isset($booktitle))
			{
				$journal = $booktitle;
			}
			if(isset($address))
			{
				$localite = $address;
			}
			
			// On defini la categorie
			if( in_array(strtolower($entryType), array('article')))
				$categ_id = "1";
			else if( in_array(strtolower($entryType), array('inproceedings')))
				$categ_id = "2";
			else if( in_array(strtolower($entryType), array('techreport')))
				$categ_id = "3";
			else if( in_array(strtolower($entryType), array('phdthesis')))
				$categ_id = "4";
			else
				$categ_id = "5";
		   
			
			// On créer la publication et on attribut les values
			$publication = new Publication();
			$publication->reference=$reference;
			$publication->auteurs=$auteurs;
			$publication->titre=$titre;
			$publication->date=$date;
			$publication->journal=$journal;
			$publication->volume=$volume;
			$publication->number=$number;
			$publication->pages=$pages;
			$publication->note=$note;
			$publication->abstract=$abstract;
			$publication->keywords=$keywords;
			$publication->series=$series;
			$publication->localite=$localite;
			$publication->publisher=$publisher;
			$publication->editor=$editor;
			$publication->pdf=null;
			$publication->date_display=date('Y-m-d');
			$publication->categorie_id = $categ_id;
			return $publication;
		}
		else
		{
			throw new NotFoundHttpException('Le tableau est vide ou ses champs obligatoires le sont.');
		}
    }

	
}
