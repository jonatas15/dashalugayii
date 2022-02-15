<?php

namespace app\controllers;

use Yii;
use app\models\TopicoMembros;
use app\models\TopicomembrosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TopicomembrosController implements the CRUD actions for TopicoMembros model.
 */
class TopicomembrosController extends Controller
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
     * Lists all TopicoMembros models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TopicomembrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TopicoMembros model.
     * @param integer $topico_idtopico
     * @param integer $usuario_id
     * @return mixed
     */
    public function actionView($topico_idtopico, $usuario_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($topico_idtopico, $usuario_id),
        ]);
    }

    /**
     * Creates a new TopicoMembros model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TopicoMembros();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'topico_idtopico' => $model->topico_idtopico, 'usuario_id' => $model->usuario_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TopicoMembros model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $topico_idtopico
     * @param integer $usuario_id
     * @return mixed
     */
    public function actionUpdate($topico_idtopico, $usuario_id)
    {
        $model = $this->findModel($topico_idtopico, $usuario_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'topico_idtopico' => $model->topico_idtopico, 'usuario_id' => $model->usuario_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TopicoMembros model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $topico_idtopico
     * @param integer $usuario_id
     * @return mixed
     */
    public function actionDelete($topico_idtopico, $usuario_id)
    {
        $this->findModel($topico_idtopico, $usuario_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TopicoMembros model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $topico_idtopico
     * @param integer $usuario_id
     * @return TopicoMembros the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($topico_idtopico, $usuario_id)
    {
        if (($model = TopicoMembros::findOne(['topico_idtopico' => $topico_idtopico, 'usuario_id' => $usuario_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
