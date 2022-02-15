<?php

namespace app\controllers;

use Yii;
use app\models\Extrato;
use app\models\ExtratoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ExtratoController implements the CRUD actions for Extrato model.
 */
class ExtratoController extends Controller
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
                    ['actions' => ['update'],  'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['create'],  'allow' => true,   'roles' => ['faturas-create']],
                    ['actions' => ['index'],   'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['view'],    'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['delete'],  'allow' => true,   'roles' => ['faturas-delete']],
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
     * Lists all Extrato models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExtratoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //Progrma tela dos extratos de acordo com o nível do Usuário
        switch (Yii::$app->user->identity->tipo) {
            case 'administrador':
                $render = 'index';
                break;
            case 'proprietario':
                $render = 'indexprop';
                break;
            case 'locatario':
                $render = 'indexloc';
                break;
            
            default:
                $render = 'index';
                break;
        }

        return $this->render($render, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    

    /**
     * Displays a single Extrato model.
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
     * Creates a new Extrato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    private function formatadataprobanco($datarecebida){
        $ar = explode('/', $datarecebida);
        $data_ini = $ar[2].'-'.$ar[1].'-'.$ar[0];
        return $data_ini;
    }
    public function actionCreate()
    {
        $model = new Extrato();

        if ($model->load(Yii::$app->request->post())) {
            
            $model->data_aplicacao = $this->formatadataprobanco($model->data_aplicacao);
            $model->data_vencimento = $this->formatadataprobanco($model->data_vencimento);
            $model->data_pagamento = $this->formatadataprobanco($model->data_pagamento);

            if($model->save())
                return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Extrato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->data_aplicacao = $this->formatadataprobanco($model->data_aplicacao);
            $model->data_vencimento = $this->formatadataprobanco($model->data_vencimento);
            $model->data_pagamento = $this->formatadataprobanco($model->data_pagamento);
            if($model->save())
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Extrato model.
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
     * Finds the Extrato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Extrato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Extrato::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
