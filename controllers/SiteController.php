<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Usuario;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        if (Yii::$app->user->isGuest) {
            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }

            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }
            return $this->render('login', [
                'model' => $model,
            ]);
        } else {
            # code...
            if(Yii::$app->user->can('administrador')){
              return $this->render('index');
            }
            elseif(Yii::$app->user->can('locacao') || Yii::$app->user->can('corretor')){
                return $this->render('indexlocacao');
            } else {
              return $this->render('indexcliente');
            }
        }



    }

    public function actionCalculoc(){
            return $this->render('calculoc');
    }

    public function actionIndexvenda(){
            return $this->render('indexvenda');
    }

    public function actionIndexlocacao(){
            return $this->render('indexlocacao');
    }

    public function actionRelatorios()
    {

        if (Yii::$app->user->isGuest) {
            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }

            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }
            return $this->render('login', [
                'model' => $model,
            ]);
        } else {
            # code...
            return $this->render('relatorios');
        }



    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    /**
     *Busca o json Informações do Imóvel no Site
    */
    public function get_content($url, $expire = 0) {
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . sha1($url);

        if (file_exists($file) && (time() - $expire < filemtime($file))) {
            return file_get_contents($file);
        } else {
            $content = file_get_contents($url);
            file_put_contents($file, $content, LOCK_EX);
            return $content;
        }
    }

    public function get_imovel($codigo){
        $json_imoveis = $this->get_content('http://www.jetimob.com/services/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/imoveis/',864000);
        $imoveis = json_decode($json_imoveis);

        foreach ($imoveis as $e) {
            if ($e->codigo == trim($codigo)) {
                $imovel = $e;
                break;
            }            
        }

        return $imovel;
    }

    public function actionValida(){
        $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_STRING);


        $identity = Usuario::findOne(['email' => $email]);


        if(count($identity) > 0){
            if (Yii::$app->user->login($identity)) {
              // echo 'logou - '.Yii::$app->user->identity->username;
              return $this->goHome();
              // return 1;
            }else{
              return 0;
            }
        }
    }

    public function actionRecebefromsite() {
    	header('Content-Type: text/html; charset=utf-8');// para formatar corretamente os acentos
        // Takes raw data from the request
        $json = file_get_contents('php://input');

        // Converts it into a PHP object
        $data = json_decode($json);
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function actionAvisolido() {
        $id = $_REQUEST['id'];
        $aviso = new \app\models\Userhistvisto();
        $aviso->historico_id = $id;
        $aviso->usuario_id = Yii::$app->user->identity->id;
        $aviso->visto = 1;
        $aviso->data = date("Y-m-d H:i:s");
        $aviso->save();
    }
}
