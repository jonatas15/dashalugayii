<?php

namespace app\controllers;

use Yii;
use app\models\Proprietario;
use app\models\ProprietarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use kartik\editable\Editable;
use yii\widgets\MaskedInput;

use yii\filters\AccessControl;

/**
 * ProprietarioController implements the CRUD actions for Proprietario model.
 */
class ProprietarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
      return [
          'access'=> [
              'class' => AccessControl::className(),
              //'only' => ['create','delete','update'],
              'rules' => [
                    ['actions' => ['update'],       'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['editcampo'],    'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['create'],       'allow' => true,   'roles' => ['faturas-create']],
                    ['actions' => ['novo'],         'allow' => true,   'roles' => ['faturas-create']],
                    ['actions' => ['index'],        'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['view'],         'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['cruzamento'],   'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['delete'],       'allow' => true,   'roles' => ['faturas-delete']],
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
     * Lists all Proprietario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProprietarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Proprietario model.
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
     * Creates a new Proprietario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Proprietario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Proprietario model.
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
     * Deletes an existing Proprietario model.
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
     * Finds the Proprietario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proprietario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proprietario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Campo Editável
     * 
     */
    public function formatar_data_pro_banco($data) {
        $arr = explode('/',$data);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }

    public function clean($string) {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
        return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
    }

    public function actionEditcampo($id, $tabela, $campo){
        // Yii::$app->homeUrl."alerta/sendwhats?msg=$mensagem&num=$fone"
        // echo $tabela;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $valor = $_REQUEST[$campo];
        switch ($tabela) {
            case 'SloProposta':
                $model = SloProposta::findOne($id);
            break;
            case 'Proprietario':
                $model = Proprietario::findOne($id);
            break;
        }
        // $model = SloProposta::findOne($id);
        switch ($campo) {
            case 'data': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_nascimento': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_expedicao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'documento_data_emissao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_admissao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'conj_data_nascimento': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'cpf': $model->$campo = $this->clean($valor); break;
            case 'conj_cpf': $model->$campo = $this->clean($valor); break;
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
    public function imprime_campo($tabela, $campo, $title, $valor, $id, $conj = null) {
        $input = Editable::INPUT_TEXT;
        $editableoptions = [
                'class'=>'form-control',
        ];
        $widgetClass = '';

        if (in_array($campo,['data', 'data_nascimento', 'data_expedicao', 'documento_data_emissao', 'data_admissao'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99/99/9999'
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['cpf', 'conj_cpf'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '999.999.999-99',
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
        if (in_array($campo,['celular', 'telefone_celular', 'whatsapp', 'telefone', 'fone', 'telefone_residencial','fone_residencial', 'fone_celular'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => ['(99)9999-9999','(99)99999-9999']
            ];
            $widgetClass = MaskedInput::className();
        }

        $retorno = '<label>'.$title.'</label><br />';
        $retorno .= Editable::widget([
            'language' => 'pt_BR',
            'name'=> $campo, 
            'asPopover' => false,
            'value' => $valor,
            'displayValue' => $valor,
            'header' => 'Name',
            'size'=>'md',
            'options' => $editableoptions,
            'inputType' => $input,
            'widgetClass' => $widgetClass,
            'id' => ($conj?'conjuge_':'').$tabela.'_invisivel_'.$campo,
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
        $retorno .= "<br>";
        $retorno .= "<br>";
        $retorno .= "<br>";
        return $retorno;
    }
    public function format_doc($doc,$tipo){
        switch ($tipo) {
            case 'cpf': $f = str_split($doc,3); $retorno = $f[0].'.'.$f[1].'.'.$f[2].'-'.$f[3]; break;
            case 'cep': $f = str_split($doc,5); $retorno = $f[0].'-'.$f[1]; break;
            case 'cnpj': 
                $f = str_split($doc,1); 
                // XX. XXX. XXX/0001-XX
                $retorno = $f[0].$f[1].'.'.$f[2].$f[3].$f[4].'.'.$f[5].$f[6].$f[7].'/'.$f[8].$f[9].$f[10].$f[11].'-'.$f[12].$f[13]; 
                break;
            default: $retorno = null; break;
        }
        return $retorno;        
    }
    public function imprime_campo_editavel($col_md, $tabela, $campo, $title, $valor, $id, $conj = null) {
        $input = Editable::INPUT_TEXT;
        $editableoptions = [
                'class'=>'form-control',
        ];
        $widgetClass = '';
        $valore = $valor;

        if (in_array($campo,['data', 'data_nascimento', 'data_expedicao', 'documento_data_emissao', 'data_admissao'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99/99/9999'
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['cpf', 'conj_cpf'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '999.999.999-99',
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
            if ($this->clean($valor) == 11) {
                $valore = $this->format_doc($valor, 'cpf');
            } else {
                $valore = $this->format_doc($valor, 'cnpj');
            }
        }
        if (in_array($campo,['celular', 'telefone_celular', 'whatsapp', 'telefone', 'fone', 'telefone_residencial','fone_residencial', 'fone_celular'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => ['(99)9999-9999','(99)99999-9999']
            ];
            $widgetClass = MaskedInput::className();
            $valore = $this->format_telefone($valor);
        }

        $retorno = '<label>'.$title.'</label><br />';
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
        $retorno .= "<br>";
        $retorno .= "<br>";
        $retorno .= "<br>";
        return '<div class="col-md-'.$col_md.'">'.$retorno.'</div>';
    }
}
