<?php

namespace app\controllers;

use Yii;
use app\models\SloCliente;
use app\models\SloclienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * SloclienteController implements the CRUD actions for SloCliente model.
 */
class SloclienteController extends Controller
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
                    ['actions' => ['index'],        'allow' => true,   'roles' => ['faturas-indexa']],
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

    /**
     * Lists all SloCliente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SloclienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SloCliente model.
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
     * Creates a new SloCliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SloCliente();

        if ($model->load(Yii::$app->request->post())) {
            $model->data_nascimento = date("Y-m-d", strtotime($model->data_nascimento));
            if ($model->save()) {
                # code...
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SloCliente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->data_nascimento = date("Y-m-d", strtotime($model->data_nascimento));
            if ($model->save()) {
                # code...
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SloCliente model.
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
     * Finds the SloCliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SloCliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SloCliente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
