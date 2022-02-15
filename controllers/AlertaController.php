<?php

namespace app\controllers;

use Yii;
use app\models\SaAlerta;
use app\models\Usuario;
use app\models\Mail;
use app\models\AlertaSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\SaAlertausuarios as AlertUsers;

// Modificação no Arquivo pra testar o GIT mesmo!

/**
 * AlertaController implements the CRUD actions for SaAlerta model.
 */
class AlertaController extends Controller
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
                    ['actions' => ['update'],           'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['create'],           'allow' => true,   'roles' => ['faturas-create']],
                    ['actions' => [
                        'index', 
                        'dispara',
                        'sendwhats'
                    ], 'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['view'],             'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['delete'],           'allow' => true,   'roles' => ['faturas-delete']],
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

    /**
     * Lists all SaAlerta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SaAlerta model.
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
     * Creates a new SaAlerta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    private function formata_datetime($data) {
        $model_data_inicio = explode('/',$data);
        $model_data_inicio2 = explode(' ',$model_data_inicio[2]);
        
        return $model_data_inicio2[0].'-'.$model_data_inicio[1].'-'.$model_data_inicio[0].' '.$model_data_inicio2[1] ;
    }

    public function actionCreate()
    {
        $model = new SaAlerta();

        if ($model->load(Yii::$app->request->post())) {
            if($model->saAlertausuarios){

            }

            // echo $model->data_inicio;
            // echo ' '.$_REQUEST['t1'];
            // echo ' '.$_REQUEST['t2'];
            // exit();


            $req_t1 = $_REQUEST['t1'];
            $req_t2 = $_REQUEST['t2'];

            $model->data_inicio = $this->formata_datetime($model->data_inicio.' '.$req_t1);
            $model->data_limite = $this->formata_datetime($model->data_limite.' '.$req_t2);
           
            if ($model->save()) {

                $uruario_autor = new AlertUsers();
                $uruario_autor->sa_alerta_id = $model->id;
                $uruario_autor->usuario_id = $model->usuario_id;
                $uruario_autor->save();

                $req_users = $_REQUEST['SaAlerta']['alertaopovo'];
                if ($req_users != '' and count($req_users) > 0) {

                    foreach ($req_users as $u) {
                        $user = new AlertUsers();
                        $user->sa_alerta_id = $model->id;
                        $user->usuario_id = $u;
                        $user->save();
                        $usuario = Usuario::findOne(['id' => $u]);
                        
                        $assunto = 'Alerta: Café Inteligência Imobiliária';
                        $msg = "<h3>{$model->titulo}</h3>";
                        $msg.= "<sub>Categoria: {$model->categoria}</sub>";
                        $msg.= "<p>{$model->descricao}</p>";
                        
                        if(Mail::send($usuario->email, $assunto, $msg)){
                            $alerta_enviado .= "Sucesso: Atualização enviada para {$usuario->nome} - {$usuario->email} <br>";//'enviou!';                            
                        } else {
                            $alerta_enviado .= "Erro: Atualização não enviada para {$usuario->nome} - {$usuario->email} <br>";//'não enviou!';                            
                        }
                    }
                }
                Yii::$app->session->setFlash('info', 'Alertas enviados:<br>'.$alerta_enviado);
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SaAlerta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $categoria = $_REQUEST[$id.'-categoria'];
            if($categoria != ''){
                $model->categoria = $categoria;
            }
            
            $pretendente = $_REQUEST[$id.'-pretendente'];
            if($pretendente != ''){
                $model->pretendente = $pretendente;
            }

            $req_t1 = $_REQUEST['t1'];
            $req_t2 = $_REQUEST['t2'];

            $model->data_inicio = $this->formata_datetime($model->data_inicio.' '.$req_t1);
            $model->data_limite = $this->formata_datetime($model->data_limite.' '.$req_t2);
            
            if ($model->save()){

                $req_users = $_REQUEST['SaAlerta']['alertaopovo'];
                if ($req_users != '' and count($req_users) > 0) {
                    $avisados_anteriores = AlertUsers::find()->where(['sa_alerta_id'=>$model->id])->andwhere(['<>','usuario_id', $model->usuario_id])->all();
                    foreach ($avisados_anteriores as $value) {
                        AlertUsers::findOne($value->sa_alerta_id,$value->usuario_id)->delete();
                    }
                    foreach ($req_users as $u) {
                        $user = new AlertUsers();
                        $user->sa_alerta_id = $model->id;
                        $user->usuario_id = $u;
                        $user->save();
                    }
                } else {
                    $avisados_anteriores = AlertUsers::find()->where(['sa_alerta_id'=>$model->id])->andwhere(['<>','usuario_id', $model->usuario_id])->all();
                    foreach ($avisados_anteriores as $value) {
                        AlertUsers::findOne($value->sa_alerta_id,$value->usuario_id)->delete();
                    }
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SaAlerta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Dispara Alerta!
     */
    public function actionDispara($id){
        $model = $this->findModel($id);

        foreach ($model->saAlertausuarios as $key => $alert) {
            # code...
            # $user = new AlertUsers();
            # $user->sa_alerta_id = $model->id;
            # $user->usuario_id = $alert->usuario_id;
            # $user->save();

            $usuario = Usuario::findOne(['id' => $alert->usuario_id]);
            
            $assunto = 'Alerta: Café Inteligência Imobiliária';
            $msg = "<h3>{$model->titulo}</h3>";
            $msg .= "<sub>Categoria: {$model->categoria}</sub>";
            $msg .= "<p>{$model->descricao}</p>";
            
            if(Mail::send($usuario->email, $assunto, $msg)){
                $alerta_enviado .= "Sucesso: Atualização enviada para {$usuario->nome} - {$usuario->email}  <br>";//'enviou!';                            
            } else {
                $alerta_enviado .= "Erro: Atualização não enviada para {$usuario->nome} - {$usuario->email} <br>";//'não enviou!';                            
            }
        }

        Yii::$app->session->setFlash('info', 'Alertas enviados:<br>'.$alerta_enviado);
        return $this->redirect(['index']);

    }

    /**
     * Finds the SaAlerta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SaAlerta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SaAlerta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // ChatPro API ===============================================================================================
    public function actionSendwhats() {
        $ch = curl_init();

        
        $endpoint = "v4.chatpro.com.br/chatpro-nju002x5lu";
        $token = 'b78c3f7d9bc6e9b45c914f212ae8af18ac86e2e1';
        $mensagem = $_REQUEST['msg'];
        $numero = $_REQUEST['num'];

        // curl_setopt($ch, CURLOPT_URL, "https://${endpoint}/api/v1/reload");
        
        curl_setopt($ch, CURLOPT_URL, "https://${endpoint}/api/v1/send_message");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"menssage\": \"${mensagem}\", \"number\": \"${numero}\"}");
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: ${token}";
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            echo 'Envio concluido com sucesso';
        }

        curl_close($ch);

        return $this->redirect(Yii::$app->request->referrer);

    }
}
