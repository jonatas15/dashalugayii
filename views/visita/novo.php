<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
// use yii\widgets\ActiveForm;

use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;

use app\models\Corretor;
use kartik\spinner\Spinner;

/* @var $this yii\web\View */
/* @var $model app\models\Visita */
/* @var $form yii\widgets\ActiveForm */
$estiloativo = '';
?>
<div class="visita-form">
<div class="visita-form col-md-12">
    
    <?php $form = ActiveForm::begin([
      'action'=> Yii::$app->homeUrl.'/visita/novo',
      'id'=>'form_'.$t
    ]); ?>

    <?= $form->field($model, 'usuario_id')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>
    <?= $form->field($model, 'data_registro')->hiddenInput(['value'=>date("Y-m-d H:i:s")])->label(false) ?>
    <?= $form->field($model, 'hora_visita')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'contrato')->hiddenInput(['value' => $contrato])->label(false) ?>

    
    <div class="col-md-6">
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
    <div class="col-md-5">
      <?= $form->field($model, 'codigo_imovel')->textInput(['type' => 'number','maxlength' => true, 'style'=>$estiloativo]) ?>
      <sup style="top: -1.5em;color:green">*em caso de visita de imóvel parceiro deixar em branco</sup>
    </div>
    <div class="col-md-12">
      <?php
        $corretores = ArrayHelper::map(Corretor::find()->asArray()->all(), 'idcorretor','nome');
        echo $form->field($model, 'o_corretor_'.$t)->widget(Select2::classname(), [
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
    
    <div class="col-md-12">
      <?= $form->field($model, 'nome_cliente')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-12">
      <?= $form->field($model, 'imobiliaria_parceria')->textInput(['maxlength' => true, 'style'=>$estiloativo]) ?>
    </div>
    <div class="col-md-12">
      <?= $form->field($model, 'observacoes')->textarea(['rows' => 6, 'style'=>$estiloativo]) ?>
    </div>
    <?php 
      $_loading = "";
      $_loading .= '<div class="border border-secondary p-3 rounded" id="loading_'.$t.'" style="display:none">';
      $_loading .= Spinner::widget(['preset' => 'large', 'align' => 'center', 'color' => 'green']);
        $_loading .= '<div class="clearfix"></div>';
      $_loading .= '</div>';
      echo $_loading;
    ?>
    <div class="form-group col-md-12">
        <?php 
          echo Html::submitButton("<span class='glyphicon glyphicon-ok'></span>  Salvar",['id' => 'botao_load_'.$t, 'class' => 'btn btn-success','onclick'=>'js:$("#cadastra-mais").val("0");js:$("#botao_load_'.$t.'").hide();$("#loading_'.$t.'").show();','style'=>'float: right']);
        ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<div class="clearfix"></div>
</div>