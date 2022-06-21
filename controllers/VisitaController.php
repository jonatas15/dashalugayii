<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

use app\models\Visita;
use app\models\VisitaSearch;
use app\models\Corretor;

/**
 * VisitaController implements the CRUD actions for Visita model.
 */
class VisitaController extends Controller
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
                  ['actions' => ['update'],       'allow' => true,   'roles' => ['faturas-update']],
                  ['actions' => ['editregistro'], 'allow' => true,   'roles' => ['faturas-update']],
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
     * Lists all Visita models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VisitaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Visita model.
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
     * Creates a new Visita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Visita();

        if ($model->load(Yii::$app->request->post())) {


          $model->data_visita = date("Y-m-d H:i:s", strtotime($model->data_visita));
          $os = Corretor::find()->select('idcorretor')->asArray()->all();
          $corretores = [];
          foreach ($os as $key => $value) {
            array_push($corretores,$value['idcorretor']);
          }
          if(in_array($model->o_corretor, $corretores)){
            $model->id_corretor = $model->o_corretor;
          }else{
            $novo_corretor = new Corretor();
            $novo_corretor->nome = $model->o_corretor;
            $novo_corretor->save();
            $model->id_corretor = $novo_corretor->idcorretor;
          }
          if($_REQUEST['cadastra_mais'] and !empty($_REQUEST['cadastra_mais']) and $_REQUEST['cadastra_mais'] == 1){
            if ($model->save()) {
              Yii::$app->session->setFlash('success', "Registro Salvo com sucesso! Inciando outro registro:");
              return $this->render('create', [
                'model' => $model,
                'cadastra_mais' => 1,
                'info'=>'Registro Salvo com sucesso! Inciando outro registro'
              ]);
            }
          }else{
            if ($model->save()) {
              return $this->redirect(['index']);
            }
          }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionNovo()
    {
        $model = new Visita();

        if ($model->load(Yii::$app->request->post())) {


          $model->data_visita = date("Y-m-d H:i:s", strtotime($model->data_visita));
          $os = Corretor::find()->select('idcorretor')->asArray()->all();
          $corretores = [];

          if ($_REQUEST['Visita']['o_corretor_1']) {$o_corretor = $_REQUEST['Visita']['o_corretor_1'];}
          elseif ($_REQUEST['Visita']['o_corretor_2']) {$o_corretor = $_REQUEST['Visita']['o_corretor_2'];}
          else{$o_corretor = 'Indefinido';}

          foreach ($os as $key => $value) {
            array_push($corretores,$value['idcorretor']);
          }
          if(in_array($o_corretor, $corretores)){
            $model->id_corretor = $o_corretor;
          }else{
            $novo_corretor = new Corretor();
            $novo_corretor->nome = $o_corretor;
            $novo_corretor->save();
            $model->id_corretor = $novo_corretor->idcorretor;
          }
          
          if ($model->save()) {
            return $this->redirect(['index']);
          }
          
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Visita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->data_visita = date("Y-m-d H:i:s", strtotime($model->data_visita));
            $os = Corretor::find()->select('idcorretor')->asArray()->all();
            $corretores = [];
            foreach ($os as $key => $value) {
              array_push($corretores,$value['idcorretor']);
            }

            if (in_array($model->o_corretor, $corretores)) {
              $model->id_corretor = $model->o_corretor;
            } else {
              $novo_corretor = new Corretor();
              $novo_corretor->nome = $model->o_corretor;
              $novo_corretor->save();
              $model->id_corretor = $novo_corretor->idcorretor;
            }

            if ($model->save()) {
              return $this->redirect(['index'] );
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionEditregistro(){
        $model = $this->findModel($_REQUEST['editableKey']);
        $edit_index = $_REQUEST['editableIndex'];
        $model->convertido = $_REQUEST['Visita'][$edit_index]['convertido'];
        if($model->save()){
          if ($model->convertido == 0) {
            return $this->redirect(Yii::$app->request->referrer);
          }
          return $model->convertido == 0 ? 0:1;
        }
    }

    /**
     * Deletes an existing Visita model.
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
     * Finds the Visita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Visita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Visita::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Imprime campos editávels
     */
    public function imprime_campo_editavel($col_md, $tabela, $campo, $title, $valor, $id, $conj = null) {
      $input = Editable::INPUT_TEXT;
      $editableoptions = [
              'class'=>'form-control',
      ];
      $widgetClass = '';
      $valore = $valor;
      $data = [];
      $displayValueConfig = [];

      if (in_array($campo,['data', 'data_nascimento', 'cnj_data_nascimento', 'data_expedicao', 'documento_data_emissao', 'data_admissao'])) {
          $input = Editable::INPUT_WIDGET;
          $editableoptions = [
              'class' => 'form-control',
              'mask' => '99/99/9999'
          ];
          $widgetClass = MaskedInput::className();
          $valore = date('d/m/Y', strtotime($valor));
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
          if (strlen($this->clean($valor)) == 11) {
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
      if ($title) {
          $retorno = '<label>'.$title.'</label><br />';
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
          $retorno .= "<br>";
          $retorno .= "<br>";
      }
      return '<div class="col-md-'.$col_md.'">'.$retorno.'</div>';
  }
}
