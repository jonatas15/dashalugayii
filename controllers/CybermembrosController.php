<?php

namespace app\controllers;

use Yii;
use app\models\CyberMembros;
use app\models\CybermembrosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CybermembrosController implements the CRUD actions for CyberMembros model.
 */
class CybermembrosController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all CyberMembros models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CybermembrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CyberMembros model.
     * @param integer $cyber_idcyber
     * @param integer $usuario_id
     * @return mixed
     */
    public function actionView($cyber_idcyber, $usuario_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cyber_idcyber, $usuario_id),
        ]);
    }

    /**
     * Creates a new CyberMembros model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CyberMembros();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cyber_idcyber' => $model->cyber_idcyber, 'usuario_id' => $model->usuario_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CyberMembros model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $cyber_idcyber
     * @param integer $usuario_id
     * @return mixed
     */
    public function actionUpdate($cyber_idcyber, $usuario_id)
    {
        $model = $this->findModel($cyber_idcyber, $usuario_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cyber_idcyber' => $model->cyber_idcyber, 'usuario_id' => $model->usuario_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CyberMembros model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $cyber_idcyber
     * @param integer $usuario_id
     * @return mixed
     */
    public function actionDelete($cyber_idcyber, $usuario_id)
    {
        $this->findModel($cyber_idcyber, $usuario_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CyberMembros model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $cyber_idcyber
     * @param integer $usuario_id
     * @return CyberMembros the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cyber_idcyber, $usuario_id)
    {
        if (($model = CyberMembros::findOne(['cyber_idcyber' => $cyber_idcyber, 'usuario_id' => $usuario_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
