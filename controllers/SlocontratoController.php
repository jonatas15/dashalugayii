<?php

namespace app\controllers;

use Yii;
use app\models\Slocontrato;
use app\models\SlocontratoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
/**
 * SlocontratoController implements the CRUD actions for Slocontrato model.
 */
class SlocontratoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access'=> [
                'class' => AccessControl::className(),
                //'only' => ['create','delete','update'],
                'rules' => [
                      ['actions' => ['update'],       'allow' => true,   'roles' => ['faturas-update']],
                      ['actions' => ['editcampo'],    'allow' => true,   'roles' => ['faturas-update']],
                      ['actions' => ['create'],       'allow' => true,   'roles' => ['faturas-create']],
                      ['actions' => ['novo'],         'allow' => true,   'roles' => ['faturas-create']],
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
     * Lists all Slocontrato models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SlocontratoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slocontrato model.
     * @param integer $id
     * @param integer $proposta_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $proposta_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $proposta_id),
        ]);
    }

    /**
     * Creates a new Slocontrato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Slocontrato();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'proposta_id' => $model->proposta_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Slocontrato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $proposta_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $proposta_id)
    {
        $model = $this->findModel($id, $proposta_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'proposta_id' => $model->proposta_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Slocontrato model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $proposta_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $proposta_id)
    {
        $this->findModel($id, $proposta_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Slocontrato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $proposta_id
     * @return Slocontrato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $proposta_id)
    {
        if (($model = Slocontrato::findOne(['id' => $id, 'proposta_id' => $proposta_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
