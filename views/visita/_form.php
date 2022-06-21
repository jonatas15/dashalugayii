<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
// use yii\widgets\ActiveForm;

use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\spinner\Spinner;

use app\models\Corretor;

/* @var $this yii\web\View */
/* @var $model app\models\Visita */
/* @var $form yii\widgets\ActiveForm */
$estiloativo = '';
if($_REQUEST['cadastra_mais'] and $_REQUEST['cadastra_mais'] == 1){
  $estiloativo = 'border: 1px solid blue;';
}
?>

<div class="visita-form col-md-12">
    
    <?php $form = ActiveForm::begin(['id'=>'form_'.$t]); ?>

    <?= $form->field($model, 'usuario_id')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>
    <?= $form->field($model, 'data_registro')->hiddenInput(['value'=>date("Y-m-d H:i:s")])->label(false) ?>
    <?= $form->field($model, 'hora_visita')->hiddenInput()->label(false) ?>
    

    <div class="col-md-12">
      <div class="col-md-4">
        <div class="form-group field-visita-id_corretor has-success">
          <?php //= $form->field($model, 'data_visita')->textInput()
            // echo '<label class="control-label">Data</label>';
            // echo DatePicker::widget([
            //   'language'=>'pt',
            //   'name' => 'Visita[data_visita]',
            //   'type' => DatePicker::TYPE_COMPONENT_PREPEND,
            //   'value' => $model->isNewRecord ? '':date('d-m-Y', strtotime($model->data_visita)),
            //   'pluginOptions' => [
            //       'autoclose'=>true,
            //       'format' => 'dd-mm-yyyy'
            //   ]
            // ]);
          ?>
          <?= $form->field($model, 'data_visita')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99/99/9999',
          ]) ?>
          <div class="help-block"></div>
        </div>
      </div>
      <div class="col-md-4">
        <?php
          $corretores = ArrayHelper::map(Corretor::find()->asArray()->all(), 'idcorretor','nome');
          echo $form->field($model, 'o_corretor')->widget(Select2::classname(), [
              'data' => $corretores,
              'language' => 'pt',
              'options' => [
                  'value'=> $model->isNewRecord ? '':$model->id_corretor,
                  'placeholder' => 'Selecione o Corretor ou digite um novo nome',
                  'multiple' => false
              ],
              'pluginOptions' => [
                  'tags' => true,
                  'allowClear' => true,
                  // 'maximumInputLength' => 10
              ],
          ]);
        ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($model, 'nome_cliente')->textInput(['maxlength' => true]) ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-4">
        <?= $form->field($model, 'codigo_imovel')->textInput(['type' => 'number','maxlength' => true, 'style'=>$estiloativo]) ?>
        <sup style="top: -1.5em;color:green">*em caso de visita de imóvel parceiro deixar em branco</sup>
        <div style="margin-top: -10px;">
        <?= $form->field($model, 'imobiliaria_parceria')->textInput(['maxlength' => true, 'style'=>$estiloativo]) ?>
        </div>
      </div>
      <div class="col-md-4">
        <?php if(!empty($contrato)): ?>
        <?= $form->field($model, 'contrato')->hiddenInput(['value' => $contrato])->label(false) ?>
        <?php else: ?>
        <?= $form->field($model, 'contrato')->dropDownList([ 'Venda' => 'Venda', 'Locação' => 'Locação', ], ['prompt' => '']) ?>
        <?php endif; ?>
      </div>
      <div class="col-md-8">
        <?= $form->field($model, 'observacoes')->textarea(['rows' => 6, 'style'=>$estiloativo]) ?>
      </div>
    </div>
    <?php 
      $_loading = "";
      $_loading .= '<div class="border border-secondary p-3 rounded" id="loading_all" style="display:none">';
      $_loading .= Spinner::widget(['preset' => 'large', 'align' => 'center', 'color' => 'green']);
        $_loading .= '<div class="clearfix"></div>';
      $_loading .= '</div>';
      echo $_loading;
    ?>
    <div class="form-group col-md-12">
        <?php 
          if ($model->isNewRecord || $_REQUEST['cadastra_mais']) {
            echo "<input type='hidden' value='1' name='cadastra_mais' id='cadastra-mais'>";
            echo Html::submitButton('<span class="glyphicon glyphicon-plus"></span> Salvar e cadastrar outra Visita', ['class' => 'btn btn-primary botao_load_xx', 'onclick' => 'js:$(".botao_load_xx").hide();js:$("#loading_all").show()']); 
          }
        ?>
        <?php 
        if (!$_REQUEST['cadastra_mais']) {
          echo Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-ok"></span> Salvar e Encerrar' : 'Atualizar', ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary').' botao_load_xx','style'=>'float:right','onclick'=>'js:$("#cadastra-mais").val("0");']);
        }else{
            echo Html::submitButton("<span class='glyphicon glyphicon-ok'></span>   Salvar e Encerrar",['class' => 'btn btn-success botao_load_xx','onclick'=>'js:$("#cadastra-mais").val("0");js:$(".botao_load_xx").hide();js:$("#loading_all").show()','style'=>'float: right']);
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
