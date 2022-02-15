<?php

namespace app\controllers;

use Yii;
use app\models\Disparoswh;
use app\models\DisparoswhSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Histdispmulti;

/**
 * DisparoswhController implements the CRUD actions for Disparoswh model.
 */
class DisparoswhController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access'=> [
                'class' => AccessControl::className(),
                //'only' => ['create','delete','update'],
                'rules' => [
                    ['actions' => ['update'], 'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['create'], 'allow' => true,   'roles' => ['faturas-create']],
                    ['actions' => ['index'], 'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => [
                        'view', 
                        'addcelular',
                        'addcelulares',
                        'gravahistorico',
                        'excluinumero'
                    ], 'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['delete'], 'allow' => true,   'roles' => ['faturas-delete']],
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
     * Lists all Disparoswh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DisparoswhSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Disparoswh model.
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
     * Creates a new Disparoswh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Disparoswh();

        if ($model->load(Yii::$app->request->post())) {
            $numeros = $_POST['Disparoswh']['numeros'];
            if($numeros != ''){
                $str_numeros = '';
                $i = 0;
                foreach ($numeros as $key => $value) {
                    $str_numeros .= $value;
                    $i++;
                    if($i < count($numeros)){
                      $str_numeros .= ';';
                    }
                }
                if($str_numeros !== '' and !empty($str_numeros)) {
                    $model->numeros = $str_numeros;
                }
            }
            // exit();
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Disparoswh model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Disparoswh model.
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
     * Finds the Disparoswh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Disparoswh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Disparoswh::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function clean($string) {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
        return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
    }

    protected function cleansonumeros($string) {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^0-9\-]/', '', $string); // Removes special chars.
 
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

    public function actionAddcelular($id) {
        $model = $this->findModel($id);
        // print_r($_REQUEST['celular_'.$id]);
        $model->numeros = $model->numeros.';'.$this->clean($_REQUEST['celular_'.$id]);
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionAddcelulares($id) {
        $model = $this->findModel($id);
        // echo $_REQUEST['celulares_'.$id];
        $novos = explode(';', $_REQUEST['celulares_'.$id]);
        // echo '<pre>';
        // print_r($novos);
        // echo '</pre>';
        $novos_numeros = "";
        $i = 1;
        foreach ($novos as $row) {
            // echo $this->cleansonumeros($row).'<br>';
            $num = $this->cleansonumeros($row);
            $num = trim($num);
            if (!empty($num) and $num !== '') {
                $novos_numeros .= $num.';';
            }
        }
        // echo 'i: '.$i.'<br>conta: '.substr($novos_numeros, -1).'<hr>';
        $novos_numeros = substr($novos_numeros, 0, -1);
        // echo $novos_numeros;
        if ($model->numeros !== '' && !empty($model->numeros)) {
            $model->numeros = $model->numeros.';'.$novos_numeros;
        } else {
            $model->numeros = $novos_numeros;
        }
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionGravahistorico() {
        $historico = new Histdispmulti();
        // echo '<pre>';
        // print_r($_REQUEST);
        // echo '</pre>';
        $disparos_id = $_REQUEST['disparo_id'];
        $data = date('Y-m-d h:i:s');
        $numeros = $_REQUEST['numeros'];
        $mensagem = $_REQUEST['mensagem'];

        $historico->disparos_id = $disparos_id;
        $historico->data = date('Y-m-d h:i:s');
        $historico->numeros = $numeros;
        $historico->mensagem = $mensagem;
        $historico->usuario_id = Yii::$app->user->identity->id;
        
        if ($historico->save()) {
            echo 'registro gravado';
        } else {
            echo 'registro não gravado';
        }

        // $historico->save();
    }
    public function actionExcluinumero() {
        $id = $_REQUEST['id'];
        $nm = $_REQUEST['numero'];
        $disparo = $this->findModel($id);
        // echo $disparo->numeros;
        // echo '<hr>';
        
        // $pos = strpos($disparo->numeros, ';'.$nm);
        // if ($pos === false) {
        //     $novo_numeros = str_replace($nm.';', "", $disparo->numeros);
        // } else {
        //     $novo_numeros = str_replace(';'.$nm, "", $disparo->numeros);
        // }
        $arr_numeros = explode(';', trim($disparo->numeros));
        $novo_numeros = '';
        foreach ($arr_numeros as $row) {
            if ($row == $nm) {
                echo "numero excluido: $row <br>";
            } else {
                $novo_numeros .= $row.';';
            }
        }
        // echo '<pre>';
        // print_r($arr_numeros);
        // echo '</pre>';
        // echo $disparo->numeros;
        // echo '<hr>';
        // echo $novo_numeros;
        $novo_numeros = substr($novo_numeros, 0, -1);
        $disparo->numeros = $novo_numeros;
        $disparo->save();

        return $this->redirect(['index']);

    }
}
