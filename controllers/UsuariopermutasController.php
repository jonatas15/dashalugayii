<?php

namespace app\controllers;

use Yii;
use app\models\Usuariopermutas;
use app\models\UsuariopermutasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuariopermutasController implements the CRUD actions for Usuariopermutas model.
 */
class UsuariopermutasController extends Controller
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
     * Lists all Usuariopermutas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariopermutasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAcompanharpermutas()
    {
        return $this->render('acompanharpermutas');
    }

    /**
     * Displays a single Usuariopermutas model.
     * @param integer $permuta
     * @param integer $usuario
     * @return mixed
     */
    public function actionView($permuta, $usuario)
    {
        return $this->render('view', [
            'model' => $this->findModel($permuta, $usuario),
        ]);
    }

    /**
     * Creates a new Usuariopermutas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuariopermutas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'permuta' => $model->permuta, 'usuario' => $model->usuario]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Usuariopermutas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $permuta
     * @param integer $usuario
     * @return mixed
     */
    public function actionUpdate($permuta, $usuario)
    {
        $model = $this->findModel($permuta, $usuario);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'permuta' => $model->permuta, 'usuario' => $model->usuario]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Usuariopermutas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $permuta
     * @param integer $usuario
     * @return mixed
     */
    public function actionDelete($permuta, $usuario)
    {
        $this->findModel($permuta, $usuario)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuariopermutas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $permuta
     * @param integer $usuario
     * @return Usuariopermutas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($permuta, $usuario)
    {
        if (($model = Usuariopermutas::findOne(['permuta' => $permuta, 'usuario' => $usuario])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
