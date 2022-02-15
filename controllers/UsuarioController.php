<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
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
            'access'=> [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['update'],  'allow' => true,    'roles' => ['usuario-update']],
                    ['actions' => ['create'],  'allow' => true,    'roles' => ['usuario-create']],
                    ['actions' => ['index'],   'allow' => true,    'roles' => ['usuario-indexa']],
                    ['actions' => ['view'],    'allow' => true,    'roles' => ['usuario-indexa']],
                    ['actions' => ['delete'],  'allow' => true,    'roles' => ['usuario-delete']]
                ],
            ],
        ];
    }

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
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
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();

        if ($model->load(Yii::$app->request->post())) {
            $model->password = sha1($model->password);
            $model->arquivoimagem = UploadedFile::getInstance($model, 'arquivoimagem');
            if ($model->arquivoimagem)
              $model->foto = $model->arquivoimagem->baseName.'.'.$model->arquivoimagem->extension;

            if ($model->save()) {
                if ($model->arquivoimagem){
                    $model->upload();
                }
                //Foto
                //Permissões
                $auth = \Yii::$app->authManager;
                switch ($model->tipo) {
                    case 'admin': $auth->assign($auth->getRole('administrador'),$model->id); break;
                    case 'corretor': 
                        $auth->assign($auth->getRole('corretor'),$model->id); 
                        $novocorretor = new \app\models\Corretor;
                        $novocorretor->usuario_id = $model->id;
                        $novocorretor->nome = $model->nome;
                        $novocorretor->save();
                    break;
                    case 'vendas': $auth->assign($auth->getRole('vendas'),$model->id); break;
                    case 'locacao': $auth->assign($auth->getRole('locacao'),$model->id); break;
                    case 'cliente': $auth->assign($auth->getRole('cliente'),$model->id); break;
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // $model->password = sha1($model->password);
        if ($model->load(Yii::$app->request->post())) {
            if ($_REQUEST['nova_senha']){
                $model->password = sha1($_REQUEST['nova_senha']);
            }

            $model->arquivoimagem = UploadedFile::getInstance($model, 'arquivoimagem');
            if ($model->arquivoimagem)
                $model->foto = $model->arquivoimagem->baseName.'.'.$model->arquivoimagem->extension;

            if ($model->save()) {

                if ($model->arquivoimagem)
                    $model->upload();

                $auth = \Yii::$app->authManager;
                $auth->revokeAll($model->id);
                switch ($model->tipo) {
                    case 'admin': $auth->assign($auth->getRole('administrador'),$model->id); break;
                    case 'corretor': $auth->assign($auth->getRole('corretor'),$model->id); break;
                    case 'vendas': $auth->assign($auth->getRole('vendas'),$model->id); break;
                    case 'locacao': $auth->assign($auth->getRole('locacao'),$model->id); break;
                    case 'cliente': $auth->assign($auth->getRole('cliente'),$model->id); break;
                }
                return $this->redirect(['view', 'id' => $model->id]);

            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Usuario model.
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
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
