<?php

namespace app\controllers;

use Yii;
use app\models\Lead;
use app\models\LeadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use kartik\editable\Editable;
use yii\widgets\MaskedInput;

/**
 * LeadController implements the CRUD actions for Lead model.
 */
class LeadController extends Controller
{
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
     * Lists all Lead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lead model.
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
     * Creates a new Lead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lead();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lead model.
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
     * Deletes an existing Lead model.
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
     * Finds the Lead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lead::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function imprime_campo_editavel($col_md, $tabela, $campo, $title, $valor, $id, $conj = null) {
        $input = Editable::INPUT_TEXT;
        $editableoptions = [
                'class'=>'form-control',
        ];
        $widgetClass = '';
        $valore = $valor;
        $data = [];
        $displayValueConfig = [];

        $submitOnEnter = true;

        if (in_array($campo,['data', 'data_nascimento', 'cnj_data_nascimento', 'data_expedicao', 'documento_data_emissao', 'data_admissao', 'data_visita'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99/99/9999'
            ];
            $widgetClass = MaskedInput::className();
            $valor = $this->datadbtoview($valor);
            $valore = $valor;
        }
        if (in_array($campo,['cpf', 'cnj_cpf'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '999.999.999-99',
                'value' => $valor
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['feedbacks', 'descricao'])) {
            $input = Editable::INPUT_TEXTAREA;
            $editableoptions = [
                'class' => 'form-control',
                'value' => $valor,
                'rows'=>3, 
                'cols'=>80, 
                'placeholder'=>'Enter notes...'
            ];
            $submitOnEnter = false;
        }
        if (in_array($campo,['hora', 'hora_visita'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99:99:00',
                'value' => $valor
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['cep', 'end_cep'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99.999-999'
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['cpf_cnpj'])) {
            // XX. XXX. XXX/0001-XX
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => ['999.999.999-99', '99.999.999/9999-99'],
                'value' => $valor
            ];
            $widgetClass = MaskedInput::className();
            if (strlen($this->clean($valor)) == 11) {
                $valore = $this->format_doc($valor, 'cpf');
            } else {
                $valore = $this->format_doc($valor, 'cnpj');
            }
        }
        if (in_array($campo,['celular', 'telefone_celular', 'whatsapp', 'telefone', 'fone', 'telefone_residencial','fone_residencial', 'fone_celular', 'num_disparo'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => ['(99)9999-9999','(99)99999-9999']
            ];
            $widgetClass = MaskedInput::className();
            $valore = $this->format_telefone($valor);
        }
        if (in_array($campo,['sexo'])) {
            $input = Editable::INPUT_DROPDOWN_LIST;
            $data = ['M' => 'Masculino', 'F' => 'Feminino', 'I' => 'Indefinido'];
            switch ($valor) {
                case 'M': $valore = "Masculino"; break;
                case 'F': $valore = "Feminino"; break;
                case 'I': $valore = "Indefinido"; break;
                default: $valore = "Masculino"; break;
            }
            $displayValueConfig = [
                'M' => "Masculino",
                'F' => "Feminino",
                'I' => "Indefinido"
            ];
        }
        if (in_array($campo, ['tipovisitante'])) {
            $input = Editable::INPUT_DROPDOWN_LIST;
            $data = [ 'Corretor' => 'Corretor', 'Corretor externo' => 'Corretor externo', 'Cliente' => 'Cliente', ];
            $valore = $valor;
        }
        if ($title) {
            $retorno = '<label>'.$title.' </label>';
        }
        $retorno .= Editable::widget([
            'language' => 'pt_BR',
            'name'=> $campo, 
            'asPopover' => false,
            'value' => $valor,
            'displayValue' => $valore,
            'header' => 'Name',
            'size'=>'md',
            'options' => $editableoptions,
            'inputType' => $input,
            'widgetClass' => $widgetClass,
            'submitOnEnter' => $submitOnEnter,
            'data' => $data,
            'displayValueConfig'=> $displayValueConfig,
            'id' => ($conj?'conjuge_':'').$tabela.'_invisivel_'.$campo.'_'.$id,
            'formOptions' => [
                'action' => [
                    'editcampo',
                    'id' => $id,
                    'tabela' => $tabela,
                    'campo' => $campo
                ]
            ],
            'valueIfNull' => 'valor alterado'
        ]);
        if ($title) {
            $retorno .= "<br>";
        }
        return '<div class="col-md-'.$col_md.'">'.$retorno.'</div>';
    }
    public function actionEditcampo($id, $tabela, $campo){
        // Yii::$app->homeUrl."alerta/sendwhats?msg=$mensagem&num=$fone"
        // echo $tabela;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $valor = $_REQUEST[$campo];
        $model = $this->findModel($id);
        // $model = SloProposta::findOne($id);
        switch ($campo) {
            case 'data': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_nascimento': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_expedicao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'documento_data_emissao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_admissao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'cnj_data_nascimento': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_visita': $model->$campo = $this->dataviewtodb($valor); break;
            case 'cpf': $model->$campo = $this->clean($valor); break;
            case 'cnj_cpf': $model->$campo = $this->clean($valor); break;
            case 'cep': $model->$campo = $this->clean($valor); break;
            case 'end_cep': $model->$campo = $this->clean($valor); break;
            case 'celular': $model->$campo = $this->clean($valor); break;
            case 'telefone': $model->$campo = $this->clean($valor); break;
            case 'fone_celular': $model->$campo = $this->clean($valor); break;
            case 'fone_residencial': $model->$campo = $this->clean($valor); break;
            default: $model->$campo = $valor; break;
        }
        $model->save(); 
        // return 1;
        // return $this->redirect(Yii::$app->request->referrer);
        return ['output'=>$valor, 'message'=>''];
    }
    public function format_telefone($fone){
        $fone = $this->clean($fone);
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
    public function clean($string) {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
        return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
    }
}
