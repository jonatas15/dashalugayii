<?php

namespace app\controllers;

use Yii;
use app\models\Cyber;
use app\models\CyberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CyberController implements the CRUD actions for Cyber model.
 */
class CyberController extends Controller
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
                    ['actions' => ['index'],            'allow' => true,   'roles' => ['faturas-indexa']],
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
     * Lists all Cyber models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CyberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cyber model.
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
     * Creates a new Cyber model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cyber();

        if ($model->load(Yii::$app->request->post())) {
            $post_tags = $_POST['Cyber']['palavraschaves'];
            if($post_tags != ''){
                $palavraschaves = '';
                $i = 0;
                foreach ($post_tags as $key => $value) {
                    $palavraschaves .= $value;
                    $i++;
                    if($i < count($post_tags)){
                      $palavraschaves .= ';';
                    }
                }
                $model->palavraschaves = $palavraschaves;
            }
            $model->datetime = date('Y-m-d H:i:s');
            if ($model->save()){
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cyber model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){

      $model = $this->findModel($id);
      if ($model->load(Yii::$app->request->post())) {

          if($_POST['Cyber']['palavraschaves'] != ''){
            $palavraschaves = '';
            $i = 0;
            $post_tags = $_POST['Cyber']['palavraschaves'];
            foreach ($post_tags as $key => $value) {
              $palavraschaves .= $value;
              $i++;
              if($i < count($post_tags)){
                $palavraschaves .= ';';
              }
            }
            $model->palavraschaves = $palavraschaves;

          }elseif ($_POST["$id-palavraschaves"]) {

            $palavraschaves = '';
            $i = 0;
            $post_tags = $_POST["$id-palavraschaves"];
            foreach ($post_tags as $key => $value) {
              $palavraschaves .= $value;
              $i++;
              if($i < count($post_tags)){
                $palavraschaves .= ';';
              }
            }
            $model->palavraschaves = $palavraschaves;
          }
          if ($_POST["$id-cor"]) {
              $model->cor = $_POST["$id-cor"];
          }
          // $model->datetime = date('Y-m-d H:i:s');
          if ($model->save()){
            // return $this->redirect(['index');
            // echo \yii\helpers\Html::a( 'Back', Yii::$app->request->referrer);
            // Yii::app()->request->urlReferrer;
            return $this->redirect(Yii::$app->request->referrer);

          }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cyber model.
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
     * Finds the Cyber model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cyber the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = Cyber::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
