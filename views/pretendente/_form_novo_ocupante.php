<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\form\ActiveForm;
// use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-md-12">
    <?php $form = ActiveForm::begin([
        'action'=>'novomorador',
    ]); ?>
    <div class="col-md-4 hidden">
        <?= $form->field($model, 'slo_pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-5">
        <?= $form->field($model, 'sexo')->dropDownList([ 'M' => 'Masculino', 'F' => 'Feminino', ], ['prompt' => '']) ?>
    </div>

    <div class="col-md-7">
        <?php //= $form->field($model, 'cpf')->widget(MaskedInput::className(), ['mask' => '999.999.999-99',]) ?>
        <?= $form->field($model, 'cpf')->widget(MaskedInput::className(), [
                'mask'  => '999.999.999-99',
                'options'=>[
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                ]
            ]);
        ?>
    </div>

    <div class="col-md-5">
        <?= $form->field($model, 'tipo_documento')->dropDownList([ 'RG' => 'RG', 'RNE' => 'RNE', 'CNH' => 'CNH', 'Doc de Classe' => 'Doc de Classe', ], ['prompt' => '']) ?>
    </div>

    <div class="col-md-7">
        <?= $form->field($model, 'numero_documento')->textInput(['maxlength' => true,'type'=>'number']) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'data_expedicao')->widget(MaskedInput::className(), [
                'clientOptions' => ['alias' =>  'dd/mm/yyyy'],
                'options'=>[
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                ]
            ]);
        ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'orgao_expedidor')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'data_nascimento')->widget(MaskedInput::className(), [
                'clientOptions' => ['alias' =>  'dd/mm/yyyy'],
                'options'=>[
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                ]
            ]);
        ?>
    </div>
    <img src="" alt="">
    <div class="col-md-12">
        <div class="form-group float-right">
            <?= Html::submitButton('SALVAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary', 'style'=>'font-weight: bolder']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<div class="clearfix"></div>