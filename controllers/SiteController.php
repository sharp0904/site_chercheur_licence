<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use yii\web\Curl;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

	
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
	
	public function actionPublications()
    {
        return $this->render('publications');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {



            $test = array('username' => $model->username, 'password' => $model->password);
            $tabJson = json_encode($test);
            $curl = new Curl();
 $response = $curl->post(
            'http://localhost/site-enseignant-chercheur/rest/web/login', $tabJson
        );
       



 $user = new User(['id' => '108', 'username' => $model->username, 'password'=> $model->password, 'authKey'=>'test108key','accessToken'=>'108-token']);
           

$session = Yii::$app->session;
$session->open();
$session->set('user', $user);

        
        $model->login2($user);
return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
	

    public function actionLogo()
    {


        if (Yii::$app->request->isPost) {
            $uploaddir = 'uploads/';
            $uploadfile = $uploaddir . basename($_FILES['logo']['name']);

            
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile)) {
               
                 return $this->render('index');

            } else {
                echo "Fichier n'a pas été téléchargé, peut être un mauvais format ?";
            }


            
            }
            else
            {
                 return $this->render('change_logo');
            }

       
    }
	
	

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
