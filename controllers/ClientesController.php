<?php

namespace app\controllers;

use Yii;
use app\models\Clientes;
use app\models\ClientesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * ClientesController implements the CRUD actions for Clientes model.
 */
class ClientesController extends Controller
{
    //Limpa caracteres especiais

    protected function clean($string) {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
        return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
     }
 
     public function format_telefone($fone){
         $f = str_split($fone,1);
         $ddd = $f[0].$f[1];
         $g1 = '';
         if(count($f) == 11){
           $g1 = $f[2].' '.$f[3].$f[4].$f[5].$f[6].'-'.$f[7].$f[8].$f[9].$f[10];
         }else{
           $g1 = $f[2].$f[3].$f[4].$f[5].'-'.$f[6].$f[7].$f[8].$f[9];
         }
         return '('.$ddd.') '.$g1;
     }
    /**
     * {@inheritdoc}
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
     * Lists all Clientes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clientes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clientes();

        if ($model->load(Yii::$app->request->post())) {
            $model->cpf = $this->clean($model->cpf);
            $model->fone1 = $this->clean($model->fone1);
            $model->fone2 = $this->clean($model->fone2);
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Clientes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->cpf = $this->clean($model->cpf);
            $model->fone1 = $this->clean($model->fone1);
            $model->fone2 = $this->clean($model->fone2);
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Clientes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clientes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionEditregistro () {
        $id = $_REQUEST['editableKey'];
        $edit = $_REQUEST['editableIndex'];
        $valor = $_REQUEST['Clientes'][$edit]['corretor'];
        $corretor = \app\models\Corretor::find()->where(['usuario_id' => Yii::$app->user->identity->id])->one();
        $model = $this->findModel($id);
        // echo $corretor->idcorretor;
        if ($valor == 1) {
            $model->corretor = $corretor->idcorretor;
        } elseif ($valor == 0) {
            $model->corretor = null;
        }
        $model->save();
        echo 1;
        // if () {
            
        // }

    }

    public function cadastra($setor, $cargo, $cpf, $nome, $email, $proventos, $fone1, $fone2) {
        echo ($setor .' - '. $cargo .' - '. $cpf .' - '. $nome .' - '. $email .' - '. $proventos .' - '. $fone1 .' - '. $fone2.'<hr>');
        $cliente = new Clientes();
        $cliente->setor = $setor;
        $cliente->cargo = $cargo;
        $cliente->cpf = $this->clean($cpf);
        $cliente->nome = $nome;
        $cliente->email = $email;
        $cliente->proventos = $proventos;
        $cliente->fone1 = $this->clean($fone1);
        $cliente->fone2 = $this->clean($fone2);
        $cliente->save();
    }

    public function actionUpload() {

        $model = new Clientes();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            // if ($model->upload()) {
                // file is uploaded successfully
            $model->upload();

            if (file_exists(Yii::$app->basePath.'/web/planilias/'. 'excel.xlsx')) {
                echo 'existe! <hr>';
                $objPHPExcel = \PHPExcel_IOFactory::load(Yii::$app->basePath.'/web/planilias/'. 'excel.xlsx');
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                // echo '<pre>';
                // print_r($sheetData);
                // echo '</pre>';
                foreach ($sheetData as $key => $value) {
                    if ($key != '1') {
                        // echo $value['E'].'<br>';
                        $this->cadastra($value['B'], $value['C'], $value['D'], $value['E'], $value['F'], $value['G'], $value['H'], $value['I']);
                    }
                }
            }

            return $this->redirect(['index']);
        }

        
    }
}
