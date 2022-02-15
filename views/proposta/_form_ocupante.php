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
        'action'=>'editocp?id='.$model->id,
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
        <?php 
            echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
            echo '<label class="control-label has-star" for="">CPF:</label>';
            echo MaskedInput::widget([
                'name'  => 'editado_cpf',
                'mask'  => '999.999.999-99',
                'value' => $model->cpf,
                'options'=>[
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                ]
            ]);
            echo '<div class="help-block"></div>';
            echo "</div>";
        ?>
    </div>

    <div class="col-md-5">
        <?= $form->field($model, 'tipo_documento')->dropDownList([ 'RG' => 'RG', 'RNE' => 'RNE', 'CNH' => 'CNH', 'Doc de Classe' => 'Doc de Classe', ], ['prompt' => '']) ?>
    </div>

    <div class="col-md-7">
        <?= $form->field($model, 'numero_documento')->textInput(['maxlength' => true,'type'=>'number']) ?>
    </div>

    <div class="col-md-4">
        <?php 
            echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
            echo '<label class="control-label has-star" for="">Data de Expedição:</label>';
            echo MaskedInput::widget([
                'name'  => 'editado_data_expedicao',
                'clientOptions' => [
                    'alias' =>  'dd/mm/yyyy',
                    'placeholder' => 'dd/mm/aaaa',
                ],
                'value' => date('d/m/Y',strtotime($model->data_expedicao)),
                'options'=>[
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                ]
            ]);
            echo '<div class="help-block"></div>';
            echo "</div>";
        ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'orgao_expedidor')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
        <?php 
            echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
            echo '<label class="control-label has-star" for="">Data de Nascimento:</label>';
            echo MaskedInput::widget([
                'name'  => 'editado_data_nascimento',
                'clientOptions' => [
                    'alias' =>  'dd/mm/yyyy',
                    'placeholder' => 'dd/mm/aaaa',
                ],
                'value' => date('d/m/Y',strtotime($model->data_nascimento)),
                'options'=>[
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                ]
            ]);
            echo '<div class="help-block"></div>';
            echo "</div>";
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