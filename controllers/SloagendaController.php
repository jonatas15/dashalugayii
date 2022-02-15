<?php

namespace app\controllers;

use Yii;
use app\models\SloAgenda;
use app\models\SloagendaSearch;

use app\models\Corretor;
use app\models\SloCliente;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
//Agenda do Google:
use bitcko\googlecalendar\GoogleCalendarApi;

/**
 * SloagendaController implements the CRUD actions for SloAgenda model.
 */
class SloagendaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
          'access'=> [
              'class' => AccessControl::className(),
              //'only' => ['create','delete','update'],
              'rules' => [
                      ['actions' => ['update'],       'allow' => true,   'roles' => ['faturas-update']],
                      ['actions' => ['editregistro'], 'allow' => true,   'roles' => ['faturas-update']],
                      ['actions' => ['create'],       'allow' => true,   'roles' => ['faturas-create']],
                      ['actions' => ['index'],        'allow' => true,   'roles' => [
                        'faturas-indexa', 
                        'cliente-indexa'
                      ]],
                      ['actions' => ['agenda', 'desagendar', 'agendar'],       'allow' => true,   'roles' => [
                        'faturas-indexa', 
                        'cliente-indexa'
                      ]],
                      ['actions' => ['auth'],         'allow' => true,   'roles' => ['faturas-indexa']],
                      ['actions' => ['calendarslist'],'allow' => true,   'roles' => ['faturas-indexa']],
                      ['actions' => ['view'],         'allow' => true,   'roles' => ['faturas-indexa']],
                      ['actions' => ['cruzamento'],   'allow' => true,   'roles' => ['faturas-indexa']],
                      ['actions' => ['delete'],       'allow' => true,   'roles' => ['faturas-delete']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAuth(){

        $redirectUrl = Url::to(['/google-api/auth'],true);
        $calendarId = 'primary';
        $username="any_name";
        $googleApi = new GoogleCalendarApi($username,$calendarId,$redirectUrl);
        if(!$googleApi->checkIfCredentialFileExists()){
            $googleApi->generateGoogleApiAccessToken();
        }
        \Yii::$app->response->data = "Google api authorization done";
    }
    public function actionCalendarslist(){
        $calendarId = 'primary';
        $username="any_name";
        $googleApi = new GoogleCalendarApi($username,$calendarId);
        if($googleApi->checkIfCredentialFileExists()){
             $calendars =    $googleApi->calendarList();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            \Yii::$app->response->data = $calendars;
            return $this->render('calendarslist', [
                'calendars' => $calendars,
            ]);
        }else{
            return $this->redirect(['auth']);
        }
    }

    /**
     * Lists all SloAgenda models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('administrador') or Yii::$app->user->can('corretor')){
          $searchModel = new SloagendaSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          // return $this->render('index', [
          //     'searchModel' => $searchModel,
          //     'dataProvider' => $dataProvider,
          // ]);  

          $searchModel = new SloagendaSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          return $this->render('agenda', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
          ]);

        }
        elseif(Yii::$app->user->can('cliente')) {
          return $this->render('agendacliente', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_cliente_logado' => Yii::$app->user->identity->id,
          ]);
        }
    }

    /**
     * Lists all SloAgenda models.
     * @return mixed
     */
    public function actionAgenda()
    {
        $searchModel = new SloagendaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('agenda', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SloAgenda model.
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
     * Creates a new SloAgenda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SloAgenda();

        if ($model->load(Yii::$app->request->post())) {
            $i = $_REQUEST['indice'];
            # Antigo ou Novo Corretor
            $o_corretor = $_REQUEST[$i.'-o_corretor'];
            if (is_numeric($o_corretor)) {
                $model->corretor_idcorretor = $o_corretor;
            }else{
                $novocorretor = new Corretor;
                $novocorretor->nome = $o_corretor;
                $novocorretor->usuario_id = Yii::$app->user->identity->id;
                $novocorretor->save();
                $model->corretor_idcorretor = $novocorretor->idcorretor;
            }
            # Antigo ou Novo Cliente
            $o_cliente = $_REQUEST[$i.'-o_cliente'];
            if (is_numeric($o_cliente)) {
                $model->slo_cliente_id = $o_cliente;
            }else{
                $novocliente = new SloCliente();
                $novocliente->nome = $o_cliente;
                $novocliente->usuario_id = Yii::$app->user->identity->id;
                $novocliente->save();
                $model->slo_cliente_id = $novocliente->id;
            }
            # Define a Proposta
            $a_proposta = $_REQUEST[$i.'-a_proposta'];
            $model->slo_proposta_id = $a_proposta;

            // $model->datetime = date('Y-m-d H:i:s');
            $model->data = date("Y-m-d", strtotime($model->data));
            $model->hora = date("H:i:s", strtotime($model->hora));
            if ($model->save()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SloAgenda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SloAgenda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDesagendar($id) {
        $model = $this->findModel($id);
        $model->slo_cliente_id = null;
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAgendar($id, $cliente) {
        $model = $this->findModel($id);
        $model->slo_cliente_id = $cliente;
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the SloAgenda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SloAgenda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = SloAgenda::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
