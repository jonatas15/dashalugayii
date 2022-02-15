<?php

namespace app\controllers;

use Yii;
use app\models\Locatario;
use app\models\LocatarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Usuario;

/**
 * LocatarioController implements the CRUD actions for Locatario model.
 */
class LocatarioController extends Controller
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
                    ['actions' => ['update'],  'allow' => true,   'roles' => ['locatario-update']],
                    ['actions' => ['create'],  'allow' => true,   'roles' => ['locatario-create']],
                    ['actions' => ['index'],   'allow' => true,   'roles' => ['locatario-create']],
                    ['actions' => ['view'],    'allow' => true,   'roles' => ['locatario-create']],
                    ['actions' => ['delete'],  'allow' => true,   'roles' => ['locatario-delete']],
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
     * Lists all Locatario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LocatarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Locatario model.
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
     * Creates a new Locatario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Locatario();

        if ($model->load(Yii::$app->request->post())) {
            $auth = \Yii::$app->authManager;
            $usuario = new Usuario();
            
            $usuario->nome = $model->nome;
            $usuario->username = $model->cpf;
            $usuario->password = sha1($model->cpf);
            $usuario->tipo = 'locatario';

            if($usuario->save()):
                $model->usuario_id = $usuario->id;
                $auth->assign($auth->getRole('locatario'),$usuario->id);
            endif;
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Locatario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Locatario model.
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
     * Finds the Locatario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Locatario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Locatario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
