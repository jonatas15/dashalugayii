<?php

namespace app\controllers;

use Yii;
use app\models\Proprietario;
use app\models\ProprietarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProprietarioController implements the CRUD actions for Proprietario model.
 */
class ProprietarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Proprietario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProprietarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Proprietario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Proprietario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('administrador') or Yii::$app->user->can('locacao') or Yii::$app->user->can('corretor')) {
            $model = new Proprietario();

            if ($model->load(Yii::$app->request->post())) {
                echo '<pre>';
                print_r($_REQUEST);
                echo '</pre>';
                $model->data_nascimento = $this->formatar_data_pro_banco($model->data_nascimento);
                $model->inicio_locacao = $this->formatar_data_pro_banco($model->inicio_locacao);
                if ( $model->save()) {
                    
                    #==========================================================================================================
                    #==========================================================================================================
                    // Envia Proprietario para o Superlógica
                    $ch = curl_init("http://apps.superlogica.net/imobiliaria/api/proprietarios/put");

                    //curl_setopt($ch, CURLOPT_URL, "http://apps.superlogica.net/imobiliaria/api/proprietarios");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_POST, true);

                    $a_enviar = json_encode('{
                        "ST_NOME_PES": "'.$model->nome.'",
                        "ST_FANTASIA_PES": "'.$model->nome.'",
                        "ST_CNPJ_PES": "'.$model->cpf_cnpj.'",
                        "ST_CELULAR_PES": "'.$this->clean($model->celular).'",
                        "ST_TELEFONE_PES": "'.$this->clean($model->telefone).'",
                        "ST_EMAIL_PES": "'.$model->email.'",
                        "ST_RG_PES": "'.$model->rg.'",
                        "ST_ORGAO_PES": "'.$model->orgao.'",
                        "ST_SEXO_PES": "'.($model->sexo == 'M'?1:2).'",
                        "DT_NASCIMENTO_PES": "'.date("d/m/Y", strtotime($model->data_nascimento)).'",
                        "ST_NACIONALIDADE_PES": "'.$model->nacionalidade.'",
                        "ST_CEP_PES": "'.$this->clean($model->cep).'",
                        "ST_ENDERECO_PES": "'.$model->endereco.'",
                        "ST_NUMERO_PES": "'.$model->numero.'",
                        "ST_COMPLEMENTO_PES": "'.$model->complemento.'",
                        "ST_BAIRRO_PES":"'.$model->bairro.'",
                        "ST_CIDADE_PES": "'.$model->cidade.'",
                        "ST_ESTADO_PES": "'.$model->estado.'",
                        "ST_OBSERVACAO_PES": "'.$model->mais_informacoes.'"
                    }');
                    // echo $a_enviar;
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_decode($a_enviar));

                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        "Content-Type: application/json",
                        "app_token: 86f34537-5693-3c40-a60d-754b3c5b9fa8",
                        "access_token: d615ff2c-35bc-3855-8a44-c231c920fc4c"
                    ));

                    $response = curl_exec($ch);
                    curl_close($ch);
                    #==========================================================================================================
                    #==========================================================================================================

                    var_dump($response);
                    exit();
                    // return $this->redirect(Yii::$app->request->referrer);
                } else {
                    echo 'deu ruim';
                }
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function formatar_data_pro_banco($data) {
        $arr = explode('/',$data);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }
    protected function clean($string) {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
        return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
     }

    /**
     * Updates an existing Proprietario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Proprietario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Proprietario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proprietario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proprietario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
