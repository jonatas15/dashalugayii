<?php

namespace app\controllers;

use Yii;
use app\models\Mensagem;
use app\models\MensagemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MensagemController implements the CRUD actions for Mensagem model.
 */
class MensagemController extends Controller
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
     * Lists all Mensagem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MensagemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mensagem model.
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
     * Creates a new Mensagem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mensagem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mensagem model.
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
     * Deletes an existing Mensagem model.
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
        Ajax Form
    */
    public function actionAjaxComment($ativo){
        $model = new Mensagem();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if ($model->load(Yii::$app->request->post())) {
                $model->data = date('Y-m-d H:i:s');
                if ($model->save()) {
                    $conversa = \app\models\Mensagem::find()->where([
                        'proposta_id'=>$model->proposta_id,
                    ])->orderBy(['id' => SORT_ASC])->all();

                    $historico = '';
                    if (count($conversa) > 0) {
                        $historico .= '';
                        foreach ($conversa as $row) {
                            if ($ativo == 'admin') {
                                $balao = ($row->usuario_id != '') ? '1' : '2' ;
                            } else {
                                $balao = ($row->usuario_id != '') ? '2' : '1' ;
                            }
                            
                            $historico .= '<div class="col-md-12 balao-'.$balao.'">';
                            $historico .= '<sup class="data-msg">'.$row->data.'</sup>';
                            $historico .= '<span>'.$row->texto.'</span>';
                            $historico .= '</div>';
                            $historico .= '<div class="clearfix"></div>';
                        }
                        $historico .= '<hr>';
                    }
                    return [
                        'data' => [
                            'success' => true,
                            'model' => $model,
                            'message' => $historico,
                        ],
                        'code' => 0,
                    ];
                }
            } else {
                return [
                    'data' => [
                        'success' => false,
                        'model' => null,
                        'message' => 'An error occured.',
                    ],
                    'code' => 1, // Some semantic codes that you know them for yourself
                ];
            }
        }
    }
    public function actionAjaxcommentadmin(){
        $proposta_id = $_REQUEST['proposta_id'];
        $ativo = $_REQUEST['ativo'];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $conversa = \app\models\Mensagem::find()->where([
                'proposta_id'=>$proposta_id,
            ])->orderBy(['id' => SORT_ASC])->all();

            $historico = '';
            if (count($conversa) > 0) {
                $historico .= '';
                foreach ($conversa as $row) {
                    if ($ativo == 'admin') {
                        $balao = ($row->usuario_id != '') ? '1' : '2' ;
                    } else {
                        $balao = ($row->usuario_id != '') ? '2' : '1' ;
                    }
                    
                    $historico .= '<div class="col-md-12 balao-'.$balao.'">';
                    $historico .= '<sup class="data-msg"><b>'.$row->usuario->nome.'</b>: '.$row->data.'</sup>';
                    $historico .= '<span>'.$row->texto.'</span>';
                    $historico .= '</div>';
                    $historico .= '<div class="clearfix"></div>';
                }
                $historico .= '<hr>';
            }
            return [
                'data' => [
                    'success' => true,
                    'message' => $historico,
                ],
                'code' => 0,
            ];
        } else {
            return [
                'data' => [
                    'success' => false,
                    'model' => null,
                    'message' => 'An error occured.',
                ],
                'code' => 1, // Some semantic codes that you know them for yourself
            ];
        }
    }

    /**
     * Finds the Mensagem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mensagem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mensagem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
