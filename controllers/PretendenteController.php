<?php

namespace app\controllers;

use Yii;
use app\models\SloPretendente;
use app\models\PretendenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;

use app\models\Chtopico;
use app\models\Historico;

/**
 * PretendenteController implements the CRUD actions for SloPretendente model.
 */
class PretendenteController extends Controller
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
                    [
                        'actions' => [
                            'update',
                            'updpessoa',
                            'updprofissional',
                            'upddocumentacao',
                            'updrefbancaria',
                            'updmoratual',
                            'updocupante',
                            'report',
                            'imagempdf',
                            'processodelocacao',
                            'addtopicoch',
                            'novotopico',
                            'editregistro',
                        ],
                        'allow' => true,
                        'roles' => ['faturas-update']
                    ],
                    [
                        'actions' => [
                            'create',
                            'novomorador'
                        ],
                        'allow' => true,
                        'roles' => ['faturas-create']
                    ],
                    ['actions' => ['index'],            'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['view'],             'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['cruzamento'],       'allow' => true,   'roles' => ['faturas-indexa']],
                    [
                        'actions' => [
                            'delete',
                            'delete_ocupante',
                            'deletetopico'
                        ],
                        'allow' => true,
                        'roles' => ['faturas-delete']
                    ],
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
     * Lists all SloPretendente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PretendenteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SloPretendente model.
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
     * Creates a new SloPretendente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SloPretendente();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SloPretendente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    // Funções Auxiliares
    //Limpa caracteres especiais
    protected function clean($string) {

       $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.

    }
    // Formata os Telefones
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
    public function format_cpf($fone){
        $f = str_split($fone,3);
        return $f[0].'.'.$f[1].'.'.$f[2].'-'.$f[3];
    }

    public function format_cnpj($fone){
        $f = str_split($fone,1);
        return $f[0].$f[1].'.'.$f[2].$f[3].$f[4].'.'.$f[5].$f[6].$f[7].'/'.$f[8].$f[9].$f[10].$f[11].'-'.$f[12].$f[13];
    }

    public function format_real($valor){
        $valor = $this->clean($valor);
        return 'R$ '. number_format($valor,2,",",".");
    }

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
    public function actionUpdpessoa($id) {

        $model = \app\models\SloInfospessoais::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            $f = explode('/',$model->data_nascimento);
            $model->data_nascimento = $f[2].'-'.$f[1].'-'.$f[0];

            $model->cpf = $this->clean($model->cpf);

            if ($model->conj_fone_residencial != ''){
                $model->fone_residencial = $model->conj_fone_residencial;
            }
            if ($model->conj_celular != ''){
                $model->celular = $model->conj_celular;
            }
            if ($model->conj_genero != ''){
                $model->genero = $model->conj_genero;
            }

            $model->fone_residencial = $this->clean($model->fone_residencial);
            $model->celular = $this->clean($model->celular);


            if($model->genero == 0){$model->genero = 'M';}else{$model->genero = 'F';}

            if($model->nacionalidade == 0){$model->nacionalidade = 'brasileiro';}else{$model->nacionalidade = 'extrangeiro';}

            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->pretendente_id]);
            }

        }else{
            return $this->redirect(['view', 'id' => $model->pretendente_id]);
        }
    }
    public function actionUpdprofissional($id) {

        $model = \app\models\SloInfosprofissionais::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $f = explode('/',$model->data_admissao);
            $model->data_admissao = $f[2].'-'.$f[1].'-'.$f[0];

            $model->fone = $this->clean($model->fone);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->pretendente_id]);
            }
        }else{
            return $this->redirect(['view', 'id' => $model->pretendente_id]);
        }
    }
    public function actionUpddocumentacao($id) {

        $model = \app\models\SloContratodocumento::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->slo_pretendente_id]);
        }else{
            return $this->redirect(['view', 'id' => $model->slo_pretendente_id]);
        }
    }
    public function actionUpdrefbancaria($id) {

        $model = \app\models\SloRefbancaria::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->slo_pretendente_id]);
        }else{
            return $this->redirect(['view', 'id' => $model->slo_pretendente_id]);
        }
    }
    public function actionUpdmoratual($id) {

        $model = \app\models\SloMoratual::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->slo_pretendente_id]);
        }else{
            return $this->redirect(['view', 'id' => $model->slo_pretendente_id]);
        }
    }
    public function actionNovomorador() {
        $model = new \app\models\SloOcupante;
        if ($model->load(Yii::$app->request->post())){

            $model->cpf = $this->clean($model->cpf);
            $model->data_expedicao = str_replace('/','-', $model->data_expedicao);
            $model->data_expedicao = date('Y-m-d',strtotime($model->data_expedicao));
            $model->data_nascimento = str_replace('/','-', $model->data_nascimento);
            $model->data_nascimento = date('Y-m-d',strtotime($model->data_nascimento));

            if ($model->sexo == '') {
                $model->sexo = 'M';
            }
            if ($model->tipo_documento == '') {
                $model->tipo_documento = 'rg';
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->slo_pretendente_id]);
            }
        }
    }
    public function actionUpdocupante($id) {

        $model = \app\models\SloOcupante::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->sexo == 0){$model->sexo = 'M';}else{$model->sexo = 'F';}
            if ($model->tipo_documento == '') {
                $model->tipo_documento = 'rg';
            }
            $f = explode('/',$model->data_nascimento);
            $g = explode('/',$model->data_expedicao);
            $model->data_nascimento = $f[2].'-'.$f[1].'-'.$f[0];
            $model->data_expedicao = $g[2].'-'.$g[1].'-'.$g[0];
            $model->cpf = $this->clean($model->cpf);
            if ($model->save()) {
                # code...
                return $this->redirect(['view', 'id' => $model->slo_pretendente_id]);
            }
        }else{
            return $this->redirect(['view', 'id' => $model->slo_pretendente_id]);
        }
    }
    public function actionDelete_ocupante($id)
    {
        \app\models\SloOcupante::findOne($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);

    }
    /**
     * Deletes an existing SloPretendente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the SloPretendente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SloPretendente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SloPretendente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    // Gerar PDF

    public function actionReport($id,$proposta_id) {

        // Captura de Informações:


        // get your HTML raw content without any layouts or scripts
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        // $content = $this->renderPartial('report')
        // $content .= '<label class="lb-info">Nome: '.$pessoais->nome.'</label>';

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $this->renderPartial('report',['id'=>$id,'proposta_id'=>$proposta_id]),
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px} .lb-info{color:gray;text-transform:capitalize}
                table {
                  border-collapse: collapse;
                }
                table, th, td {
                  border: 1px solid black;
                }',
             // set mPDF properties on the fly
            'options' => ['title' => 'Formulário de Locação - Seguro Fiança'],
             // call mPDF methods on the fly
            'methods' => [
            // 'addPdfAttachment' => 'http://localhost/areacliente/web/uploads/propostasdocs/25_versodoc_SISTEMA.pdf',
                'SetHeader'=>['<h4 style="width: 100%; text-align: center;">Formulário de Locação - Seguro Fiança &nbsp;'.'<img src="'.Yii::$app->homeUrl.'icones/logo_site.png" alt="" width="30" style="float: right;margin-top: -20px;"></h4>'],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        // $pdf = Yii::$app->pdf;
        // $pdf->content = $htmlContent;

        return $pdf->render();
    }

    public function actionImagempdf($id){
        $documentais = \app\models\SloContratodocumento::find()->where(['slo_pretendente_id' => $id])->one();
        $im = new \Imagick(Yii::$app->basePath.'/web/uploads/propostasdocs/'.$documentais->id.'_versodoc_'.$documentais->verso_documento);
        $im->setImageFormat('jpg');
        header('Content-Type: image/jpeg');
        return $im;
    }

    public function actionProcessodelocacao() {
        if (Yii::$app->request->isAjax) {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            $val = filter_input(INPUT_POST, 'val', FILTER_SANITIZE_STRING);
            $pretendente_id = filter_input(INPUT_POST, 'pretendente_id', FILTER_SANITIZE_STRING);

            $model = Chtopico::findOne(['id' => $id]);
            $model->checked = $val=='true'?1:0;
            
            if ($model->save()){
                $estado_ativo = '';
                if($model->checked == 1){
                    $estado_ativo = '(Tópico Marcado) ';
                }else {
                    $estado_ativo = '(Tópico Desmarcado) ';
                }
                //ADD ao Histórico
                // if (Yii::$app->request->isAjax) {
                //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    $historico = new Historico();
                    $historico->categoria = 1;
                    $historico->data = date('yy-m-d h:i:s');
                    $historico->atividade = 'Atualização de Tópico';
                    $historico->descricao = $estado_ativo.$model->conteudo;
                    $historico->id_referencia = $pretendente_id;
                    $historico->save();
                // }
                return true;

            }
        }
        // return $this->redirect(Yii::$app->request->referrer);
    }

    public function addtopicoch($id_checklist, $conteudo, $etapa) {
        $topico = new Chtopico();
        $topico->checklist_id = $id_checklist;
        $topico->conteudo = $conteudo;
        $topico->etapa = $etapa;
        $topico->save();
    }
    public function actionNovotopico() {
        $model = new Chtopico();
        if ($model->load(Yii::$app->request->post())){
            if($model->save()){
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }
    public function actionEditregistro() {
        $id = $_REQUEST['id'];
        $val = $_REQUEST['province'];
        $model = Chtopico::findOne(['id' => $id]);
        $model->conteudo = $val;
        $model->save();
        return true;
    }
    public function actionDeletetopico($id) {
        Chtopico::findOne($id)->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }
}
